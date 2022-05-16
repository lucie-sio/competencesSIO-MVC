<?php 
$title = 'Profil'; 
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
    <?php elseif ($valide != null): ?>
    <div class="col-md-12" style="padding-left:10vw;padding-right:10vw;padding-top:1vh;">
        <div class="alert alert-success text-center" role="alert">
            <?= $valide; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- INFOS UTILISATEUR -->
   
    <div class="col-6">
        <h2 class="card-title"><?= $user['PRENOM_ETUD'].' '.$user['NOM_ETUD'] ?></h2>
        <h6 class="card-subtitle mb-2 text-muted"><?= $user['OPTION_BTS_ETUD'] ?></h6>
        <?php if($user['PORTFOLIO_ETUD'] !== NULL): ?>
            <a href="<?= $user['PORTFOLIO_ETUD']?>" target="_blank">Mon Portfolio</a>
        <?php else: ?>
            Portfolio non renseigné
        <?php endif; ?> 
    </div>

    <div class="col-6 text-right">
        <!-- Bouton ModalProfile -->
        <div>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#ModalProfile">Modifier mes informations</button>
        </div>
        <!-- Bouton ModalProject -->
        <div>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#ModalProject">Ajouter un projet</button>
        </div>
        
    </div>
    
    <!-- PROJETS -->
    <div class="col-12 mb-4 mt-4 pb-4 border">
        <h1 class="text-center"><b>Mes projets</b></h1>
        <hr>
        <div class="row">
            <!-- LES PROJETS -->
            <?php foreach($projects as $project): ?>
                <div class="col-lg-6 my-auto">
                    <div class="card mx-auto text-center zoomIn customShadow" style="width: 22rem;">
                        <img class="card-img-top" src="./public/img/question-mark.png" alt="Question mark">
                        <div class="card-body">
                            <h5 class="card-title"><?= $project['LIBEL_PROJET'] ?></h5>
                            <a href="index.php?action=project&id=<?= $project['ID_PROJET'] ?>" class="card-link">Voir le projet</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>  
            </div>
        </div>
    </div>


    <!-- MODAUX -->
    <!-- ModalProfile -->
    <div class="modal fade" id="ModalProfile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title">Modifier les informations | <?= $user['PRENOM_ETUD'].' '.$user['NOM_ETUD'] ?></h5>
                </div>
                <div class="modal-body">

                    <form action="" method="POST">
                        <input type="hidden" name="type" value="form1">
                        <label>Adresse internet de votre portfolio (<b>Exemple</b> : https://mon-portfolio.fr)</label>
                        <div class="form-row form-group">
                            <div class="col">
                                <input type="text" class="form-control" name="portfolio" placeholder="URL du portfolio" value="<?= $user['PORTFOLIO_ETUD']?>">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-light" name="supprimer">Supprimer</button>
                                <button type="submit" class="btn btn-secondary">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="form2">
                        <div class="form-row form-group">
                            <div class="col">
                                <label>Nouveau mot de passe</label>
                                <input type="password" class="form-control" name="newMdp">
                            </div>
                            <div class="col">
                                <label>Confirmer le mot de passe</label>
                                <input type="password" class="form-control" name="confMdp">
                            </div>                                                                   
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary">Enregistrer</button>  
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                </div>
                
            </div>
        </div>
    </div>
    <!-- ModalProfile End -->
        

    <!-- ModalProject -->
    <div class="modal fade" id="ModalProject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un projet</h5>
                </div>

                <form action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="type" value="form3">
                        <div class="form-group">
                            <label>Nom du projet</label>
                            <input type="text" class="form-control" name="nameProject">
                        </div>
                        <div class="form-group">
                            <label>Description du projet (max. 1000 caractères)</label>
                            <textarea type="text" class="form-control" rows="3" maxlength="1000" name="descriptionProject"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-secondary">Enregistrer</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!-- ModalProject End -->

</div>

<?php 
$content = ob_get_clean();
require('template.php'); 
?>