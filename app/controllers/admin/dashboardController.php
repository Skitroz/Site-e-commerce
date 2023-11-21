<?php

class DashboardController
{
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

        // Bloc Gérer les Articles
        echo "<div class='bg-white p-6 rounded shadow-md'>";
        echo "<h2 class='text-xl font-bold mb-4'>Gérer les Articles</h2>";

        $this->showArticleTable();

        echo "</div>"; // Fermeture du bloc Gérer les Articles

        // Bloc Créer un Article
        echo "<div class='bg-white p-6 rounded shadow-md'>";
        echo "<h2 class='text-xl font-bold mb-4'>Créer un Article</h2>";

        // Afficher le message de succès ou d'erreur ici, avant le formulaire
        $this->createArticle();

        // Formulaire pour créer un nouvel article
        echo "<form method='POST' action='' class='max-w-sm'>";
        echo "<div class='mb-4'>";
        echo "<label for='articleName' class='block text-sm font-medium text-gray-700'>Nom de l'article</label>";
        echo "<input type='text' name='articleName' id='articleName' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articleDescription' class='block text-sm font-medium text-gray-700'>Description de l'article</label>";
        echo "<textarea name='articleDescription' id='articleDescription' class='mt-1 p-2 w-full border rounded-md' required></textarea>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articleCategory' class='block text-sm font-medium text-gray-700'>Catégorie</label>";
        echo "<input type='text' name='articleCategory' id='articleCategory' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articlePrice' class='block text-sm font-medium text-gray-700'>Prix</label>";
        echo "<input type='text' name='articlePrice' id='articlePrice' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articleImageURL' class='block text-sm font-medium text-gray-700'>URL de l'image ('exemple : https://i.imgur.com/phfcGEY.jpg')</label>";
        echo "<input type='text' name='articleImageURL' id='articleImageURL' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='isShowcasing' class='block text-sm font-medium text-gray-700'>Mettre en avant</label>";
        echo "<select name='isShowcasing' id='isShowcasing' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "<option value='non'>Non</option>";
        echo "<option value='oui'>Oui</option>";
        echo "</select>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<button type='submit' name='createArticle' class='bg-blue-500 text-white py-2 px-4 rounded-md'>Créer l'article</button>";
        echo "</div>";
        echo "</form>";

        echo "</div>"; // Fermeture du bloc Créer un Article

        // Bloc Derniers Articles
        echo "<div class='bg-white p-6 rounded shadow-md'>";
        echo "<h2 class='text-xl font-bold mb-4'>Derniers Articles</h2>";

        $latestArticles = $this->getLatestArticles();

        if (count($latestArticles) > 0) {
            echo "<ul class='list-disc pl-6'>";
            foreach ($latestArticles as $article) {
                echo "<li class='underline'><a href='?action=detailProduct&id={$article['id']}' target='_blank'>{$article['name']}</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun article trouvé.</p>";
        }

        echo "</div>"; // Fermeture du bloc Derniers Articles

        echo "</div>"; // Fermeture de la grille

        echo "</div>"; // Fermeture du conteneur max-w-screen-lg

        echo "</div>"; // Fermeture du conteneur mx-auto

    }

