<?php 
$title = 'Recapitulatif'; 
$navbar = true;
ob_start();
?>



<div class="row">

    <?php if ($erreur != null): ?>
        <div class="col-md-12" style="padding-left:10vw;padding-right:10vw;padding-top:1vh;">
            <div class="alert alert-danger text-center" role="alert">
                <?= $erreur; ?>
            </div>
        </div>
    <?php endif; ?>

    Recapitulatif
    
</div>

<?php 
$content = ob_get_clean();
require('template.php'); 
?>