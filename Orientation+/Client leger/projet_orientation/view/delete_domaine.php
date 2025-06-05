<?php
// Inclure le fichier contenant la fonction db_connect

// Connexion à la base de données
$pdo = db_connect();

// Vérification de l'existence de l'ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Vérifier si l'ID est valide et existe dans la base de données
    $req = $pdo->prepare("SELECT * FROM categories WHERE id_categories = ?");
    $req->execute([$id]);
    $domaine = $req->fetch();

    if ($domaine) {
        // Si le domaine existe, procéder à la suppression
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $deleteQuery = $pdo->prepare("DELETE FROM categories WHERE id_categories = ?");
                $deleteQuery->execute([$id]);
                $successMessage = "Domaine supprimé avec succès!";
                header("Location: index.php?page=domaines");  // Rediriger après la suppression
                exit();
            } catch (PDOException $e) {
                $errorMessage = "Erreur lors de la suppression : " . $e->getMessage();
            }
        }
    } else {
        $errorMessage = "Domaine non trouvé!";
    }
} else {
    $errorMessage = "ID du domaine non spécifié!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Domaine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Supprimer un Domaine</h1>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (isset($domaine)): ?>
            <p>Êtes-vous sûr de vouloir supprimer le domaine suivant ?</p>
            <form method="POST">
                <div class="form-group">
                    <label>Nom du Domaine :</label>
                    <p><?php echo $domaine['nom_domaine']; ?></p>
                </div>
                <div class="form-group">
                    <label>Icône :</label>
                    <p><?php echo $domaine['nom_icone']; ?></p>
                </div>
                <div class="form-group">
                    <label>Description :</label>
                    <p><?php echo $domaine['description']; ?></p>
                </div>

                <button type="submit" class="btn btn-danger">Supprimer</button>
                <a href="index.php?page=domaines" class="btn btn-secondary">Annuler</a>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
