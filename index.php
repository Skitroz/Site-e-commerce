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
require 'app/models/modelProductPage.php'; 
require 'app/controllers/signOutController.php';

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
        case 'detailProduct':
            $modelPageController = new ModelPage(); // Utilisez le même nom ici
            $modelPageController->showModel($_GET['id']);
            break;
        default:
            $controller = new NotFoundController();
            $controller->notFound();
            break;
        case 'signOut': // Nouveau cas pour la déconnexion
            $signOutController = new SignOutController();
            $signOutController->signOut();
            break;
    }
} else {
    $controller = new HomeController();
    $controller->index();
}
?>
