<?php

    $this->titre = "Confirmer la suppression";

?>

<div class="row justify-content-md-center">
    <div class="col-6">
        <div class="card" style="width: 20rem;">
            <div class="card-body">
                <h4 class="card-title"><?= $medecin->getNom() . " " . $medecin->getPrenom() ?></h4>
                <p class="card-text"><i class="fa fa-venus-mars" aria-hidden="true"></i></i> <?= $medecin->getCivilite() ?></p>
                <a href="../" class="card-link">Annuler</a>
                <a href="#" class="card-link">Supprimer</a>
            </div>
        </div>
    </div>
</div>

