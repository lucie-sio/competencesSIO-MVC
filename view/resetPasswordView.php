<?php 
$title = 'Mot de passe'; 
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
        <h1>Réinitialisation du mot de passe</h1>
        <p>Veuillez saisir votre adresse mail, nous allons vous envoyez un lien vers votre messagerie pour réinitialiser votre mot de passe.</p>
    </div>

    <div class="col-md-1"></div>

    <div class="col-md-4 border rounded customShadow pt-3 pb-3">
        <?php if ($erreur != null): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $erreur; ?>
            </div>
            <?php endif; ?>
            <?php if ($valide != null): ?>
            <div class="alert alert-success text-center" role="alert">
                <?= $valide; ?>
            </div>
        <?php endif; ?>
        <?php if ($email != null):?>
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
            <a href="./index.php?action=homepage" class="btn btn-secondary float-right">Annuler</a>
        </form>
        <?php else: ?>
            <?php if ($email === ""):?>
            <div class="text-center">
                <a href="./index.php?action=homepage" class="btn btn-secondary">Accueil</a>
            </div>
            <?php else: ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Adresse mail</label>
                    <input type="email" class="form-control" name="email" placeholder="email@outlook.fr">
                </div>
                <button type="submit" class="btn btn-secondary">Confirmer</button>
                <a href="./index.php?action=homepage" class="btn btn-secondary float-right">Accueil</a>
            </form>
            <?php endif; ?>
        <?php endif; ?>
        
    </div>

    <div class="col-md-1"></div>
 
</div>

<?php 

$content = ob_get_clean();
require('template.php'); 

?>