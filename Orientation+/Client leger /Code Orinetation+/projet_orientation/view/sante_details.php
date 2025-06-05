<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'projet_orientation';
$username = 'root';
$password = 'btssio2023';

try {
    $pdo = new PDO("mysql://host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue, afficher le message d'erreur
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des détails du domaine "Informatique"
try {
    // Recherche insensible à la casse
    $query = "SELECT titre, description FROM details WHERE LOWER(titre) = 'sante'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $informatiqueDetail = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Informatique</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        p {
            line-height: 1.8;
            color: #555;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .pdf-button {
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
        }
        .pdf-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Détails Informatique</h1>
    </header>

    <div class="container">
        <?php if ($informatiqueDetail): ?>
            <h1><?php echo htmlspecialchars($informatiqueDetail['titre']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($informatiqueDetail['description'])); ?></p>
        <?php else: ?>
            <div class="alert">Aucun détail trouvé pour le domaine Informatique.</div>
        <?php endif; ?>

        <!-- Bouton pour ouvrir le PDF dans une nouvelle page -->
        <a href="./pdf/DomaineInformatique.pdf" class="pdf-button" target="_blank">Consulter le document PDF</a>
    </div>
</body>
</html>
