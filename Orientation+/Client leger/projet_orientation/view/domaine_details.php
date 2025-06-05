<?php
// Vérifie si un ID de catégorie est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Aucun domaine sélectionné.");
}

$id_categorie = intval($_GET['id']);

try {
    // Connexion à la base de données
   // $pdo = new PDO('mysql:host=localhost;dbname=projet_orientation;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération du nom du domaine
    $queryDomaine = $pdo->prepare("SELECT nom_domaine FROM categories WHERE id_categories = ?");
    $queryDomaine->execute([$id_categorie]);
    $domaine = $queryDomaine->fetch(PDO::FETCH_ASSOC);

    if (!$domaine) {
        die("Domaine introuvable.");
    }

    // Récupération des fichiers PDF liés au domaine
    $query = $pdo->prepare("SELECT * FROM fichiers_pdf WHERE id_categorie = ?");
    $query->execute([$id_categorie]);
    $pdfFiles = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($domaine['nom_domaine']); ?> - Fichiers PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center text-primary fw-bold mb-4"><?php echo htmlspecialchars($domaine['nom_domaine']); ?></h2>
        
        <?php if (empty($pdfFiles)) { ?>
            <p class="text-center text-muted">Aucun fichier PDF disponible pour ce domaine.</p>
        <?php } else { ?>
            <div class="row">
                <?php foreach ($pdfFiles as $pdf) { ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($pdf['nom_fichier']); ?></h5>
                                <?php if (!empty($pdf['description'])) { ?>
                                    <p class="card-text"><?php echo htmlspecialchars($pdf['description']); ?></p>
                                <?php } ?>
                                <a href="download_pdf.php?id=<?php echo $pdf['id']; ?>" class="btn btn-primary mt-2">
                                    Télécharger
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        
        <a href="index.php?=domaines" class="btn btn-secondary mt-3">Retour</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
