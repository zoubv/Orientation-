<?php
include('./bdd/bdd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $id_categorie = isset($_POST['id_categorie']) ? (int) $_POST['id_categorie'] : NULL;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Connexion à la base de données
    $conn = db_connect();

    // Vérifier si l'email existe déjà
    $sql_check = "SELECT id_utilisateur FROM utilisateur WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(1, $email);
    $stmt_check->execute();

    if ($stmt_check->fetch()) {
        // Message d'erreur plus détaillé et redirection
        header("Location: index.php?page=register&error=email_exists");
        exit;
    }

    // Vérifier si le domaine est obligatoire pour les élèves
    if ($role === "eleve" && empty($id_categorie)) {
        header("Location: index.php?page=register&error=domain_required");
        exit;
    }

    // Vérifier que la catégorie existe dans la table categories
    if ($role === "eleve" && $id_categorie) {
        $sql_check_category = "SELECT id_categories FROM categories WHERE id_categories = ?";
        $stmt_check_category = $conn->prepare($sql_check_category);
        $stmt_check_category->bindParam(1, $id_categorie, PDO::PARAM_INT);
        $stmt_check_category->execute();

        if (!$stmt_check_category->fetch()) {
            header("Location: index.php?page=register&error=invalid_domain");
            exit;
        }
    }

    // Préparer l'insertion de l'utilisateur
    $sql = "INSERT INTO utilisateur (nom, email, mot_de_passe, role" . ($role === "eleve" ? ", id_categorie" : "") . ") 
            VALUES (:username, :email, :password, :role" . ($role === "eleve" ? ", :id_categorie" : "") . ")";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    
    if ($role === "eleve") {
        $stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        header("Location: index.php?page=login");
        exit;
    } else {
        // Message d'erreur plus détaillé
        header("Location: index.php?page=register&error=general");
        exit;
    }
} else {
    die("Accès interdit.");
}
