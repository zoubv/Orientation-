<?php
// Démarrer la session seulement si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('db_connect')) {
    function db_connect() {
        try {
            $user = "root";
            $pass = "btssio2023";
            $dsn = "mysql://host=localhost;dbname=projet_orientation;charset=utf8";
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;  // Retourne l'objet PDO pour une utilisation ultérieure
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}
?>
