<?php 
$title = 'Catalogue'; 
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

    <!-- Navigation -->
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="com-tab" data-toggle="tab" href="#com" role="tab" aria-controls="com" aria-selected="true">Compétences</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="ind-tab" data-toggle="tab" href="#ind" role="tab" aria-controls="ind" aria-selected="false">Indicateurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="sav-tab" data-toggle="tab" href="#sav" role="tab" aria-controls="sav" aria-selected="false">Savoirs</a>
            </li>
        </ul>
    </div>
    
    <!-- Tableaux des compétences/indicateurs/savoirs -->
    <div class="col-12">
        <div class="tab-content" id="myTabContent">

            <!-- COMPETENCES -->
            <div class="tab-pane fade show active" id="com" role="tabpanel" aria-labelledby="com-tab">
                <h1 class="text-center">Compétences du BTS SIO</h1>

                <?php foreach($competences as $competence): ?>
                    <?php if((!str_contains($competence['ID_ENSEMBLE_COMPETENCE'], 'SLAM') && !str_contains($competence['ID_ENSEMBLE_COMPETENCE'], 'SISR')) || str_contains($competence['ID_ENSEMBLE_COMPETENCE'], $_SESSION['option'])): ?>
                        <?php if ($bloc !== $competence['ID_NOM_BLOC']): ?>
                            <?php $bloc == '' ? '' : '</tbody>' ;?>
                            <?php $bloc == '' ? '' : '</table>' ;?>
                            <?php $bloc = $competence['ID_NOM_BLOC']; ?>
                            <table class="table table-bordered table-sm">
                                <thead class="thead">
                                    <tr class="text-center">
                                        <th colspan="2"><?= $bloc ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php endif; ?>
                        <?php if ($ensemble !== $competence['LIBEL_ENSEMBLE_COMPETENCE']): ?>
                            <?php $ensemble = $competence['LIBEL_ENSEMBLE_COMPETENCE']; ?>
                            <tr class="table-danger text-center">
                                <td colspan="2"><?= $ensemble ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><?= $competence['N_ITEM'] ?></td>
                            <td><?= $competence['LIBEL_ITEM'] ?></td>
                        </tr>    
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
                </table>

            </div>

            <!-- INDICATEURS -->
            <div class="tab-pane fade" id="ind" role="tabpanel" aria-labelledby="ind-tab">
                <h1 class="text-center">Indicateurs du BTS SIO</h1>

                <?php foreach($indicateurs as $indicateur): ?>
                    <?php if((!str_contains($indicateur['ID_ENSEMBLE_COMPETENCE'], 'SLAM') && !str_contains($indicateur['ID_ENSEMBLE_COMPETENCE'], 'SISR')) || str_contains($indicateur['ID_ENSEMBLE_COMPETENCE'], $_SESSION['option'])): ?>
                        <?php if ($bloc !== $indicateur['ID_NOM_BLOC']): ?>
                            <?php $bloc == '' ? '' : '</tbody>' ;?>
                            <?php $bloc == '' ? '' : '</table>' ;?>
                            <?php $bloc = $indicateur['ID_NOM_BLOC']; ?>
                            <table class="table table-bordered table-sm">
                                <thead class="thead">
                                    <tr class="text-center">
                                        <th colspan="2"><?= $bloc ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php endif; ?>
                        <?php if ($ensemble !== $indicateur['LIBEL_ENSEMBLE_COMPETENCE']): ?>
                            <?php $ensemble = $indicateur['LIBEL_ENSEMBLE_COMPETENCE']; ?>
                            <tr class="table-danger text-center">
                                <td colspan="2"><?= $ensemble ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><?= $indicateur['N_ITEM'] ?></td>
                            <td><?= $indicateur['LIBEL_ITEM'] ?></td>
                        </tr>    
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
                </table>

            </div>

            <!-- SAVOIRS -->
            <div class="tab-pane fade" id="sav" role="tabpanel" aria-labelledby="sav-tab">
                <h1 class="text-center">Savoirs du BTS SIO</h1>

                <?php foreach($savoirs as $savoir): ?>
                    <?php if((!str_contains($savoir['ID_ENSEMBLE_COMPETENCE'], 'SLAM') && !str_contains($savoir['ID_ENSEMBLE_COMPETENCE'], 'SISR')) || str_contains($savoir['ID_ENSEMBLE_COMPETENCE'], $_SESSION['option'])): ?>
                        <?php if ($bloc !== $savoir['ID_NOM_BLOC']): ?>
                            <?php $bloc == '' ? '' : '</tbody>' ;?>
                            <?php $bloc == '' ? '' : '</table>' ;?>
                            <?php $bloc = $savoir['ID_NOM_BLOC']; ?>
                            <table class="table table-bordered table-sm">
                                <thead class="thead">
                                    <tr class="text-center">
                                        <th colspan="2"><?= $bloc ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php endif; ?>
                        <?php if ($ensemble !== $savoir['LIBEL_ENSEMBLE_COMPETENCE']): ?>
                            <?php $ensemble = $savoir['LIBEL_ENSEMBLE_COMPETENCE']; ?>
                            <tr class="table-danger text-center">
                                <td colspan="2"><?= $ensemble ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><?= $savoir['N_ITEM'] ?></td>
                            <td><?= $savoir['LIBEL_ITEM'] ?></td>
                        </tr>    
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
                </table>

            </div>

        </div>
    </div>

</div>

<?php 
$content = ob_get_clean();
require('template.php'); 
?>