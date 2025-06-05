<?php
$host = 'localhost'; 
$dbname = 'projet_orientation'; 
$username = "root";
$password = 'btssio2023'; 

try {
    $pdo = new PDO("mysql://host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement de l'insertion des métiers
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom_metier'], $_POST['nom_icone'], $_POST['id_categories'])) {
        $nom_metier = $_POST['nom_metier'];
        $nom_icone = $_POST['nom_icone'];
        $id_categories = $_POST['id_categories'];

        if (!empty($nom_metier) && !empty($nom_icone) && !empty($id_categories)) {
            try {
                $sql = "INSERT INTO metiers (nom_metier, nom_icone, id_categories) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nom_metier, $nom_icone, $id_categories]);
                $successMessage = "Métier ajouté avec succès!";
            } catch (PDOException $e) {
                $errorMessage = "Erreur lors de l'insertion : " . $e->getMessage();
            }
        } else {
            $errorMessage = "Tous les champs doivent être remplis.";
        }
    } else {
        $errorMessage = "Les données ne sont pas envoyées correctement.";
    }
}

// Récupérer les catégories (domaines) pour la liste déroulante
$req = $pdo->prepare("SELECT * FROM categories");
$req->execute();
$allDomaines = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Métier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f8fb;
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
        <h1>Ajouter un Métier</h1>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nom_metier">Nom du Métier :</label>
                <input type="text" id="nom_metier" name="nom_metier" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nom_icone">Nom de l'icône :</label>
                <input type="text" id="nom_icone" name="nom_icone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="id_categories">Catégorie (Domaine) :</label>
                <select id="id_categories" name="id_categories" class="form-control" required>
                    <option value="">-- Sélectionner un domaine --</option>
                    <?php foreach ($allDomaines as $domaine): ?>
                        <option value="<?php echo $domaine['id_categories']; ?>">
                            <?php echo htmlspecialchars($domaine['nom_domaine']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">Ajouter le Métier</button>
        </form>

        <a href="index.php" class="btn-back">Retour à l'accueil</a>
    </div>

</body>
</html>
