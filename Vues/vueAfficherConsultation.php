<?php

$this->title = "Afficher consultation";

?>
<div class="container">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-12">
            <div class="card affiche">
                <div class="card-body">
                    <img class="card-img" src="/images/calendar.svg" alt="icone calendrier" height="200">
                    <hr>
                    <h4 class="card-title text-center">Consultation</h4>
                    <p class="card-text"><span class="icon"><i
                                    class="far fa-calendar"></i></span> <?= $consultation->getDate() ?></p>
                    <p class="card-text"><span class="icon"><i
                                    class="far fa-clock"></i></span><?= $consultation->getHeureDebut() ?>
                        <span class="arrow-icon"><i
                                    class="fas fa-long-arrow-alt-right"></i></span><?= $consultation->getHeureFin() ?>
                    </p>
                    <p class="card-text"><span class="icon"><i
                                    class="fas fa-user-md"></i></span><?= $consultation->getMedecin()->getNom() . ' ' . $consultation->getMedecin()->getPrenom() ?>
                    </p>
                    <p class="card-text"><span class="icon"><i
                                    class="fas fa-user"></i></span><?= $consultation->getPatient()->getNom() . ' ' . $consultation->getPatient()->getPrenom() ?>
                    </p>
                </div>
                <div class="list-group">
                    <a href="/modifier-consultation/<?= $consultation->getDateDebut() . '/' . $consultation->getIdMedecin() . '/' . $consultation->getIdPatient() ?>"
                       class="list-group-item list-group-item-action">
                        <span class="icon">
                            <i class="fas fa-edit"></i>
                        </span>
                        Modifier
                    </a>
                    <form action="/supprimer-consultation" method="post">
                        <input type="hidden" name="id_medecin" value="<?= $consultation->getIdMedecin() ?>">
                        <input type="hidden" name="id_patient" value="<?= $consultation->getIdPatient() ?>">
                        <input type="hidden" name="date_debut" value="<?= $consultation->getDateDebut() ?>">
                        <button type="submit" class="list-group-item list-group-item-action">
                            <span class="icon">
                                <i class="fas fa-trash"></i>
                            </span>Supprimer
                        </button>
                    </form>
                    <a href="/consultations" class="list-group-item list-group-item-action">
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
