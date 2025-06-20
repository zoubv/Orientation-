<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orientation+</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Feuille de style personnalisée -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="index.php?page=accueil">
                <i class="fas fa-graduation-cap"></i> Orientation+
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-dark" href="index.php?page=accueil">Accueil</a></li>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link text-dark" href="index.php?page=login" title="Connexion"><i class="fas fa-user-circle"></i> Connexion</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link text-dark" href="index.php?page=domaines">Domaines</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="index.php?page=interview">Métiers</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="index.php?page=filtre_domaines">Filtres</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="index.php?page=mentor">Mentor</a></li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'professeur'): ?>
                            <li class="nav-item"><a class="nav-link text-dark" href="index.php?page=dashboard" title="Tableau de Bord">
                                <i class="fas fa-tachometer-alt"></i> <!-- Icône Dashboard -->
                            </a></li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="index.php?page=logout" title="Déconnexion">
                                <i class="fas fa-sign-out-alt"></i> <!-- Icône Déconnexion -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark"><?php echo '<i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['user_name']); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

</body>
</html>
