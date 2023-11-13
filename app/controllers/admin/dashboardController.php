<?php

class DashboardController {

    public function showDashboard()
    {
        $this->checkAuthentication();

        echo "<div class='bg-black text-white p-4 mb-4'>";
        echo "<h1 class='text-3xl font-bold'>Tableau de bord</h1>";
        echo "</div>";

        echo "<div class='mx-auto max-w-screen-lg'>";
        echo "<div class='grid grid-cols-2 gap-4'>";
        
        echo "<div class='bg-white p-6 rounded shadow-md'>";
        echo "<h2 class='text-xl font-bold mb-4'>Statistiques</h2>";

        $userCount = $this->getUserCount();
        echo "<p>Utilisateurs enregistrés : $userCount</p>";

        $articleCount = $this->getArticleCount();
        echo "<p>Articles publiés : $articleCount</p>";

        echo "</div>";

        echo "<div class='bg-white p-6 rounded shadow-md'>";
        echo "<h2 class='text-xl font-bold mb-4'>Derniers Articles</h2>";

        $latestArticles = $this->getLatestArticles();
        
        if (count($latestArticles) > 0) {
            echo "<ul class='list-disc pl-6'>";
            foreach ($latestArticles as $article) {
                echo "<li>{$article['name']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun article trouvé.</p>";
        }

        echo "</div>";

        echo "<div class='bg-white p-6 rounded shadow-md'>";
        echo "<h2 class='text-xl font-bold mb-4'>Gérer les Articles</h2>";

        $this->showArticleTable();

        echo "</div>";

        echo "</div>";

        echo "</div>";
    }

    private function showArticleTable()
    {
        echo "<table class='min-w-full divide-y divide-gray-200'>";
        echo "<thead class='bg-gray-800'>";
        echo "<tr>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>ID</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>Nom</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider'>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody class='bg-white divide-y divide-gray-200'>";

        $articles = $this->getAllArticles();

        foreach ($articles as $article) {
            echo "<tr>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>{$article['id']}</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>{$article['name']}</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>";
            echo "<a href='?action=editArticle&id={$article['id']}' class='text-blue-500 mr-2'><i class='fa-regular fa-pen-to-square'></i></a>";
            echo "<a href='?action=deleteArticle&id={$article['id']}' class='text-red-500'><i class='fa-regular fa-trash-can'></i></a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    private function getAllArticles()
    {
        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->query("SELECT * FROM product");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    private function getUserCount()
    {
        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->query("SELECT COUNT(*) FROM admin");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return 0;
        }
    }

    private function getArticleCount()
    {
        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->query("SELECT COUNT(*) FROM product");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return 0;
        }
    }

    private function getLatestArticles()
    {
        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->query("SELECT * FROM product ORDER BY id DESC LIMIT 3");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }
    private function checkAuthentication()
    {
        session_start();

        if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
            header("Location: ?action=signIn");
            exit();
        }
    }
}

?>