<?php
$host = 'localhost'; 
$dbname = 'projet_orientation'; 
$username ="root";
$password = 'btssio2023'; 

try {
    $pdo = new PDO("mysql://host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement de l'insertion des détails
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom_domaine'], $_POST['nom_icone'], $_POST['description'])) {
        $nom_domaine = $_POST['nom_domaine'];
        $nom_icone = $_POST['nom_icone'];
       

        // Si les champs ne sont pas vides
        if (!empty($nom_domaine) && !empty($nom_icone) && !empty($description)) {
            try {
                $sql = "INSERT INTO categories (nom_domaine, nom_icone, description) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nom_domaine, $nom_icone, $description]);
                $successMessage = "Domaine ajouté avec succès!";
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

// Récupérer les domaines existants pour modification et suppression
$req = $pdo->prepare("SELECT * FROM categories");
$req->execute();
$allDomaine = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter ou Modifier un Domaine</title>
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
        <h1>Ajouter ou Modifier un Domaine</h1>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <!-- Formulaire d'ajout ou de modification -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="nom_domaine">Nom du Domaine :</label>
                <input type="text" id="nom_domaine" name="nom_domaine" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nom_icone">Nom de l'icône :</label>
                <input type="text" id="nom_icone" name="nom_icone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-submit">Ajouter le Domaine</button>
        </form>

        
        <a href="index.php" class="btn-back">Retour à l'accueil</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
