<?php
include("view/commun/header.php"); 

$host = 'localhost'; 
$dbname = 'projet_orientation';
$username = 'root'; 
$password = ''; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id']; // On s'assure que l'id est bien un entier

    try {
        $query = "DELETE FROM details WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        // Si la suppression a réussi, on renvoie un JSON avec un succès
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Aucun détail trouvé avec cet ID.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit(); // On termine le script ici pour éviter d'afficher autre chose que la réponse JSON
}

// Récupération des données de la table "details"
try {
    $query = "SELECT id, titre, description FROM details"; // Sélection de l'id, titre et description
    $stmt = $pdo->query($query);
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Détails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-details {
            text-align: center;
            color: #555;
            font-size: 1.2rem;
        }
        .btn-back {
            margin-top: 20px;
            display: block;
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 12px;
            text-align: center;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        function supprimerChamp(id) {
            // Envoi de la requête pour supprimer le champ directement sans confirmation
            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ id: id })
            })
            .then(response => response.json()) // Traiter la réponse JSON du serveur
            .then(data => {
                if (data.success) {
                    alert('Champ supprimé avec succès.');
                    // Retirer le champ de la page
                    document.getElementById('detail_' + id).remove();
                } else {
                    alert('Erreur lors de la suppression: ' + data.message);
                }
            })
            .catch(error => console.error('Erreur:', error));
        }
    </script>
</head>
<body>

    <div class="container">
        <h1>Liste des Détails</h1>

        <?php if (!empty($details)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $detail): ?>
                        <tr id="detail_<?php echo $detail['id']; ?>">
                            <td><?php echo htmlspecialchars($detail['titre']); ?></td>
                            <td><?php echo htmlspecialchars($detail['description']); ?></td>
                            <td>
                                <button class="btn-delete" onclick="supprimerChamp(<?php echo $detail['id']; ?>)">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-details">Aucun détail trouvé.</p>
        <?php endif; ?>

        <a href="index.php?page=accueil" class="btn-back">Retour à l'accueil</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
