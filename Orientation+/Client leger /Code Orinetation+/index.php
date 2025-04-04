<?php
// Chargement des fichiers nécessaires
require_once __DIR__ . '/controller/LoginController.php';

// Inclusion du header commun
include __DIR__ . "/view/commun/header.php";

// Initialisation du contrôleur de connexion
$loginController = new LoginController();

// Système de routage
$page = isset($_GET["page"]) ? htmlspecialchars($_GET["page"]) : "accueil";

switch ($page) {
    case "accueil":
        include __DIR__ . "/view/accueil.php";
        break;

    case "register":
        include __DIR__ . "/view/register.php";
        break;

    case "interview":
        include __DIR__ . "/view/interview.php";
        break;

    case "domaines":
        include __DIR__ . "/view/domaines.php";
        break;

    case "login":
        include "/view/login.php";
        $loginController->login(); // Appel du contrôleur pour gérer la page de connexion
        break;

    default:
        include __DIR__ . "/view/accueil.php"; // Page par défaut : Accueil
        break;
}

// Inclusion du footer commun
include __DIR__ . "/view/commun/footer.php";
?>
