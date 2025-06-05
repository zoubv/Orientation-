 
<section class="container my-5">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center text-primary mb-4">
                <i class="fas fa-user-circle"></i> Connexion
            </h2>
            <form action="index.php?page=loginAction" method="POST">
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
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
            <div class="mt-3 text-center">
                <p class="mb-0">Pas encore inscrit ? <a href="index.php?page=register" class="text-primary">Créer un compte</a></p>
            </div>
        </div>
    </div>
</section>