<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide ou manquant !");
}

$id = intval($_GET['id']); 

$pdo = db_connect(); 


$stmt = $pdo->prepare("SELECT nom_domaine, nom_icone, description FROM categories WHERE id_categories = ?");
$stmt->execute([$id]);
$domaine = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$domaine) {
    die("Domaine/MÃ©tier introuvable !");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($domaine['nom_domaine']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/YOUR_FA_KIT.js" crossorigin="anonymous"></script> 
    <style>
        .container { max-width: 600px; margin: 50px auto; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); }
        .icon { font-size: 50px; margin-bottom: 10px; }
    </style>
</head>
<body class="bg-light">

<div class="container bg-white p-4 text-center">
    <i class="icon <?= htmlspecialchars($domaine['nom_icone']) ?>"></i>
    <h1><?= htmlspecialchars($domaine['nom_domaine']) ?></h1>
    <p class="mt-3"><?= !empty($domaine['description']) ? nl2br(htmlspecialchars($domaine['description'])) : 'Pas de description disponible.' ?></p>
    <a href="index.php?page=dashboard" class="btn btn-primary mt-3">Retour au Dashboard</a>
</div>

</body>
</html>