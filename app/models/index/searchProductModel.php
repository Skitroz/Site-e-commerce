<?php

class SearchProductModel
{
    public function search()
    {
        if (isset($_GET['btnSearchBar'])) {
            $searchTerm = $_GET['searchBar'];
            $results = $this->searchProducts($searchTerm);
            $this->displaySearchResults($results);
        } else {
        }
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

    public function displaySearchResults($results)
    {
        if (empty($results)) {
            echo "Aucun résultat trouvé.";
        } else {
            echo "<h2>Résultats de la recherche :</h2>";
            echo "<ul>";
            foreach ($results as $result) {
                echo "<li>" . $result['name'] . "</li>";
                echo "<li>" . $result['description'] . "</li>";
                echo "<li>" . $result['category'] . "</li>";
                echo "<li>" . $result['price'] . "</li>";
            }
            echo "</ul>";
        }
    }
}
