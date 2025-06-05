<?php
include('controler/selectMetier.php');

 //Connexion à la base de données
$pdo = new PDO('mysql://host=localhost;dbname=projet_orientation;charset=utf8', 'root', 'btssio2023');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des métiers
$query = $pdo->query("SELECT * FROM metiers");
$allMetiers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="container my-5">
    <h2 class="text-center text-primary fw-bold mb-4">Métiers</h2>
    <div class="row">
        
        <?php foreach ($allMetiers as $metier) { ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="<?php echo htmlspecialchars($metier['nom_icone']); ?> text-primary"></i> 
                            <?php echo htmlspecialchars($metier['nom_metier']); ?>
                        </h5>
                        <p class="card-text">
                            Découvrez les témoignages et expériences dans le métier de <?php echo htmlspecialchars($metier['nom_metier']); ?>.
                        </p>
                        <a href="index.php?page=voir_interview&id=<?php echo $metier['id_metier']; ?>" class="btn btn-primary">
                            Voir plus

                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        

    </div>
</section>
