<?php
// Inclure la fonction db_connect
include 'bdd/bdd.php';

// Vérifier si l'ID du domaine est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Se connecter à la base de données
    $pdo = db_connect();

    // Récupérer les informations du domaine à modifier
    try {
        $sql = "SELECT * FROM categories WHERE id_categories = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $domaine = $stmt->fetch();

        // Si le domaine n'existe pas
        if (!$domaine) {
            $errorMessage = "Domaine introuvable!";
        }
    } catch (PDOException $e) {
        $errorMessage = "Erreur lors de la récupération des données : " . $e->getMessage();
    }

    // Traitement de l'édition du domaine
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom_domaine = $_POST['nom_domaine'];
        $nom_icone = $_POST['nom_icone'];
        $description = $_POST['description'];

        // Mise à jour des données
        try {
            $sql = "UPDATE categories SET nom_domaine = ?, nom_icone = ?, description = ? WHERE id_categories = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom_domaine, $nom_icone, $description, $id]);

            // Message de succès ou redirection
            $successMessage = "Domaine mis à jour avec succès!";
        } catch (PDOException $e) {
            $errorMessage = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
} else {
    $errorMessage = "ID du domaine non spécifié!";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Domaine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 12px;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
            font-size: 1.1rem;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .alert {
            text-align: center;
            margin-top: 20px;
        }
        .btn-back {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            font-size: 1.1rem;
            padding: 12px;
            text-align: center;
            border: none;
            border-radius: 5px;
            width: 100%;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Modifier le Domaine</h1>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php elseif (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <!-- Formulaire d'édition -->
        <?php if (isset($domaine)): ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nom_domaine">Nom du Domaine :</label>
                    <input type="text" id="nom_domaine" name="nom_domaine" class="form-control" value="<?php echo $domaine['nom_domaine']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="nom_icone">Nom de l'icône :</label>
                    <input type="text" id="nom_icone" name="nom_icone" class="form-control" value="<?php echo $domaine['nom_icone']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea id="description" name="description" class="form-control" rows="5" required><?php echo $domaine['description']; ?></textarea>
                </div>

                <button type="submit" class="btn-submit">Sauvegarder les Modifications</button>
            </form>
        <?php endif; ?>

        <a href="index.php?page=domaines" class="btn-back">Retour à la liste des domaines</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
