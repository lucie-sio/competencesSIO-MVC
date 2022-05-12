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
                                <option selected>Choisir...</option>
                                <?php foreach($indicateurs as $indicateur): ?>
                                <option value="<?= $indicateur['N_ITEM'] ?>"><?= $indicateur['N_ITEM'].' : '.$indicateur['LIBEL_ITEM'] ?></option>
                                <?php endforeach; ?>
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
                            <option selected>Choisir...</option>
                            <?php foreach($savoirs as $savoir): ?>
                            <option value="<?= $savoir['N_ITEM'] ?>"><?= $savoir['N_ITEM'].' : '.$savoir['LIBEL_ITEM'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-secondary">Ajouter</button>
                    </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    





    <!-- ModalProject -->
    <div class="modal fade" id="ModalProject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
    <!-- ModalProject End -->

</div>



<?php 
$content = ob_get_clean();
require('template.php'); 
?>