    public function showEditForm($article) {
        echo "<div class='flex justify-center items-center min-h-screen'>";
        echo "<form method='POST' action='?action=updateArticle&id=" . $article['id'] . "' class='max-w-sm w-full'>";
        echo "<div class='mb-4'>";
        echo "<label for='articleName' class='block text-sm font-medium text-gray-700'>Nom de l'article</label>";
        echo "<input type='text' name='articleName' id='articleName' value='" . htmlspecialchars($article['name']) . "' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articleDescription' class='block text-sm font-medium text-gray-700'>Description de l'article</label>";
        echo "<textarea name='articleDescription' id='articleDescription' class='mt-1 p-2 w-full border rounded-md' required>" . htmlspecialchars($article['description']) . "</textarea>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articleCategory' class='block text-sm font-medium text-gray-700'>Catégorie</label>";
        echo "<input type='text' name='articleCategory' id='articleCategory' value='" . htmlspecialchars($article['category']) . "' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articlePrice' class='block text-sm font-medium text-gray-700'>Prix</label>";
        echo "<input type='number' step='0.01' name='articlePrice' id='articlePrice' value='" . htmlspecialchars($article['price']) . "' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='articleImageURL' class='block text-sm font-medium text-gray-700'>URL de l'image</label>";
        echo "<input type='text' name='articleImageURL' id='articleImageURL' value='" . htmlspecialchars($article['image_url']) . "' class='mt-1 p-2 w-full border rounded-md' required>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<label for='isShowcasing' class='block text-sm font-medium text-gray-700'>Mettre en avant</label>";
        echo "<select name='isShowcasing' id='isShowcasing' class='mt-1 p-2 w-full border rounded-md'>";
        echo "<option value='non' " . ($article['isShowcasing'] == 'non' ? 'selected' : '') . ">Non</option>";
        echo "<option value='oui' " . ($article['isShowcasing'] == 'oui' ? 'selected' : '') . ">Oui</option>";
        echo "</select>";
        echo "</div>";
        echo "<div class='mb-4'>";
        echo "<button type='submit' name='updateArticle' class='bg-blue-500 text-white py-2 px-4 rounded-md'>Mettre à jour l'article</button>";
        echo "</form>";
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
            echo "<td class='px-6 py-4 whitespace-nowrap'>";

            // Limiter la longueur du nom à 10 caractères avec des points de suspension
            $shortenedName = strlen($article['name']) > 10 ? substr($article['name'], 0, 30) . '...' : $article['name'];
            echo $shortenedName;

            echo "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>";
            echo "<a href='?action=editArticle&id={$article['id']}' class='text-blue-500 mr-2'><i class='fa-regular fa-pen-to-square'></i></a>";
            echo "<a href='?action=deleteArticle&id={$article['id']}' class='text-red-500 delete-article' data-article-id='{$article['id']}'><i class='fa-regular fa-trash-can'></i></a>";
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

            $stmt = $conn->query("SELECT * FROM product ORDER BY id");
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

            return $isAdmin == 1; // Vérifie si le statut isAdmin est égal à 1
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // Fonction pour traiter la création d'un nouvel article
    public function createArticle()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createArticle'])) {
            $articleName = $_POST['articleName'];
            $articleDescription = $_POST['articleDescription'];
            $articleCategory = $_POST['articleCategory'];
            $articlePrice = $_POST['articlePrice'];
            $articleImageURL = $_POST['articleImageURL'];
            $isShowcasing = $_POST['isShowcasing'] ?? 'non';

            try {
                // Connectez-vous à votre base de données
                $db = new DatabaseModel();
                $conn = $db->getDatabaseConnection();

                // Préparez la requête d'insertion
                $stmt = $conn->prepare("INSERT INTO product (name, description, category, price, image_url, isShowcasing) VALUES (:name, :description, :category, :price, :image_url, :isShowcasing)");
                $stmt->bindParam(':name', $articleName, PDO::PARAM_STR);
                $stmt->bindParam(':description', $articleDescription, PDO::PARAM_STR);
                $stmt->bindParam(':category', $articleCategory, PDO::PARAM_STR);
                $stmt->bindParam(':price', $articlePrice, PDO::PARAM_STR);
                $stmt->bindParam(':image_url', $articleImageURL, PDO::PARAM_STR);
                $stmt->bindParam(':isShowcasing', $isShowcasing, PDO::PARAM_STR);

                // Exécutez la requête
                if ($stmt->execute()) {
                    // Article créé avec succès
                    echo "<p class='text-green-500'>L'article a été créé avec succès.</p>";
                } else {
                    // Erreur lors de la création de l'article
                    echo "<p class='text-red-500'>Une erreur s'est produite lors de la création de l'article.</p>";
                }
            } catch (PDOException $e) {
                // Gestion des erreurs de base de données
                echo "<p class='text-red-500'>Erreur de base de données : " . $e->getMessage() . "</p>";
            }
        }
    }
    public function deleteArticle($articleId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'deleteArticle' && isset($_GET['id'])) {
            $articleId = $_GET['id'];

            try {
                // Connectez-vous à votre base de données
                $db = new DatabaseModel();
                $conn = $db->getDatabaseConnection();

                // Préparez la requête de suppression
                $stmt = $conn->prepare("DELETE FROM product WHERE id = :id");
                $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);

                // Exécutez la requête
                if ($stmt->execute()) {
                    // Article supprimé avec succès
                    header("Location: ?action=admin/dashboard");
                    exit();
                } else {
                    // Erreur lors de la suppression de l'article
                    echo "<p class='text-red-500'>Une erreur s'est produite lors de la suppression de l'article.</p>";
                }
            } catch (PDOException $e) {
                // Gestion des erreurs de base de données
                echo "<p class='text-red-500'>Erreur de base de données : " . $e->getMessage() . "</p>";
            }
        }
    }

    public function editArticle($articleId) {
        // S'assurer que l'utilisateur est authentifié et a les droits d'administration
        $this->checkAuthentication();

        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id");
            $stmt->execute(['id' => $articleId]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($article) {
                // Affichage du formulaire avec les données de l'article
                $this->showEditForm($article);
            } else {
                echo "<p class='text-red-500'>Article introuvable.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='text-red-500'>Erreur de base de données : " . $e->getMessage() . "</p>";
        }
    }

    public function updateArticle($articleId, $data) {
        $this->checkAuthentication();

        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->prepare("UPDATE product SET name = :name, description = :description, category = :category, price = :price, image_url = :image_url, isShowcasing = :isShowcasing WHERE id = :id");

            // Lier les paramètres et exécuter la requête
            $stmt->execute([
                ':name' => $data['articleName'],
                ':description' => $data['articleDescription'],
                ':category' => $data['articleCategory'],
                ':price' => $data['articlePrice'],
                ':image_url' => $data['articleImageURL'],
                ':isShowcasing' => $data['isShowcasing'],
                ':id' => $articleId
            ]);

            if ($stmt->rowCount()) {
                header("Location: ?action=admin/dashboard");
                echo "<p class='text-green-500'>L'article a été mis à jour avec succès.</p>";
            } else {
                echo "<p class='text-yellow-500'>Aucune modification n'a été faite.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='text-red-500'>Erreur de base de données : " . $e->getMessage() . "</p>";
        }
    }
}
?>