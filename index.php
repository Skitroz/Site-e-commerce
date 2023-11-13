<?php
require './templates/header.template.php';

$headerTemplate = new HeaderTemplate();
$headerTemplate->header();

require 'vendor/autoload.php';
require 'app/models/DatabaseModel.php';
require 'app/controllers/productsController.php';
require 'app/controllers/notFoundController.php';
require 'app/controllers/homeController.php';
require 'app/controllers/searchResultsController.php';
require 'app/controllers/signUpController.php';
require 'app/controllers/signInController.php';
require 'app/controllers/admin/dashboardController.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'products':
            $controller = new ProductController();
            break;
        case 'searchResult':
            $controller = new SearchResults();
            break;
        case 'signUp':
            $signUpController = new SignUpController();
            $signUpController->showSignUpForm();
            break;
        case 'signIn':
            $signInController = new SignInController();
            $signInController->showSignInForm();
            break;
        case 'admin/dashboard':
            $dashboardController = new DashboardController();
            $dashboardController->showDashboard();
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
?>
