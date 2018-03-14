<?php
$this->title = "Liste des consultations";
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="text-center display-3 jumbotron-title">Consultations</h1>
</div>
<div class="container-fluid">
    <div class="row search-row">
        <div class="col-xl-4 offset-xl-4">
            <form action="/consultations/recherche" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="recherche" placeholder="Rechercher une consultation"/>
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
                    <th class="text-center table-header">Date</th>
                    <th class="text-center table-header">Patient</th>
                    <th class="text-center table-header">Medecin</th>
                    <th class="text-center table-header">Heure début</th>
                    <th class="text-center table-header">Heure fin</th>
                </tr>
                <?php foreach ($listeConsultations as $consultation): ?>
                    <tr class="table-row" data-href="/consultation/<?= $consultation->getDateDebut() ?>/<?= $consultation->getIdMedecin() ?>/<?= $consultation->getIdPatient() ?>">
                        <td class="text-center table-column"><?= $consultation->getDate() ?></td>
                        <td class="text-center table-column"><?= $consultation->getPatient()->getNom() ?></td>
                        <td class="text-center table-column"><?= $consultation->getMedecin()->getNom() ?></td>
                        <td class="text-center table-column"><?= $consultation->getHeureDebut() ?></td>
                        <td class="text-center table-column"><?= $consultation->getHeureFin() ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
