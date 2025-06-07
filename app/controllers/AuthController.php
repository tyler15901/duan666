<?php
namespace App\Controllers;
use App\Models\User;

class AuthController
{
    protected $db;
    public function __construct($db) { $this->db = $db; }

    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User($this->db);
            $user = $userModel->findByEmail($_POST['email']);
            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                if ($user['role'] === 'candidate') {
                    header('Location: /candidate/dashboard');
                } else {
                    header('Location: /recruiter/dashboard');
                }
                exit;
            } else {
                $error = "Sai email hoặc mật khẩu!";
            }
        }
        include __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User($this->db);
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $role = $_POST['role'] ?? 'candidate';
            if ($userModel->findByEmail($email)) {
                $error = "Email đã tồn tại!";
            } else {
                $userModel->create($email, $name, $password, $role);
                header('Location: /login');
                exit;
            }
        }
        include __DIR__ . '/../views/auth/register.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
