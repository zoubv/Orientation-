<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = db_connect(); 

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Récupération de l'utilisateur par son email
    $sql = "select * from utilisateur where email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['user_name'] = $user['nom']; 
        $_SESSION['role'] = $user['role']; 

        header("Location: index.php?page=accueil");
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
        header("Location: index.php?page=login&error=" . urlencode($error));
        exit();
    }
}
?>



