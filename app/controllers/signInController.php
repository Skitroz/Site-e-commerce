<?php

class SignInController {
    
    public function showSignInForm()
    {
        $form = "
        <div class='mx-auto max-w-md mt-8'>
            <h2 class='text-3xl font-bold mb-4 text-center'>Connexion</h2>
            <form action='?action=signIn' method='POST'>
                <div class='mb-4'>
                    <label for='username' class='block text-sm font-medium text-gray-700'>Nom d'utilisateur</label>
                    <input type='text' name='username' class='mt-1 p-2 w-full border rounded-md'>
                </div>
                <div class='mb-4'>
                    <label for='password' class='block text-sm font-medium text-gray-700'>Mot de passe</label>
                    <input type='password' name='password' class='mt-1 p-2 w-full border rounded-md'>
                </div>
                <div class='mb-4'>
                    <button type='submit' class='bg-blue-500 text-white py-2 px-4 rounded-md'>Se connecter</button>
                </div>
            </form>
        </div>
        ";

        echo $form;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'signIn') {
            $this->signInUser();
        }
    }

    private function signInUser()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                ob_start();
                header("Location: ?action=admin/dashboard");
                ob_end_flush();
                exit();
            } else {
                echo "<p class='text-center text-red-600 font-bold'>Nom d'utilisateur ou mot de passe incorrect.</p>";
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
    }
}

?>