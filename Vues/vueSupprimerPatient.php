<?php

    $this->title = "Supprimer patient";

?>

<div class="row justify-content-md-center">
    <div class="col-6">
        <div class="card" style="width: 20rem;">
            <div class="card-body">
                <h4 class="card-title"><?= $patient->getNom() . " " . $patient->getPrenom() ?></h4>
                <p class="card-text"><i class="fa fa-venus-mars" aria-hidden="true"></i></i> <?= $patient->getCivilite() ?></p>
                <p class="card-text"><i class="fa fa-birthday-cake" aria-hidden="true"></i> <?= $patient->getDateNaissance() ?></p>
                <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $patient->getAdresse() ?></p>
                <p class="card-text"><i class="fa fa-id-card-o" aria-hidden="true"></i> <?= $patient->getNumSecu() ?></p>
                <p class="card-text"><i class="fa fa-medkit" aria-hidden="true"></i> <?= $patient->getIdMedecin() ?></p>
                <a href="#" class="card-link">Annuler</a>
                <a href="#" class="card-link">Modifier</a>
                <a href="#" class="card-link">Supprimer</a>
            </div>
        </div>
    </div>
</div>

