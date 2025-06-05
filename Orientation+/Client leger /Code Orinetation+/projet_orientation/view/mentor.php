<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Démarrer la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}  

// Connexion à la base de données
include 'bdd/bdd.php'; 
$pdo = db_connect();

if (!$pdo) {
    die("Impossible de se connecter à la base de données");
}

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour faire une demande de mentorat.");
}

$id_utilisateur = $_SESSION['user_id'];

// Vérifier si l'utilisateur a déjà fait une demande de mentorat
$query_check = "SELECT * FROM demandes_mentor WHERE id_utilisateur = ?";
$stmt_check = $pdo->prepare($query_check);
$stmt_check->execute([$id_utilisateur]);
$demande_existante = $stmt_check->fetch();

// Récupérer les informations de l'utilisateur
$query_user = "SELECT * FROM utilisateur WHERE id_utilisateur = ?";
$stmt_user = $pdo->prepare($query_user);
$stmt_user->execute([$id_utilisateur]);
$user = $stmt_user->fetch();

if ($user['role'] !== 'eleve') {
    die("Seuls les lycéens peuvent s'inscrire pour avoir un mentor.");
}

// Traitement du formulaire (si aucune demande précédente)
if (!$demande_existante && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['demander_mentor'])) {
    $nom_lyceen = htmlspecialchars($_POST['nom_lyceen']);
    $prenom_lyceen = htmlspecialchars($_POST['prenom_lyceen']);
    $email_lyceen = htmlspecialchars($_POST['email_lyceen']);
    $telephone_lyceen = htmlspecialchars($_POST['telephone_lyceen']);
    $niveau = htmlspecialchars($_POST['niveau']);
    $parcours = htmlspecialchars($_POST['parcours']);
    $objectif_avenir = htmlspecialchars($_POST['objectif_avenir']);
    $message = htmlspecialchars($_POST['message']);

    if (empty($nom_lyceen) || empty($prenom_lyceen) || empty($email_lyceen) || empty($telephone_lyceen) || empty($niveau) || empty($parcours) || empty($objectif_avenir)) {
        $error_message = "Tous les champs obligatoires doivent être remplis.";
    } else {
        $query_insert = "INSERT INTO demandes_mentor (id_utilisateur, nom, prenom, email, telephone, niveau, parcours, objectif_avenir, message) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $pdo->prepare($query_insert);
        if ($stmt_insert->execute([$id_utilisateur, $nom_lyceen, $prenom_lyceen, $email_lyceen, $telephone_lyceen, $niveau, $parcours, $objectif_avenir, $message])) {
            $success_message = "Votre demande a été envoyée. Un mentor vous contactera bientôt.";
            $demande_existante = true;
        } else {
            $error_message = "Erreur lors de l'envoi de votre demande.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Mentorat</title>
    <link rel="stylesheet" href="../view/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<section class="hero-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="text-primary fw-bold">Inscription pour obtenir un mentor</h1>
            <p class="text-secondary">Remplissez ce formulaire pour être mis en relation avec un mentor adapté à votre parcours.</p>
        </div>

        <?php if (isset($success_message) || $demande_existante): ?>
            <div class="card shadow-lg p-4 mx-auto text-center" style="max-width: 600px;">
                <div class="card-body">
                    <h3 class="text-success fw-bold">Demande envoyée ! ✅</h3>
                    <p class="text-secondary">
                        <?php echo $success_message ?? "Vous avez déjà soumis une demande de mentorat. Un mentor vous contactera bientôt."; ?>
                    </p>
                    <a href="index.php?page=accueil" class="btn btn-primary mt-3">Retour à l'accueil</a>
                </div>
            </div>
        <?php else: ?>
            <form method="POST" class="shadow p-4 bg-white rounded mx-auto" style="max-width: 600px;">
                <div class="form-group mb-3">
                    <label>Nom :</label>
                    <input type="text" class="form-control" name="nom_lyceen" required>
                </div>
                <div class="form-group mb-3">
                    <label>Prénom :</label>
                    <input type="text" class="form-control" name="prenom_lyceen" required>
                </div>
                <div class="form-group mb-3">
                    <label>Email :</label>
                    <input type="email" class="form-control" name="email_lyceen" required>
                </div>
                <div class="form-group mb-3">
                    <label>Numéro de téléphone :</label>
                    <input type="tel" class="form-control" name="telephone_lyceen" required>
                </div>
                <div class="form-group mb-3">
                    <label>Niveau scolaire :</label>
                    <select name="niveau" class="form-control" required>
                        <option value="">Sélectionnez votre niveau</option>
                        <option value="Seconde">Seconde</option>
                        <option value="Première">Première</option>
                        <option value="Terminale">Terminale</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Parcours scolaire :</label>
                    <textarea class="form-control" name="parcours" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Objectif professionnel :</label>
                    <textarea class="form-control" name="objectif_avenir" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Message (optionnel) :</label>
                    <textarea class="form-control" name="message"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="demander_mentor">Envoyer la demande</button>
            </form>
        <?php endif; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
