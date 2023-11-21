<?php

class TelephoneProductsController {

    private $db;
    private $conn;

    public function __construct() {
        $this->db = new DatabaseModel();
        $this->conn = $this->db->getDatabaseConnection();
    }

    public function showTelephoneProducts() {
        $telephoneProducts = $this->getTelephoneProducts();
        $this->displayProducts($telephoneProducts);
    }

    private function getTelephoneProducts() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM product WHERE category = :category");
            $stmt->bindParam(':category', $category);
            $category = 'telephone';
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    private function displayProducts($products) {
        echo "<div class='mx-auto max-w-screen-lg mt-10'>";
        echo "<ul class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8'>";
        foreach ($products as $result) {
            echo "<li class='bg-gray-800 p-6 rounded shadow-md text-white'>";
            echo "<a href='?action=detailProduct&id={$result['id']}'><img src='" . $result['image_url'] . "' alt='" . $result['name'] . "' class='mb-4 w-full h-40 object-cover'>";
            echo "<h3 class='text-lg font-semibold mb-2'>" . $result['name'] . "</h3>";
            echo "<p class='text-blue-700 font-bold'>" . $result['category'] . "</p>";
            echo "<p class='text-white font-bold'>" . $result['price'] . " €</p>";
            echo "</li>";
        }
        echo "</ul>";
        echo "</div>";

        if (empty($result)){
            echo "<p class='text-red-500 text-center'>Aucun résultat.</p>";
        }
    }
}
?>