<?php
session_start();
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
require 'app/controllers/cartController.php';
require 'app/controllers/admin/orderController.php';
require 'app/controllers/telephoneProductsController.php';
require 'app/controllers/tabletteProductsController.php';
require 'app/controllers/ordinateurProductsController.php';

function addProductToCart($productId) {
    $productId = $_GET['id'];
    $quantity = $_POST['quantity'] ?? 1; // Utilisez la quantité soumise ou par défaut à 1

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 0;
    }
    $_SESSION['cart'][$productId] += $quantity;

    // Rediriger vers la page du panier
    header('Location: ?action=showCart');
    exit;
}

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
        case 'admin/orders':
            $orderController = new OrderController();
            $orderController->showOrders();
            break;
        case 'updateOrderStatus':
            $orderController = new OrderController();
            $orderController->updateOrderStatus();
            break;
        case 'detailProduct':
            $modelPageController = new ModelPage();
            $modelPageController->showModel($_GET['id']);
            break;
        default:
            $controller = new NotFoundController();
            $controller->notFound();
            break;
        case 'signOut':
            $signOutController = new SignOutController();
            $signOutController->signOut();
            break;
        case 'deleteArticle':
            $dashboardController = new DashboardController();
            if (isset($_GET['id'])) {
                $dashboardController->deleteArticle($_GET['id']);
            }
            break;
        case 'addtocart':
            addProductToCart($_GET['id']);
            header('Location: ?action=showCart'); // Redirigez vers la page du panier
            break;
        case 'showCart':
            $cartController = new CartController();
            $cartController->showCart();
            break;
        case 'updateCart':
            $cartController = new CartController();
            $cartController->updateCart();
            break;
        case 'checkout':
            $cartController = new CartController();
            $cartController->checkout();
            break;
        case 'editArticle':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $dashboardController = new DashboardController();
                $dashboardController->editArticle($_GET['id']);
            } else {
                echo "<p class='text-red-500'>ID de l'article non spécifié ou invalide.</p>";
            }
            break;
        case 'updateArticle':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $dashboardController = new DashboardController();
                $dashboardController->updateArticle($_GET['id'], $_POST);
            } else {
                echo "<p class='text-red-500'>ID de l'article non spécifié ou invalide pour la mise à jour.</p>";
            }
            break;
        case 'telephoneProducts':
            $telephoneController = new TelephoneProductsController();
            $telephoneController->showTelephoneProducts();
            break;
        case 'tabletteProducts':
            $telephoneController = new TabletteProducsController();
            $telephoneController->showTabletteProducts();
            break;
        case 'ordinateurProducts':
            $telephoneController = new OrdinateurProducsController();
            $telephoneController->showOrdinateurProducts();
            break;
    }
} else {
    $controller = new HomeController();
    $controller->index();
}
?>
