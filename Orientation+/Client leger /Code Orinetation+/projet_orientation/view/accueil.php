<?php
// Inclure le fichier de session pour vérifier si l'utilisateur est connecté

// Connexion à la base de données
$conn = db_connect();

// Vérifier si l'utilisateur est connecté
$user_connected = isset($_SESSION['user_id']);
$user_role = $user_connected ? $_SESSION['role'] : null;

// Vérifier si l'utilisateur est un élève connecté et récupérer son domaine
$domaine = null;
if ($user_role == 'eleve') {
    // Récupérer le domaine de l'élève
    $user_id = $_SESSION['user_id'];
    $sql = "select c.nom_domaine from utilisateur u
            join categories c on u.id_categorie = c.id_categories
            where u.id_utilisateur = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $domaine = $stmt->fetchColumn(); // Récupérer le nom du domaine
}
?>

<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <link rel="stylesheet" href="view/styles.css">

            <!-- Texte de bienvenue -->
            <div class="col-md-6">
                <h1 class="text-primary fw-bold mb-4">Bienvenue sur <span class="text-info">Orientation+ !</span></h1>
                <p class="lead text-secondary">
                    Découvrez les métiers, explorez vos passions, et orientez votre avenir avec confiance.
                </p>
                <p class="fw-light fst-italic">"Un site dédié à vous guider vers les meilleures opportunités pour votre futur."</p>
                
                <!-- Affichage du domaine si l'élève est connecté et a choisi un domaine -->
                <?php if ($user_connected && $user_role == 'eleve'): ?>
                    <?php if ($domaine): ?>
                        <p class="text-success mt-4"><strong>Votre domaine choisi :</strong> <?= htmlspecialchars($domaine) ?></p>
                    <?php else: ?>
                        <p class="text-danger mt-4">Vous n'avez pas encore choisi de domaine.</p>
                    <?php endif; ?>
                <?php elseif ($user_connected && $user_role == 'professeur'): ?>
                    <p class="text-info mt-4">En tant que professeur, vous pouvez explorer les domaines et les métiers pour guider vos élèves.</p>
                <?php else: ?>
                    <!-- Affichage des boutons pour connexion et inscription si non connecté -->
                    <p class="text-info mt-4">Connectez-vous pour commencer votre parcours.</p>
                    <a href="index.php?page=login" class="btn btn-primary">Se connecter</a>
                    <a href="index.php?page=register" class="btn btn-secondary ml-2">S'inscrire</a>
                <?php endif; ?>
            </div>
            <!-- Image centrale -->
            <div class="col-md-6 text-center">
                <img src="https://i.pinimg.com/originals/d0/c6/04/d0c60459431b6ffaecf92fc902ca996d.gif" alt="Étudiants heureux" class="hero-image img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<?php if ($user_connected && $user_role == 'eleve'): ?>
    
    <!-- Section Domaines -->
    <section class="container my-5">
        <div class="row">
            <?php
            if ($domaine) {
                // L'élève a choisi un domaine, afficher uniquement ce domaine
                $sql = "select * from categories where nom_domaine = :domaine";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':domaine', $domaine, PDO::PARAM_STR);
                $stmt->execute();
                $filteredDomaines = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($filteredDomaines as $domaine) {
                    ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="<?php echo htmlspecialchars($domaine['nom_icone']); ?> text-primary"></i> 
                                    <?php echo htmlspecialchars($domaine['nom_domaine']); ?>
                                </h5>
                                <p class="card-text">Découvrez les opportunités et compétences dans le domaine de <?php echo htmlspecialchars($domaine['nom_domaine']); ?>.</p>
                                <a href="/projet_orientation/view/voir_pdf.php?id=<?php echo $domaine['id_categories']; ?>" class="btn btn-primary">Voir plus</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Si l'élève n'a pas choisi de domaine, afficher tous les domaines
                $query = $conn->query("select * from categories");
                $allDomaine = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($allDomaine as $domaine) {
                    ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="<?php echo htmlspecialchars($domaine['nom_icone']); ?> text-primary"></i> 
                                    <?php echo htmlspecialchars($domaine['nom_domaine']); ?>
                                </h5>
                                <p class="card-text">Découvrez les opportunités et compétences dans le domaine de <?php echo htmlspecialchars($domaine['nom_domaine']); ?>.</p>
                                <a href="domaine_details.php?id=<?php echo $domaine['id_categories']; ?>" class="btn btn-primary">Voir plus</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <!-- Section Liens vers Domaine, Métier, et Mentor pour les professeurs -->
    <section class="container my-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Explorez les Domaines</h5>
                        <p class="card-text text-secondary">Découvrez les différents secteurs professionnels et trouvez celui qui vous passionne.</p>
                        <a href="index.php?page=domaines" class="btn btn-primary">Voir les Domaines</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-info">Découvrez les Métiers</h5>
                        <p class="card-text text-secondary">Explorez les métiers inspirants et trouvez celui qui correspond à vos aspirations.</p>
                        <a href="index.php?page=interview" class="btn btn-info">Voir les Métiers</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-success">Trouvez un Mentor</h5>
                        <p class="card-text text-secondary">Bénéficiez de conseils et d'accompagnement de professionnels pour mieux orienter votre parcours.</p>
                        <a href="index.php?page=mentor" class="btn btn-success">Demander un Mentor</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
<?php elseif ($user_connected && $user_role == 'professeur'): ?>
    <!-- Section Liens vers Domaine, Métier, et Mentor pour les professeurs -->
    <section class="container my-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Explorez les Domaines</h5>
                        <p class="card-text text-secondary">Découvrez les différents secteurs professionnels et guidez vos élèves.</p>
                        <a href="index.php?page=domaines" class="btn btn-primary">Voir les Domaines</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-info">Découvrez les Métiers</h5>
                        <p class="card-text text-secondary">Explorez les métiers inspirants et guidez vos élèves dans leur orientation.</p>
                        <a href="index.php?page=interview" class="btn btn-info">Voir les Métiers</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
