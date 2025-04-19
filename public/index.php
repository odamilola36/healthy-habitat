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
}  elseif (preg_match('/^\/product-details\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'GET') {
    $productController->showProduct($matches[1]);
} elseif ($requestUri == '/register.php' && $requestMethod == 'GET') {
    $authController->showRegisterForm();
} elseif ($requestUri == '/register' && $requestMethod == 'POST') {
    $controller = new ResidentController();
    $controller->registerResident($_POST);
} elseif ($requestUri == '/resident.php' && $requestMethod == 'GET') {
    $productController->showResidents();
} elseif ($requestUri == '/council.php' && $requestMethod == 'GET') {
    include __DIR__ . '/../src/view/council.php';
} else {
    // 404 Not Found
    header("HTTP/1.0 404 Not Found");
    echo "404 Page not found";
}
