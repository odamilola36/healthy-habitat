<?php

class AuthUtil
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function requiresResident()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['returnTo'] = $_SERVER['REQUEST_URI'];
            header('Location: /login.php');
            exit;
        }
        $user = $this->userModel->findUserById($_SESSION['user_id']);
        if ($user['role'] !== 'resident') {
            header('Location: /index.php');
            exit;
        }
    }
    public function requiresBusiness()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['returnTo'] = $_SERVER['REQUEST_URI'];
            header('Location: /login.php');
            exit;
        }
        $user = $this->userModel->findUserById($_SESSION['user_id']);
        if ($user['role'] !== 'business') {
            header('Location: /index.php');
            exit;
        }
    }
    public function requiresCouncil()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['returnTo'] = $_SERVER['REQUEST_URI'];
            header('Location: /login.php');
            exit;
        }
        $user = $this->userModel->findUserById($_SESSION['user_id']);
        if ($user['role'] !== 'council') {
            header('Location: /index.php');
            exit;
        }
    }
    public function requiresLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['returnTo'] = $_SERVER['REQUEST_URI'];
            header('Location: /login.php');
            exit;
        }
    }
}