<?php
class TopSellingModel {
    public function topSelling() {
        $db = new DatabaseModel();
        $conn = $db->getDatabaseConnection();
        $stmt = $conn->query("SELECT * FROM product LIMIT 2");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<section class='flex flex-col mx-auto items-center justify-center mt-10'>";
        echo "<h2 class='text-2xl font-bold mb-4 flex-justify-between items-center'>Meilleures Ventes</h2>";

        echo "<div class='grid grid-cols-2 gap-4'>";
        
        foreach ($products as $result) {
            echo "<li class='bg-gray-800 p-6 rounded shadow-md text-white'>";
            echo "<a href='?action=detailProduct&id={$result['id']}'><img src='" . $result['image_url'] . "' alt='" . $result['name'] . "' class='mb-4 w-full h-80 object-cover'></a>";
            echo "<h3 class='text-lg font-semibold mb-2'>" . $result['name'] . "</h3>";
            echo "<p class='text-blue-700 font-bold'>" . $result['category'] . "</p>";
            echo "<p class='text-white font-bold'>" . $result['price'] . " €</p>";
            echo "</li>";
        }
        echo "</div>";
        echo "</section>";
    }
}

?>
