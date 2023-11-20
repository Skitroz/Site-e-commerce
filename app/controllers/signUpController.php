<?php

class SignUpController
{
    public function showSignUpForm()
    {
        ob_start();
        $form = "
        <div class='mx-auto max-w-md mt-8'>
            <h2 class='text-3xl font-bold mb-4 text-center'>Inscription</h2>
            <form action='?action=signUp' method='POST'>
                <div class='mb-4'>
                    <label for='username' class='block text-sm font-medium text-gray-700'>Nom d'utilisateur</label>
                    <input type='text' name='username' class='mt-1 p-2 w-full border rounded-md'>
                </div>
                <div class='mb-4'>
                    <label for='firstname' class='block text-sm font-medium text-gray-700'>Prénom</label>
                    <input type='text' name='firstname' class='mt-1 p-2 w-full border rounded-md'>
                </div>
                <div class='mb-4'>
                    <label for='lastname' class='block text-sm font-medium text-gray-700'>Nom</label>
                    <input type='text' name='lastname' class='mt-1 p-2 w-full border rounded-md'>
                </div>
                <div class='mb-4'>
                    <label for='email' class='block text-sm font-medium text-gray-700'>Adresse e-mail</label>
                    <input type='email' name='email' class='mt-1 p-2 w-full border rounded-md'>
                </div>
                <div class='mb-4'>
                    <label for='password' class='block text-sm font-medium text-gray-700'>Mot de passe</label>
                    <input type='password' name='password' class='mt-1 p-2 w-full border rounded-md'>
                </div>
                <div class='mb-4'>
                    <button type='submit' class='bg-blue-500 text-white py-2 px-4 rounded-md'>S'inscrire</button>
                </div>
            </form>
        </div>
        ";

        echo $form;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'signUp') {
            $this->registerUser();
        }
        ob_end_flush();
    }

    private function registerUser()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        try {
            $db = new DatabaseModel();
            $conn = $db->getDatabaseConnection();

            $stmt = $conn->prepare("INSERT INTO admin (username, firstname, lastname, email, password) VALUES (:username, :firstname, :lastname, :email, :password)");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);

            $stmt->execute();

            header("Location: ?action=signIn");
            exit();
        } catch (PDOException $e) {
            echo "Erreur d'inscription : " . $e->getMessage();
        }
    }
}

?>
