
<?php
try {
    // Connexion à la base de données
    $pdo = new PDO('mysql://host=localhost;dbname=projet_orientation;charset=utf8', 'root', 'btssio2023');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


// Récupérer tous les domaines
$query = $pdo->query("SELECT * FROM categories");
$domaines = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des domaines filtrés (aucun affichage par défaut)
$filteredDomaines = [];
$domaine_id = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['domaine'])) {
    $domaine_id = $_POST['domaine'];

    // Requête de filtrage
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id_categories = ?");
    $stmt->execute([$domaine_id]);
    $filteredDomaines = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrer les Domaines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-primary text-center fw-bold mb-4">Filtrer les Domaines</h2>

    <form method="POST">
        <div class="mb-4">
            <label for="domaine" class="form-label">Sélectionnez un domaine :</label>
            <select id="domaine" name="domaine" class="form-select">
                <option value="">-- Choisir un domaine --</option>
                <?php foreach ($domaines as $domaine): ?>
                    <option value="<?php echo $domaine['id_categories']; ?>"
                        <?php if ($domaine_id == $domaine['id_categories']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($domaine['nom_domaine']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrer</button>
        
    </form>

    <?php if (!empty($filteredDomaines)): ?>
        <h3 class="mt-5">Domaines Disponibles</h3>
        <div class="row">
            <?php foreach ($filteredDomaines as $domaine): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="<?php echo htmlspecialchars($domaine['nom_icone']); ?> text-primary"></i> 
                                <?php echo htmlspecialchars($domaine['nom_domaine']); ?>
                            </h5>
                            <p class="card-text">Découvrez les opportunités et compétences dans le domaine de 
                                <?php echo htmlspecialchars($domaine['nom_domaine']); ?>.</p>
                            <a href="index.php?page=voir_pdf&id=<?php echo $domaine['id_categories']; ?>" class="btn btn-primary">Voir plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="../index.php?page=filtre" class="btn btn-secondary">Retour</a>
    <?php endif; ?>
</div>

</body>
</html>
