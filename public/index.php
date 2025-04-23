<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//start session
session_start();

require_once __DIR__ . '/../src/autoloader.php';
require_once __DIR__ . '/../src/service/database.php';
require_once __DIR__ . '/../src/controller/AuthController.php';
require_once __DIR__ . '/../src/controller/ProductController.php';

//initialize system variables
$db = Database::getInstance()->getConnection();
$productController = new ProductController();
$authController = new AuthController();

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];


if (($requestUri == '/' || $requestUri == '/index.php') && $requestMethod == 'GET') {
    $productController->showHome();
} elseif ($requestUri == '/login.php' && $requestMethod == 'GET') {
    $authController->showLoginForm();
} elseif (preg_match('/^\/product-details\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'GET') {
    $productController->showProduct($matches[1]);
} elseif ($requestUri == '/register.php' && $requestMethod == 'GET') {
    $authController->showRegisterForm();
} elseif ($requestUri == '/register.php' && $requestMethod == 'POST') {
    $authController->register($_POST);
} elseif ($requestUri == '/login.php' && $requestMethod == 'POST') {
    $authController->login($_POST);
} elseif ($requestUri == '/product-details/vote.php' && $requestMethod == 'POST') {
    $productController->vote($_POST);
} elseif ($requestUri == '/resident.php' && $requestMethod == 'GET') {
    $productController->showResidentHome();
} elseif ($requestUri == '/council-page.php' && $requestMethod == 'GET') {
    $productController->showCouncilPageHome();
} elseif ($requestUri == '/business-page.php' && $requestMethod == 'GET') {
    $productController->showBusinessHome();
} elseif ($requestUri == '/logout.php' && $requestMethod == 'GET') {
    $authController->logout();
} elseif ($requestUri == '/add-product.php' && $requestMethod == 'GET') {
    $productController->showAddProductForm();
} elseif ($requestUri == '/add-product.php' && $requestMethod == 'POST') {
    $productController->createProduct($_POST);
} elseif ($requestUri == '/areas.php' && $requestMethod == 'GET') {
    $productController->showAreas();
} elseif ($requestUri == '/add-area.php' && $requestMethod == 'GET') {
    $productController->showAddAreaForm();
} elseif ($requestUri == '/add-area.php' && $requestMethod == 'POST') {
    $productController->createArea($_POST);
} elseif ($requestUri == '/businesses.php' && $requestMethod == 'GET') {
    $productController->showBusinesses();
} elseif ($requestUri == '/add-category.php' && $requestMethod == 'GET') {
    $productController->showAddCategoryForm();
} elseif ($requestUri == '/add-category.php' && $requestMethod == 'POST') {
    $productController->createCategory($_POST);
} elseif ($requestUri == '/categories.php' && $requestMethod == 'GET') {
    $productController->showCategories();
} elseif (preg_match('/^\/edit-product\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'GET') {
    $productController->showEditProductForm($matches[1]);
} elseif ($requestUri == '/edit-product.php' && $requestMethod == 'POST') {
    $productController->createProduct($_POST);
} else {
    // 404 Not Found

    header("HTTP/1.0 404 Not Found");
    echo "$requestUri";
    echo "404 Page not found";
}
