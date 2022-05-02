<?php 
$title = 'Première connexion'; 
$navbar = false;
ob_start();
?>

<div class="row">

    <!-- En-tête de présentation -->
    <div class="col-md-12 text-center mb-4 mt-4">
        <img src="./public/img/logo-certa.png" class="img-fluid" alt="Logo du BTS SIO">       
    </div>

    <!-- Changement de mot de passe -->
    <div class="col-md-1"></div>

    <div class="col-md-5 my-auto">
        <h1>Première connexion :</h1>
        <p>Vous vous connectez pour la première fois grâce au mot de passe par défaut. Veuillez saisir un nouveau mot de passe.</p>
    </div>

    <div class="col-md-1"></div>

    <div class="col-md-4 border rounded customShadow pt-3 pb-3">
        <?php if ($erreur != null): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $erreur; ?>
        </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder="M0t d3 p4ss3">
            </div>
            <div class="form-group">
                <label>Confirmation du mot de passe</label>
                <input type="password" class="form-control" name="passwordConfirm" placeholder='M0t d3 p4ss3'>
            </div>
            <button type="submit" class="btn btn-secondary">Confirmer</button>
        </form>
    </div>

    <div class="col-md-1"></div>
    
    

</div>

<?php 
$content = ob_get_clean();
require('template.php'); 
?>