<?php
// Inclure la connexion à la base de données

$pdo = db_connect(); // Récupère l'objet PDO

// Vérification de la requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_fichier = $_POST['nom_fichier'];
    $description = $_POST['description'];
    $contenu_fichier = file_get_contents($_FILES['contenu_fichier']['tmp_name']);
    $id_categorie = $_POST['id_categorie'];

    $stmt = $pdo->prepare("INSERT INTO fichiers_pdf (nom_fichier, description, contenu_fichier, id_categorie) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom_fichier, $description, $contenu_fichier, $id_categorie]);

    echo "Fichier PDF ajouté avec succès!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de Document pour Domaine</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Ajout d'un Document PDF pour un Domaine</h2>

        <form action="index.php?page=doc_domaines" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom_fichier">Nom du fichier :</label>
                <input type="text" name="nom_fichier" id="nom_fichier" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="contenu_fichier">Choisir un fichier PDF :</label>
                <input type="file" name="contenu_fichier" id="contenu_fichier" class="form-control" accept="application/pdf" required>
            </div>
            <div class="form-group">
                <label for="id_categorie">Catégorie :</label>
                <select name="id_categorie" id="id_categorie" class="form-control" required>
                    <option value="">Sélectionner une catégorie</option>
                    <?php
                    try {
                        $query = $pdo->query("SELECT * FROM categories");
                        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
                        if (!$categories) {
                            echo "<option disabled>Aucune catégorie disponible</option>";
                        } else {
                            foreach ($categories as $categorie) {
                                echo "<option value='" . $categorie['id_categories'] . "'>" . htmlspecialchars($categorie['nom_domaine']) . "</option>";
                            }
                        }
                    } catch (PDOException $e) {
                        echo "<option disabled>Erreur de requête</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le Document</button>
            <a href="index.php?page=dashboard" class="btn btn-secondary">Retour</a>
        </form>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
