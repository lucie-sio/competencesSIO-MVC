<?php 
$title = 'Accueil'; 
$navbar = false;
ob_start();
?>



<div class="row">

    <!-- En-tête de présentation -->
    <div class="col-md-12 text-center mb-4 mt-4">
        <img src="./public/img/logo-certa.png" class="img-fluid" alt="Logo du BTS SIO">
        <h1>Base de compétences du BTS SIO</h1>
        <h4>Bienvenue sur l'espace de gestion de vos compétences SIO, pour accéder à votre suivi, veuillez vous connecter.</h4>
    </div>

    <!-- Login -->
    <div class="col-md-3"></div>
    <div class="col-md-6 border rounded customShadow pt-3 pb-3">
        <?php if ($erreur != null): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $erreur; ?>
        </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label>Adresse email</label>
                <input type="email" class="form-control" name="email" placeholder="identité@outlook.fr">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder='Par défaut : "sio"'>
            </div>
            <button type="submit" class="btn btn-secondary">Se connecter</button>
        </form>
        <a href="index.php?action=resetPassword" class="float-right">Mot de passe oublié ?</a>
    </div>
    <div class="col-md-3"></div>

</div>

<?php 

$content = ob_get_clean();
require('template.php'); 

?>