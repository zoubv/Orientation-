<?php
// Inclure le fichier contenant la fonction db_connect
require_once 'bdd/bdd.php';

// Connexion à la base de données
$pdo = db_connect();

// Vérification de l'existence de l'ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Vérifier si l'ID est valide et existe dans la base de données
    $req = $pdo->prepare("SELECT * FROM fiche_metier WHERE id_metier = ?");
    $req->execute([$id]);
    $metier = $req->fetch();

    if ($metier) {
        // Si le métier existe, procéder à la suppression
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $deleteQuery = $pdo->prepare("DELETE FROM fiche_metier WHERE id_metier = ?");
                $deleteQuery->execute([$id]);
                $successMessage = "Métier supprimé avec succès!";
                header("Location: index.php?page=interview");  // Rediriger après la suppression
                exit();
            } catch (PDOException $e) {
                $errorMessage = "Erreur lors de la suppression : " . $e->getMessage();
            }
        }
    } else {
        $errorMessage = "Métier non trouvé!";
    }
} else {
    $errorMessage = "ID du métier non spécifié!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Métier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Supprimer un Métier</h1>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (isset($metier)): ?>
            <p>Êtes-vous sûr de vouloir supprimer le métier suivant ?</p>
            <form method="POST">
                <div class="form-group">
                    <label>Nom du Métier :</label>
                    <p><?php echo htmlspecialchars($metier['nom_metier']); ?></p>
                </div>
                <div class="form-group">
                    <label>Description :</label>
                    <p><?php echo htmlspecialchars($metier['description']); ?></p>
                </div>
                <div class="form-group">
                    <label>Fichier PDF :</label>
                    <p><?php echo htmlspecialchars($metier['nom_fichier']); ?></p>
                </div>

                <button type="submit" class="btn btn-danger">Supprimer</button>
                <a href="index.php?page=interview" class="btn btn-secondary">Annuler</a>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>