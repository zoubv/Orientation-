<?php
include('controler/selectDomaine.php');

// Connexion à la base de données
//$pdo = new PDO('mysql:host=localhost;dbname=projet_orientation;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des domaines
$query = $pdo->query("SELECT * FROM categories");
$allDomaine = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="container my-5">
    <h2 class="text-center text-primary fw-bold mb-4">Domaines</h2>
    <div class="row">
        
        <?php foreach ($allDomaine as $domaine) { ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="<?php echo htmlspecialchars($domaine['nom_icone']); ?> text-primary"></i> 
                            <?php echo htmlspecialchars($domaine['nom_domaine']); ?>
                        </h5>
                        <p class="card-text">
                            Découvrez les opportunités et compétences dans le domaine de <?php echo htmlspecialchars($domaine['nom_domaine']); ?>.
                        </p>
                        <a href="index.php?page=voir_pdf&id=<?php echo $domaine['id_categories']; ?>" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</section>
