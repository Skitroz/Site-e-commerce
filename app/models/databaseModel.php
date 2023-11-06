<?php

class DatabaseModel {
    private $db;

    public function __construct() {
        require 'vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable('C:\xampp-nws\htdocs\Site-e-commerce');
        $dotenv->load();

        $dbHost = $_ENV['DB_HOST'];
        $dbDatabase = $_ENV['DB_DATABASE'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];

        try {
            $this->db = new PDO("mysql:host=$dbHost;dbname=$dbDatabase", $dbUsername, $dbPassword);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getDatabaseConnection() {
        return $this->db;
    }
}
