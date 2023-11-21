<?php
class ModelPage {
    public function showModel($productId) {
        $db = new DatabaseModel();
        $conn = $db->getDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id");
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<section class='mx-auto mt-10'>";
        echo "<div class='max-w-2xl mx-auto bg-white p-8 rounded shadow-md'>";
        echo "<img src='{$product['image_url']}' alt='{$product['name']}' class='mb-6 w-full h-80 object-cover rounded-md'>";
        echo "<h2 class='text-3xl font-bold mb-4'>{$product['name']}</h2>";
        echo "<p class='text-blue-700 font-bold mb-2'>Catégorie: {$product['category']}</p>";
        echo "<p class='text-gray-800 mb-4'>{$product['description']}</p>";
        echo "<p class='text-white font-bold text-xl'>Prix : {$product['price']} €</p>";

        // Formulaire pour ajouter au panier avec quantité
        echo "<form action='?action=addtocart&id=$productId' method='POST'>";
        echo "<input type='number' name='quantity' value='1' min='1' class='w-16 text-center bg-gray-100 py-1'>";
        echo "<button type='submit' class='bg-blue-500 text-white py-2 px-4 rounded-md ml-2'>Ajouter au panier</button>";
        echo "</form>";

        echo "</div>";
        echo "</section>";
    }
}
?>
