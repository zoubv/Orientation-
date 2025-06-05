<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Fichiers PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        form {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            max-width: 400px;
            margin: 10px auto;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Télécharger un Fichier PDF</h1>

    <!-- Afficher les messages d'erreur ou de succès -->
    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<div class="message success">Le fichier a été téléchargé avec succès !</div>';
    }
    if (isset($_GET['error'])) {
        $errorMessages = [
            'invalid_file' => 'Erreur : Le fichier doit être au format PDF.',
            'upload_failed' => 'Erreur : Le téléchargement a échoué.',
            'db_error' => 'Erreur : Impossible d\'enregistrer dans la base de données.',
            'no_file' => 'Erreur : Aucun fichier sélectionné.',
            'invalid_request' => 'Erreur : Requête invalide.',
        ];
        $error = htmlspecialchars($_GET['error']);
        echo '<div class="message error">' . ($errorMessages[$error] ?? 'Erreur inconnue.') . '</div>';
    }
    ?>

    <!-- Formulaire pour télécharger un fichier -->
    <form action="../controler/PdfController.php?action=upload" method="POST" enctype="multipart/form-data">
        <label for="description">Description :</label>
        <input type="text" name="description" id="description" placeholder="Description du fichier" required>

        <label for="pdf_file">Fichier PDF :</label>
        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required>

        <button type="submit">Télécharger</button>
    </form>
</body>
</html>
