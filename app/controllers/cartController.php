<?php
class CartController {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new DatabaseModel();
        $this->conn = $this->db->getDatabaseConnection();
    }

    public function showCart() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        echo "<!DOCTYPE html>";
        echo "<html lang='fr'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Votre Panier</title>";
        echo "<link href='https://cdn.tailwindcss.com' rel='stylesheet'>";
        echo "</head>";
        echo "<body class='bg-gray-100'>";

        echo "<div class='container mx-auto mt-10 max-w-4xl'>";
        echo "<form action='?action=updateCart' method='POST'>";
        echo "<div class='shadow-md my-10'>";
        echo "<div class='bg-white px-10 py-10'>";
        echo "<div class='flex justify-between border-b pb-8'>";
        echo "<h1 class='font-semibold text-2xl'>Votre Panier</h1>";
        $articleCount = array_sum($_SESSION['cart'] ?? []);
        echo "<h2 class='font-semibold text-2xl'>" . $articleCount . " Articles</h2>";
        echo "</div>";
        echo "<div class='flex mt-10 mb-5'>";
        echo "<h3 class='font-semibold text-gray-600 text-xs uppercase w-2/5'>Détails du Produit</h3>";
        echo "<h3 class='font-semibold text-center text-gray-600 text-xs uppercase w-1/5'>Quantité</h3>";
        echo "<h3 class='font-semibold text-center text-gray-600 text-xs uppercase w-1/5'>Prix</h3>";
        echo "<h3 class='font-semibold text-center text-gray-600 text-xs uppercase w-1/5'>Total</h3>";
        echo "</div>";

        $totalPrice = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = :id");
                $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $itemTotal = $product['price'] * $quantity;
                    $totalPrice += $itemTotal;

                    echo "<div class='flex items-center hover:bg-gray-100 -mx-8 px-6 py-5'>";
                    echo "<div class='flex w-2/5'>";
                    echo "<div class='w-20'>";
                    echo "<img class='h-24' src='{$product['image_url']}' alt='{$product['name']}'>";
                    echo "</div>";
                    echo "<div class='flex flex-col justify-between ml-4 flex-grow'>";
                    echo "<span class='font-bold text-sm'>{$product['name']}</span>";
                    echo "<span class='text-red-500 text-xs'>{$product['category']}</span>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='flex justify-center w-1/5'>";
                    echo "<input type='number' name='quantity[$productId]' value='{$quantity}' min='0' class='w-12 text-center bg-gray-100'>";
                    echo "</div>";
                    echo "<span class='text-center w-1/5 font-semibold text-sm'>{$product['price']} €</span>";
                    echo "<span class='text-center w-1/5 font-semibold text-sm'>{$itemTotal} €</span>";
                    echo "</div>";
                }
            }
        } else {
            echo "<p class='text-center'>Votre panier est vide.</p>";
        }

        echo "<div class='flex justify-between items-center mt-10'>";
        echo "<button type='submit' class='bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded'>Mettre à jour le panier</button>";
        echo "<h2 class='font-semibold text-2xl'>Total TTC : " . number_format($totalPrice, 2) . " €</h2>";
        echo "</div>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
        echo "<div class='flex justify-between mt-10'>";
        echo "<a href='/Site-e-commerce' class='bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded'>Continuer mes achats</a>";
        echo "<a href='?action=checkout' class='bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded'>Valider le panier</a>";
        echo "</div>";

        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $productId => $quantity) {
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$productId]);
                } else {
                    $_SESSION['cart'][$productId] = $quantity;
                }
            }
    
            $totalItems = 0;
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $totalItems += $quantity;
            }
    
            $_SESSION['totalItems'] = $totalItems;
        }
    
        header('Location: ?action=showCart');
        exit;
    }
    private function calculateTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $total += $this->getProductPrice($productId) * $quantity;
        }
        return $total;
    }

    private function getProductPrice($productId) {
        $stmt = $this->conn->prepare("SELECT price FROM product WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetchColumn();
    }
    public function checkout() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "Votre panier est vide.";
            return;
        }

        try {
            $this->conn->beginTransaction();

            $userId = $_SESSION['user_id'];
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, order_date, total) VALUES (:user_id, NOW(), :total)");
            $total = $this->calculateTotal();
            $stmt->execute(['user_id' => $userId, 'total' => $total]);

            $orderId = $this->conn->lastInsertId();

            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $stmt = $this->conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                $price = $this->getProductPrice($productId);
                $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity, 'price' => $price]);
            }

            $this->conn->commit();

            $_SESSION['cart'] = array();

            echo "Commande enregistré avec succès, en attente de validation par l'administrateur du site.";
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Erreur lors de la validation de la commande : " . $e->getMessage();
        }
    }
}
?>
