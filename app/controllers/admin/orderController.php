<?php

class OrderController
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabaseModel();
        $this->conn = $this->db->getDatabaseConnection();
    }

    public function showOrders()
    {
        $this->checkAuthentication();

        echo "<div class='bg-black text-white p-4 mb-4'>";
        echo "<h1 class='text-3xl font-bold'>Gestion des commandes</h1>";
        echo "</div>";

        $this->showOrderTable();

        echo "</div>";
    }

    private function showOrderTable()
    {
        echo "<table class='min-w-full divide-y divide-gray-200'>";
        echo "<thead class='bg-gray-800'>";
        echo "<tr>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>ID Commande</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>Utilisateur</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>Total</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>Statut</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody class='bg-white divide-y divide-gray-200'>";

        $orders = $this->getAllOrders();

        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>{$order['order_id']}</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>{$order['user_id']}</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>{$order['total']}</td>";
            echo "<form method='POST' action='?action=updateOrderStatus'>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>";
            echo "<select name='status' class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg'>";
            echo "<option value='en attente'" . ($order['status'] == 'en attente' ? ' selected' : '') . ">En attente</option>";
            echo "<option value='valide'" . ($order['status'] == 'valide' ? ' selected' : '') . ">Validé</option>";
            echo "<option value='refuse'" . ($order['status'] == 'refuse' ? ' selected' : '') . ">Refusé</option>";
            echo "</select>";
            echo "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>";
            echo "<input type='hidden' name='order_id' value='{$order['order_id']}'>";
            echo "<button type='submit' class='text-indigo-600 hover:text-indigo-900'>Mettre à jour</button>";
            echo "</td>";
            echo "</form>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    private function getAllOrders()
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM orders");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    private function checkAuthentication()
    {
        if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated'] || !$this->isAdmin()) {
            header("Location: ?action=signIn");
            exit();
        }
    }

    private function isAdmin()
    {
        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->prepare("SELECT isAdmin FROM admin WHERE id = :userId");
            $stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->execute();

            $isAdmin = $stmt->fetchColumn();

            return $isAdmin == 1;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
    public function updateOrderStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'], $_POST['status'])) {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];

            try {
                $stmt = $this->conn->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
                $stmt->execute(['status' => $status, 'order_id' => $orderId]);
                header("Location: ?action=admin/orders");
            } catch (PDOException $e) {
                echo "Erreur lors de la mise à jour de la commande : " . $e->getMessage();
            }
        }
    }
}
