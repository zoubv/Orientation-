<?php

$pdo = db_connect(); 


$query = $pdo->query("SELECT * FROM categories");
$allDomaine = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->query("SELECT * FROM metiers");
$allMetier = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Domaines et Métiers</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-primary text-center">Tableau de Bord</h2>
    
    <!-- Gestion des Domaines -->
 <!-- Gestion des Domaines -->
<h3 class="mt-4">Gestion des Domaines</h3>
<a href="index.php?page=insert_details" class="btn btn-success mb-3">Ajouter un Domaine</a>
<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Icône</th>
            <th>Actions</th>
            <th>Insérer PDF</th> <!-- Nouvelle colonne pour insérer le PDF -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allDomaine as $domaine) { ?>
            <tr>
                <td><?php echo $domaine['id_categories']; ?></td>
                <td><?php echo htmlspecialchars($domaine['nom_domaine']); ?></td>
                <td><i class="<?php echo htmlspecialchars($domaine['nom_icone']); ?>"></i></td>
                <td>
                    <a href="index.php?page=edit_domaine&id=<?php echo $domaine['id_categories']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="index.php?page=delete_domaine&id=<?php echo $domaine['id_categories']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    <a href="index.php?page=details_domaines&id=<?php echo $domaine['id_categories']; ?>" class="btn btn-success btn-sm">Détails</a>
                </td>
                <td>
                    <a href="index.php?page=doc_domaines&id=<?php echo $domaine['id_categories']; ?>" class="btn btn-info btn-sm">Insérer PDF</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Gestion des Métiers -->
<h3 class="mt-5">Gestion des Métiers</h3>
<a href="index.php?page=ajouter_metier" class="btn btn-success mb-3">Ajouter un Métier</a>
<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Icône</th>
            <th>Actions</th>
            <th>Insérer PDF</th> <!-- Nouvelle colonne pour insérer le PDF -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allMetier as $metier) { ?>
            <tr>
                <td><?php echo $metier['id_metier']; ?></td>
                <td><?php echo htmlspecialchars($metier['nom_metier']); ?></td>
                <td><i class="<?php echo htmlspecialchars($metier['nom_icone']); ?>"></i></td>
                <td>
                    <a href="index.php?page=edit_metier&id=<?php echo $metier['id_metier']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="index.php?page=delete_metier&id=<?php echo $metier['id_metier']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce métier ?');">Supprimer</a>
                    <a href="index.php?page=details_metier&id=<?php echo $metier['id_metier']; ?>" class="btn btn-info btn-sm">Détails</a>
                </td>
                <td>
                    <a href="index.php?page=doc_metiers&id=<?php echo $metier['id_metier']; ?>" class="btn btn-info btn-sm">Insérer PDF</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>
</body>
</html>
