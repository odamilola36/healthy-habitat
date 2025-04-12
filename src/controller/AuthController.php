<?php

require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/CouncilModel.php';

class AuthController {
    private $userModel;
    private $councilModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->councilModel = new CouncilModel();
    }

    public function showLoginForm() {
        include __DIR__ . '/../view/login.php';
    }
    public function showRegisterForm() {
        include __DIR__ . '/../view/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = $this->userModel->findUserByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                if ($user['role'] == 'council') {
                    header('Location: /council_dashboard.php');
                } elseif ($user['role'] == 'business') {
                    header('Location: /business_dashboard.php');
                } elseif ($user['role'] == 'resident') {
                    header('Location: /resident_dashboard.php');
                }
                exit();
            } else {
                echo "Invalid credentials.";
            }
        }

        // Render login form (View)
        include __DIR__ . '/../view/login.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login.php');
        exit();
    }
}
