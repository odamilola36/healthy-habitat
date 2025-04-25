<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');
set_exception_handler('handleException');
set_error_handler('handleError');

function handleException($e)
{
    error_log($e);
    http_response_code(500);
    header("Location: /500.php");
    exit;
}

function handleError($errno, $errstr, $errfile, $errline)
{
    error_log("Error [$errno] $errstr in $errfile on line $errline");
    http_response_code(500);
    header("Location: /500.php");
    exit;
}
//start session
session_start();

require_once __DIR__ . '/../src/autoloader.php';
require_once __DIR__ . '/../src/service/database.php';
require_once __DIR__ . '/../src/controller/AuthController.php';
require_once __DIR__ . '/../src/controller/ProductController.php';
require_once __DIR__ . '/../src/model/AuthUtil.php';

//initialize system variables
$db = Database::getInstance()->getConnection();
$productController = new ProductController();
$authController = new AuthController();
$authUtil = new AuthUtil();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];


if (($requestUri == '/' || $requestUri == '/index.php') && $requestMethod == 'GET') {
    $key = isset($_GET['key']) ? $_GET['key'] : [];
    $value = isset($_GET['value']) ? $_GET['value'] : [];
    $productController->showHome($key, $value);
} elseif ($requestUri == '/login.php' && $requestMethod == 'GET') {
    $authController->showLoginForm();
} elseif (preg_match('/^\/product-details\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'GET') {
    $authUtil->requiresLogin();
    $productController->showProduct($matches[1]);
} elseif ($requestUri == '/register.php' && $requestMethod == 'GET') {
    $authController->showRegisterForm();
} elseif ($requestUri == '/register.php' && $requestMethod == 'POST') {
    $authController->register($_POST);
} elseif ($requestUri == '/login.php' && $requestMethod == 'POST') {
    $authController->login($_POST);
} elseif ($requestUri == '/product-details/vote.php' && $requestMethod == 'POST') {
    $authUtil->requiresResident();
    $productController->vote($_POST);
} elseif ($requestUri == '/resident.php' && $requestMethod == 'GET') {
    $authUtil->requiresResident();
    $key = isset($_GET['key']) ? $_GET['key'] : [];
    $value = isset($_GET['value']) ? $_GET['value'] : [];
    $productController->showResidentHome($key, $value);
} elseif ($requestUri == '/council-page.php' && $requestMethod == 'GET') {
    $authUtil->requiresCouncil();
    $productController->showCouncilPageHome();
} elseif ($requestUri == '/business-page.php' && $requestMethod == 'GET') {
    $authUtil->requiresBusiness();
    $productController->showBusinessHome();
} elseif ($requestUri == '/logout.php' && $requestMethod == 'GET') {
    $authController->logout();
} elseif ($requestUri == '/add-product.php' && $requestMethod == 'GET') {
    $authUtil->requiresBusiness();
    $productController->showAddProductForm();
} elseif ($requestUri == '/add-product.php' && $requestMethod == 'POST') {
    $authUtil->requiresBusiness();
    $productController->createProduct($_POST);
} elseif ($requestUri == '/areas.php' && $requestMethod == 'GET') {
    $authUtil->requiresCouncil();
    $productController->showAreas();
} elseif ($requestUri == '/add-area.php' && $requestMethod == 'GET') {
    $authUtil->requiresCouncil();
    $productController->showAddAreaForm();
} elseif ($requestUri == '/add-area.php' && $requestMethod == 'POST') {
    $authUtil->requiresCouncil();
    $productController->createArea($_POST);
} elseif ($requestUri == '/businesses.php' && $requestMethod == 'GET') {
    $authUtil->requiresCouncil();
    $productController->showBusinesses();
} elseif ($requestUri == '/add-category.php' && $requestMethod == 'GET') {
    $authUtil->requiresCouncil();
    $productController->showAddCategoryForm();
} elseif ($requestUri == '/add-category.php' && $requestMethod == 'POST') {
    $authUtil->requiresCouncil();
    $productController->createCategory($_POST);
} elseif ($requestUri == '/categories.php' && $requestMethod == 'GET') {
    $authUtil->requiresCouncil();
    $productController->showCategories();
} elseif (preg_match('/^\/edit-product\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'GET') {
    $authUtil->requiresBusiness();
    $productController->showEditProductForm($matches[1]);
} elseif (preg_match('/^\/edit-product\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'POST') {
    $authUtil->requiresBusiness();
    $productController->editProduct($matches[1], $_POST);
} elseif ($requestUri == '/500.php' && $requestMethod == 'GET') {
    $authController->showErrorPage();
} else {
    $authController->showNotFound();
}
