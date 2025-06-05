<?php
// Vérifie si un ID de catégorie est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Aucun domaine sélectionné.");
}

$id_categorie = intval($_GET['id']);

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql://host=localhost;dbname=projet_orientation;charset=utf8', 'root', 'btssio2023');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération du premier fichier PDF lié au domaine
    $query = $pdo->prepare("SELECT id, nom_fichier, contenu_fichier FROM fichiers_pdf WHERE id_categorie = ? LIMIT 1");
    $query->execute([$id_categorie]);
    $pdfFile = $query->fetch(PDO::FETCH_ASSOC);

    if (!$pdfFile) {
        die("Aucun fichier PDF disponible pour ce domaine.");
    }

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pdfFile['nom_fichier']); ?> - Affichage PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container my-5">
        <h2 class="text-center text-primary fw-bold mb-4"><?php echo htmlspecialchars($pdfFile['nom_fichier']); ?></h2>
        
        <!-- Affichage du PDF dans un iframe -->
        <div class="text-center">
            <iframe src="data:application/pdf;base64,<?php echo base64_encode($pdfFile['contenu_fichier']); ?>" 
                    width="100%" height="600px">
            </iframe>
        </div>

        <!-- Boutons Télécharger et Retour -->
        <div class="text-center mt-4">
            <a href="download_pdf.php?id=<?php echo $pdfFile['id']; ?>" class="btn btn-primary">Télécharger</a>
            <a href="index.php?page=domaines" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
