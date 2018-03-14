<?php
$this->title = "Liste des patients";
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="text-center display-3 jumbotron-title">Patients</h1>
</div>
<div class="container-fluid">
    <div class="row search-row">
        <div class="col-xl-4 offset-xl-4">
            <form action="/patients/recherche" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="recherche" placeholder="Rechercher un patient"/>
                    <span class="input-group-btn">
                    <button class="btn btn-secondary"><i class="fas fa-search"></i></button>
                </span>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <table class="table table-hover">
                <tr>
                    <th class="text-center table-header">Civilité</th>
                    <th class="text-center table-header">Nom</th>
                    <th class="text-center table-header">Prénom</th>
                    <th class="text-center table-header">Adresse</th>
                    <th class="text-center table-header">Date de naissance</th>
                </tr>
                <?php foreach ($listePatients as $patient): ?>
                    <tr class="table-row" data-href="/patient/<?= $patient->getId() ?>">
                        <td class="text-center table-column"><?= $patient->getCivilite() ?></td>
                        <td class="text-center table-column"><?= $patient->getNom() ?></td>
                        <td class="text-center table-column"><?= $patient->getPrenom() ?></td>
                        <td class="text-center table-column"><?= $patient->getAdresse() ?></td>
                        <td class="text-center table-column"><?= $patient->getFormattedDateNaissance() ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
