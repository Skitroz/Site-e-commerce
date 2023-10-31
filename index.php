<?php
require 'vendor/autoload.php';
require 'app/models/DatabaseModel.php';
require 'app/controllers/productsController.php';
require 'app/controllers/notFoundController.php';
require 'app/controllers/homeController.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'products':
            $controller = new ProductController();
            break;
        default:
            $controller = new NotFoundController();
            $controller->notFound();
            break;
    }
} else {
    $controller = new HomeController();
    $controller->index();
}
