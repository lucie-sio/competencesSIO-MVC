<?php
$title = 'Erreur'; 
$navbar = false;
ob_start();
?>

<div class="row">
    <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card mx-auto customShadow" style="width: 50vw; margin-top: 20vh;">
                <div class="card-header text-center">
                    <h3>Une erreur est survenue lors du chargement de la page.</h3> 
                </div>
                <div class="card-body">
                
                    <h5 class="card-title">Informations d'erreur :</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        <?= $msg ?>
                    </h6>
                    
                </div>
                <div class="card-footer text-center">
                    <a href="./index.php?action=homepage" class="btn btn-secondary">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    <div class="col-md-2"></div>
</div>

<?php 

$content = ob_get_clean();
require('template.php'); 

?>