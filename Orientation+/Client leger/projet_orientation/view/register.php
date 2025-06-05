<?php
include('./bdd/bdd.php');

// Connexion à la base de données
$conn = db_connect();

// Récupérer les domaines depuis la base de données
$query = $conn->query("SELECT * FROM categories");

// Vérifier si la requête a échoué
if ($query === false) {
    die("Erreur dans la requête : " . implode(" ", $conn->errorInfo()));
}

// Récupérer les résultats
$domaines = $query->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des domaines ont été trouvés
if (empty($domaines)) {
    echo "Aucun domaine trouvé dans la base de données.";
}
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center text-primary mb-4">
            <i class="fas fa-user-plus"></i> Inscription
        </h2>

        <!-- Affichage des messages d'erreur -->
        <?php if (isset($_GET['error'])): ?>
            <?php if ($_GET['error'] == 'email_exists'): ?>
                <div class="alert alert-danger">Cet email est déjà utilisé.</div>
            <?php elseif ($_GET['error'] == 'domain_required'): ?>
                <div class="alert alert-danger">Vous devez choisir un domaine si vous êtes élève.</div>
            <?php elseif ($_GET['error'] == 'invalid_domain'): ?>
                <div class="alert alert-danger">Le domaine sélectionné est invalide.</div>
            <?php elseif ($_GET['error'] == 'general'): ?>
                <div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer.</div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="index.php?page=registerAction" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Votre nom d'utilisateur" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle Utilisateur</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    <select name="role" id="role" class="form-control" required>
                        <option value="eleve">Élève</option>
                        <option value="professeur">Professeur</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
            </div>

            <!-- Sélection des domaines (Affiché seulement si "élève" est sélectionné) -->
            <div class="mb-3" id="domaine_section">
                <label for="id_categorie" class="form-label">Choisissez un domaine</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                    <select name="id_categorie" id="id_categorie" class="form-control">
                        <option value="">Sélectionnez un domaine</option>
                        
                        <?php
                        // Vérification des données avant de les utiliser
                        if (is_array($domaines) && count($domaines) > 0) {
                            foreach ($domaines as $domaine): ?>
                                <option value="<?= htmlspecialchars($domaine['id_categories']) ?>"><?= htmlspecialchars($domaine['nom_domaine']) ?></option>
                            <?php endforeach;
                        } else {
                            echo "<option value=''>Aucun domaine disponible</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
        <div class="mt-3 text-center">
            <p class="mb-0">Déjà un compte ? <a href="index.php?page=login" class="text-primary">Se connecter</a></p>
        </div>
    </div>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        var domaineSection = document.getElementById('domaine_section');
        if (this.value === 'eleve') {
            domaineSection.style.display = 'block';
            document.getElementById('id_categorie').setAttribute('required', 'required');
        } else {
            domaineSection.style.display = 'none';
            document.getElementById('id_categorie').removeAttribute('required');
        }
    });

    // Initialiser au chargement
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('role').dispatchEvent(new Event('change'));
    });
</script>
