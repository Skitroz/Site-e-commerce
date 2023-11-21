<?php
class TopSellingModel {
    public function topSelling() {
        $db = new DatabaseModel();
        $conn = $db->getDatabaseConnection();

        $stmt = $conn->query("SELECT * FROM product WHERE isShowcasing = 'oui' ");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<section class='flex flex-col mx-auto items-center justify-center mt-10'>";
        echo "<h2 class='text-2xl font-bold mb-4'>Articles en Vedette</h2>";
        echo "<div class='grid grid-cols-2 gap-4'>";
        
        foreach ($products as $result) {
            echo "<div class='bg-gray-800 p-6 rounded shadow-md text-white'>";
            echo "<a href='?action=detailProduct&id={$result['id']}'>";
            echo "<img src='" . $result['image_url'] . "' alt='" . $result['name'] . "' class='mb-4 w-full h-80 object-cover'>";
            echo "</a>";
            echo "<h3 class='text-lg font-semibold mb-2'>" . $result['name'] . "</h3>";
            echo "<p class='text-blue-500 font-bold'>" . $result['category'] . "</p>";
            echo "<p class='text-white font-bold'>" . number_format($result['price'], 2) . " €</p>";
            echo "</div>";
        }
        
        echo "</div>";
        echo "</section>";
    }
}

?>
