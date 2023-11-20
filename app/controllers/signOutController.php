<?php

// Nouveau contrôleur pour gérer la déconnexion
class SignOutController
{
    public function signOut()
    {
        session_start();

        // Détruire toutes les données de session
        session_destroy();

        // Rediriger vers la page d'accueil (ou une autre page de votre choix)
        header("Location: /Site-e-commerce");
        exit();
    }
}

?>
