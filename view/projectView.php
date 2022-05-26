<?php 
$title = 'Projet'; 
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

    <!-- Bouton ModalProject -->
    <div class="col">
        <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#ModalProject">Modifier le projet</button>
    </div>

    <div class="col-12">
        <h1 class="text-center"><?= $project['LIBEL_PROJET'] ?></h1>
        <p><b>Description</b> : <?= $project['DESCRIPTION_PROJET']?></p>
        <hr>
    </div>

    <!-- TABLEAU DES INDICATEURS -->
    <div class="col-6">
        <table class="table table-bordered table-sm">
            <thead class="thead">
                <tr class="text-center">
                    <th colspan="3">Indicateurs</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projectIndicateurs as $indicateur): ?>
                <tr>
                    
                    <th class="text-center align-middle"><?= $indicateur['N_ITEM'] ?></th>
                    <td><?= $indicateur['LIBEL_ITEM'] ?></td>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="indicateur">
                        <td class="text-center align-middle"><button type="submit" class="btn btn-secondary" name="supprimer" value="<?= $indicateur['N_ITEM'] ?>">X</button></td>
                    </form>
                    
                </tr>
                <?php endforeach; ?>
                <tr class="text-center">
                    <td colspan="3">
                        <form action="" method="POST">
                            <select name="indicateur" class="form-control">
                                <?php foreach($indicateurs as $indicateur): ?>
                                    <?php if((!str_contains($indicateur['ID_ENSEMBLE_COMPETENCE'], 'SLAM') && !str_contains($indicateur['ID_ENSEMBLE_COMPETENCE'], 'SISR')) || str_contains($indicateur['ID_ENSEMBLE_COMPETENCE'], $_SESSION['option'])): ?>
                                        <?php if($ensemble !== $indicateur['LIBEL_ENSEMBLE_COMPETENCE']) :?>
                                            <?= $ensemble == '' ? '' : '</optgroup>' ; ?>
                                            <?php $ensemble = $indicateur['LIBEL_ENSEMBLE_COMPETENCE']; ?>                                           
                                            <optgroup label="<?= $indicateur['ID_NOM_BLOC'].' : '.$ensemble ?>">
                                        <?php endif; ?>
                                        <option value="<?= $indicateur['N_ITEM'] ?>"><?= $indicateur['N_ITEM'].' : '.$indicateur['LIBEL_ITEM'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <button type="submit" class="btn btn-secondary">Ajouter</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- TABLEAU DES SAVOIRS -->
    <div class="col-6">
        <table class="table table-bordered table-sm">
            <thead class="thead">
                <tr class="text-center">
                    <th colspan="3">Savoirs</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projectSavoirs as $savoir): ?>
                <tr>
                    <th class="text-center align-middle"><?= $savoir['N_ITEM'] ?></th>
                    <td><?= $savoir['LIBEL_ITEM'] ?></td>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="savoir">
                        <td class="text-center align-middle"><button type="submit" class="btn btn-secondary" name="supprimer" value="<?= $savoir['N_ITEM'] ?>">X</button></td>
                    </form>
                </tr>
                <?php endforeach; ?>
                <tr class="text-center">
                    <td colspan="3">
                        <form action="" method="POST">
                            <select name="savoir" class="form-control">
                                <?php foreach($savoirs as $savoir): ?>
                                    <?php if((!str_contains($savoir['ID_ENSEMBLE_COMPETENCE'], 'SLAM') && !str_contains($savoir['ID_ENSEMBLE_COMPETENCE'], 'SISR')) || str_contains($savoir['ID_ENSEMBLE_COMPETENCE'], $_SESSION['option'])): ?>
                                        <?php if($ensemble !== $savoir['LIBEL_ENSEMBLE_COMPETENCE']) :?>
                                            <?= $ensemble == '' ? '</optgroup>' : '' ; ?>
                                            <?php $ensemble = $savoir['LIBEL_ENSEMBLE_COMPETENCE'] ?>
                                            <optgroup label="<?= $savoir['ID_NOM_BLOC'].' : '.$ensemble ?>">
                                        <?php endif; ?>
                                        <option value="<?= $savoir['N_ITEM'] ?>"><?= $savoir['N_ITEM'].' : '.$savoir['LIBEL_ITEM'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <button type="submit" class="btn btn-secondary">Ajouter</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    

    <div class="col-12 text-center">
        <hr>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDelete">
            SUPPRIMER LE PROJET
        </button>
    </div>


    <!-- LISTE MODAL -->
    <!-- ModalProject -->
    <div class="modal fade" id="ModalProject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le projet</h5>
                </div>
                
                <form action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="modifier">
                        <div class="form-group">
                            <label>Nom du projet</label>
                            <input type="text" class="form-control" name="nameProject" placeholder="<?= $project['LIBEL_PROJET'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Description du projet (max. 1000 caractères)</label>
                            <textarea type="text" class="form-control" rows="3" maxlength="1000" name="descriptionProject"><?= $project['DESCRIPTION_PROJET'] ?></textarea>
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

    
    <!-- ModalDelete -->
    <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supprimer le projet</h5>
                </div>
                <div class="modal-body text-center">
                    <p>Cette action supprimera ce projet ainsi que les compétences associées.</p>
                    <form action="" method="POST">
                        <button class="btn btn-secondary btn-lg" type="submit" name="suppProjet">
                            Confirmer la suppression
                        </button>
                        <button type="button" class="btn btn-light btn-lg" data-dismiss="modal">Annuler</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ModalDelete End -->

</div>



<?php 
$content = ob_get_clean();
require('template.php'); 
?>