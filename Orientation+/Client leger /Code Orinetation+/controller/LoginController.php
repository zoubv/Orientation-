<?php
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../bdd/bdd.php';

class LoginController {
    private $userModel;

    public function __construct() {
        $db = Database::connect();
        $this->userModel = new User($db);
    }

    public function login() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs.';
            } else {
                $user = $this->userModel->login($email, $password);

                if ($user) {
                    session_start();
                    $_SESSION['user'] = $user;
                    header('Location: dashboard.php'); // Remplacez par votre tableau de bord
                    exit();
                } else {
                    $error = 'Identifiants incorrects.';
                }
            }
        }

        require __DIR__ . '/../view/login.php';
    }
}
