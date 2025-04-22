<?php

require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/CouncilModel.php';
require_once __DIR__ . '/../model/BusinessModel.php';
require_once __DIR__ . '/../model/ResidentModel.php';

class AuthController
{
    private $userModel;
    private $councilModel;
    private $businessModel;
    private $residentModel;
    private $areaModel;
    private $productModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->councilModel = new CouncilModel();
        $this->businessModel = new BusinessModel();
        $this->residentModel = new ResidentModel();
        $this->areaModel = new AreaModel();
        $this->productModel = new ProductModel();
    }

    public function showLoginForm()
    {
        include __DIR__ . '/../view/login.php';
    }
    public function showRegisterForm()
    {
        $areas = $this->areaModel->getAllAreas();
        $categories = $this->productModel->getAllCategories();
        include __DIR__ . '/../view/register.php';
    }

    public function register($postData)
    {

        $this->userModel->findUserByUsername($postData['email']);
        $password = password_hash($postData['password'], PASSWORD_BCRYPT);


        var_dump($postData);

        // Insert user into the database
        $userId = $this->userModel->createUser(
            $postData['email'],
            $password,
            $postData['role'],
            $postData['telephone'],
            $postData['city'],
            $postData['postcode'],
            $postData['address']
        );


        // Insert role-specific data
        if ($postData['role'] == 'business') {
            $this->businessModel->createBusiness($userId, $postData['businessName'], $postData['regNumber']);
        } elseif ($postData['role'] == 'resident') {
            $this->residentModel->createResident($userId, $postData['firstname'], $postData['lastname'], $postData['gender'], $postData['agegroup'], $postData['area']);
        } elseif ($postData['role'] == 'council') {
            $this->councilModel->createCouncil($userId, $postData['councilName']);
        }

        // Redirect to login page after successful registration
        header('Location: /login.php');
        exit();
    }

    public function login($postData)
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->userModel->findUserByUsername($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                $returnTo = $_SESSION['returnTo'];

                if ($returnTo) {
                    header('Location: ' . $returnTo);
                    $_SESSION['returnTo'] = null;
                } else if ($user['role'] == 'council') {
                    header('Location: /council_page.php');
                } elseif ($user['role'] == 'business') {
                    header('Location: /businesses.php');
                } elseif ($user['role'] == 'resident') {
                    header('Location: /resident.php');
                }
                exit();
            } else {
                $login_error = "Invalid credentials.";
            }
        } else {
            $login_error = "No account found with that email.";
        }


        include __DIR__ . '/../view/login.php';
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login.php');
        exit();
    }
}
