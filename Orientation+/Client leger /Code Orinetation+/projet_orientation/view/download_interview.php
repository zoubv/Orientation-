<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Aucun fichier sélectionné.");
}

$id_fichier = intval($_GET['id']);

try {
    $pdo = new PDO('mysql://host=localhost;dbname=projet_orientation;charset=utf8', 'root', 'btssio2023');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $pdo->prepare("SELECT nom_fichier, contenu_fichier FROM interviews_pdf WHERE id = ?");
    $query->execute([$id_fichier]);
    $file = $query->fetch(PDO::FETCH_ASSOC);

    if (!$file) {
        die("Fichier introuvable.");
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $file['nom_fichier'] . '"');
    header('Content-Length: ' . strlen($file['contenu_fichier']));
    echo $file['contenu_fichier'];

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
