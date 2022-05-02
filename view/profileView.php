<?php 
$title = 'Ma Page'; 
$navbar = true;
ob_start();
?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-3 mb-4 mt-4">
        <div class="card customShadow">
            <div class="card-body">
                <h5 class="card-title"><?= $user['PRENOM_ETUD'].' '.$user['NOM_ETUD'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $user['OPTION_BTS_ETUD'] ?></h6>
                <?php if($user['PORTFOLIO_ETUD'] !== NULL): ?>
                <a href="<?= $user['PORTFOLIO_ETUD']?>" class="btn btn-secondary" target="_blank">Portfolio</a>
                <?php else: ?>
                    Portfolio non renseigné
                <?php endif; ?>  
            </div>
                
            <div class="card-footer text-center">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter">Modifier les informations</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier les informations | <?= $user['PRENOM_ETUD'].' '.$user['NOM_ETUD'] ?></h5>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-secondary">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4 mt-4 text-center">

    </div>
    <div class="col-md-1"></div>
</div>

<?php 
$content = ob_get_clean();
require('template.php'); 
?>