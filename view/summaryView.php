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

    <div class="col-md-12">
        <h4 class="text-center mb-4">Voici un récapitulatif des indicateurs et savoirs que vous avez utilisés lors de vos projets.</h4>

        <?php if(!empty($summaryIndicateurs)): ?>
            <!-- INDICATEURS -->
            <table class="table table-bordered table-sm">
                <thead class="thead">
                    <tr class="text-center">
                        <th colspan="2">Indicateurs</th>
                        <th>Projet(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($summaryIndicateurs as $indicateur): ?>
                        <?php if($indicateur['N_ITEM'] == $item): ?>
                            , <a href="index.php?action=project&id=<?= $indicateur['ID_PROJET'] ?>" target="_blank"><?= $indicateur['LIBEL_PROJET'] ?></a>
                        <?php else: ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= $indicateur['N_ITEM'] ?></td>
                            <td><?= $indicateur['LIBEL_ITEM'] ?></td>
                            <td class="text-center"><a href="index.php?action=project&id=<?= $indicateur['ID_PROJET'] ?>" target="_blank"><?= $indicateur['LIBEL_PROJET'] ?></a>
                            <?php endif ; ?>
                        <?php $item = $indicateur['N_ITEM'] ?>
                    <?php endforeach; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
                 
        <?php if(!empty($summarySavoirs)): ?>
            <!-- SAVOIRS -->
            <table class="table table-bordered table-sm">
                <thead class="thead">
                    <tr class="text-center">
                        <th colspan="2">Savoirs</th>
                        <th>Projet(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($summarySavoirs as $savoir): ?>
                        <?php if($savoir['N_ITEM'] == $item): ?>
                            , <a href="index.php?action=project&id=<?= $savoir['ID_PROJET'] ?>" target="_blank"><?= $savoir['LIBEL_PROJET'] ?></a>
                        <?php else: ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= $savoir['N_ITEM'] ?></td>
                            <td><?= $savoir['LIBEL_ITEM'] ?></td>
                            <td class="text-center"><a href="index.php?action=project&id=<?= $savoir['ID_PROJET'] ?>" target="_blank"><?= $savoir['LIBEL_PROJET'] ?></a>
                            <?php endif ; ?>
                        <?php $item = $savoir['N_ITEM'] ?>
                    <?php endforeach; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        
        <?php if(empty($summaryIndicateurs) && empty($summaryIndicateurs)): ?>
            <p class="text-center"><b>Aucun indicateurs ou savoirs n'ont été ajoutés.</b><br>
                <a href="./index.php?action=profile" class="btn btn-secondary">Mon profil</a>
            </p>
            
        <?php endif; ?>

    </div>
    
</div>

<?php 
$content = ob_get_clean();
require('template.php'); 
?>