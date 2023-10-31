<?php

class DatabaseModel {
    private $db;

    public function __construct() {
        require 'vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable('C:\XAMPP NWS\htdocs\Site-e-commerce');
        $dotenv->load();

        $dbHost = $_ENV['DB_HOST'];
        $dbDatabase = $_ENV['DB_DATABASE'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];

        try {
            $this->db = new PDO("mysql:host=$dbHost;dbname=$dbDatabase", $dbUsername, $dbPassword);
            echo "connexion réussie";
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}
