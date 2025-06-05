<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
    
session_start();// Démarre la session pour vérifier si l'utilisateur est connecté
include 'bdd/bdd.php'; 
                               

                                                                                                                                                                                                                                            
include "view/commun/header.php";

// Système de routage
$page = isset($_GET["page"]) ? $_GET["page"] : "accueil";


// Pages accessibles sans connexion
$pages_libres = ["accueil", "login", "register", "registerAction", "loginAction"];

// Vérification : Rediriger vers la page de connexion si non connecté
if (!isset($_SESSION['user_id']) && !in_array($page, $pages_libres)) {
    header("Location: index.php?page=login");
    exit();
}

switch ($page) {
    case "accueil":
        include "view/accueil.php";
        break;

    case "fiche_metier":
        include "view/fiche_Metier.php";
        break;
        case "details_domaines":
            include "view/details_domaines.php";
            break;

            case "details_metier":
                include "view/details_metier.php";
                break;
    case "interview":
        include "view/interview.php";
        break;

    case "domaines":
        include "view/domaines.php";
        break;

    case "informatique_detailles":
        include "view/informatique_detailles.php";
        break;

    case "sante":
        include "view/sante_details.php";
        break;

    case "login":
        include "view/login.php";
        break;
    case "register":
        include "view/register.php";
        break;
    case "loginAction":
        include "view/loginAction.php";
        break;
    case "registerAction":
            include "view/registerAction.php";
            break;
    case "logout":
            include "view/logout.php";
            break;
    case "Pdf":
            include "view/Pdf.php";
            break;
    case "upload":
            include "view/upload.php";
            break;
    case "mentor":
            include "view/mentor.php";
            break;
    case "filtre_domaines":
            include "view/filtre_domaines.php";
            break;
    case "doc_domaines":
            include "view/doc_domaines.php";
            break;
    case "doc_metiers":
            include "view/doc_metiers.php";
            break;
    case "details":
        include "view/details.php";
        break;

        case "edit_domaine":
            include "view/edit_domaine.php";
            break;

            case "edit_metier":
                include "view/edit_metier.php";
                break;

    case "ajouter_metier":
                include "view/ajouter_metier.php";
                break;

            case "dashboard":
                include "view/dashboard.php";
                break;
                case "delete_metier":
                    include "view/delete_metier.php";
                    break;
                
    

            case "delete_domaine":
                include "view/delete_domaine.php";
                break;
            
    

    case "ajouter_details":
        include "view/ajouter_details.php";
        break;

    case "afficher_details":
        include "view/afficher_details.php";
        break;
        

        case "insert_details":
            include "view/insert_details.php";
            break;

       case "voir_pdf":
            include "view/voir_pdf.php";
            break;    

        case "voir_interview":
            include "view/voir_interview.php";
            break;    
    default:
        include "view/accueil.php"; 
        break;
}

// Inclusion du footer
include "view/commun/footer.php";
?>