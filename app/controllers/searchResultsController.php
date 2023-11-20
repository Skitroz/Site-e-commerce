<?php
// searchResults.php

require 'vendor/autoload.php';

class SearchResults
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseModel();
    }

    public function searchProducts($searchTerm)
    {
        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->prepare("SELECT * FROM product WHERE name LIKE :searchTerm");
            $searchTerm = '%' . $searchTerm . '%';
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function displayResults()
    {
        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

        if (!empty($searchTerm)) {
            $results = $this->searchProducts($searchTerm);

            echo "<div class='mx-auto max-w-screen-lg'>";
            echo "<h2 class='text-3xl font-bold mb-4 text-center text-black mt-10'>Résultat de la recherche pour '$searchTerm' :</h2>";

            if (empty($results)) {
                echo "<p class='text-red-500 text-center'>Aucun résultat trouvé.</p>";
            } else {
                echo "<ul class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8'>";
                foreach ($results as $result) {
                    echo "<li class='bg-gray-800 p-6 rounded shadow-md text-white'>";
                    echo "<a href='?action=detailProduct&id={$result['id']}'><img src='" . $result['image_url'] . "' alt='" . $result['name'] . "' class='mb-4 w-full h-40 object-cover'>";
                    echo "<h3 class='text-lg font-semibold mb-2'>" . $result['name'] . "</h3>";
                    echo "<p class='text-blue-700 font-bold'>" . $result['category'] . "</p>";
                    echo "<p class='text-white font-bold'>" . $result['price'] . " €</p>";
                    echo "</li>";
                }
                echo "</ul>";
            }
            echo "</div>";
        }
    }
}

$searchResults = new SearchResults();
$searchResults->displayResults();

?>