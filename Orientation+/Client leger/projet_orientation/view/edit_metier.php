<?php


$pdo = db_connect(); // Connexion à la base de données

// Vérification de l'ID dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID du métier non spécifié !");
}

$id_metier = $_GET['id'];

// Récupération des données du métier
$query = $pdo->prepare("SELECT * FROM metiers WHERE id_metier = ?");
$query->execute([$id_metier]);
$metier = $query->fetch(PDO::FETCH_ASSOC);

if (!$metier) {
    die("Métier introuvable !");
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_metier = $_POST['nom_metier'];
    $nom_icone = $_POST['nom_icone'];

    $updateQuery = $pdo->prepare("UPDATE metiers SET nom_metier = ?, nom_icone = ? WHERE id_metier = ?");
    $updateQuery->execute([$nom_metier, $nom_icone, $id_metier]);

    header("Location: ..//projet_orientation/index.php?page=interview");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Métier</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-primary">Modifier le Métier</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nom du métier</label>
            <input type="text" name="nom_metier" class="form-control" value="<?php echo htmlspecialchars($metier['nom_metier']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Icône</label>
            <input type="text" name="nom_icone" class="form-control" value="<?php echo htmlspecialchars($metier['nom_icone']); ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="index.php?page=dashboard" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
