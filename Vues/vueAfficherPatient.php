<?php

$this->title = "Afficher patient";

?>

<div class="container">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-12 col-sm-12">
            <div class="card affiche">
                <div class="card-body">
                    <img src="<?= $icone ?>" height="200" alt="icone homme/femme" class="card-img-top">
                    <hr>
                    <h4 class="card-title text-center"><?= $patient->getCivilite() . " " . $patient->getNom() . " " . $patient->getPrenom() ?></h4>
                    <hr>
                    <p class="card-text">
                            <span class="icon">
                            <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                            </span>
                        <?= $patient->getFormattedDateNaissance() ?>
                    </p>
                    <p class="card-text">
                            <span class="icon">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </span>
                        <?= $patient->getAdresse() ?>
                    </p>
                    <p class="card-text">
                            <span class="icon">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                            </span>
                        <?= $patient->getNumSecu() ?>
                    </p>
                    <p class="card-text">
                            <span class="icon">
                            <i class="fa fa-medkit" aria-hidden="true"></i>
                            </span>
                        <?= $traitant->getNom() . ' ' . $traitant->getPrenom() ?>
                    </p>
                </div>
                <div class="list-group">
                    <a href="/ajout-consultation/<?= $patient->getId() ?>" class="list-group-item list-group-item-action">
                        <span class="icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        Ajouter une consultation
                    </a>
                    <a href="/modifier-patient/<?= $patient->getId() ?>" class="list-group-item list-group-item-action">
                        <span class="icon">
                            <i class="fas fa-edit"></i>
                        </span>
                        Modifier
                    </a>
                    <form action="/supprimer-patient" method="post">
                        <input type="hidden" name="id_patient" value="<?= $patient->getId() ?>">
                        <button type="submit" class="list-group-item list-group-item-action">
                            <span class="icon">
                                <i class="fas fa-trash"></i>
                            </span>Supprimer
                        </button>
                    </form>
                    <a href="/patients" class="list-group-item list-group-item-action">
                        <span class="icon">
                        <i class="fas fa-undo-alt"></i>
                        </span>
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
