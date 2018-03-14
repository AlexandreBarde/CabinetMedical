<?php
$this->title = "Modifier une consultation";
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="display-3 text-center jumbotron-title">Modifier une consultation</h1>
</div>
<div class="container-fluid">
    <form action="/modifier-consultation" method="post">
        <div class="row">
            <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <div class="form-group">
                    <label for="patient">Patient</label>
                    <select required name="id_patient" class="form-control" id="patient">
                        <option selected value="<?= $consultation->getIdPatient() ?>">
                            <?= $consultation->getPatient()->getPrenom() . ' ' . $consultation->getPatient()->getNom() ?>
                        </option>
                        <?php foreach ($listePatients as $patient): ?>
                            <option value="<?= $patient->getId() ?>">
                                <?= $patient->getPrenom() . ' ' . $patient->getNom() ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="medecin">Médecin</label>
                    <select required name="id_medecin" class="form-control" id="medecin">
                        <?php if ($consultation->getIdMedecin() != null): ?>
                            <option selected value="<?= $consultation->getIdMedecin() ?>">
                                <?= $consultation->getMedecin()->getPrenom() . ' ' . $consultation->getMedecin()->getNom() ?>
                            </option>
                        <?php endif ?>
                        <?php foreach ($listeMedecins as $medecin): ?>
                            <option value="<?= $medecin->getId() ?>">
                                <?= $medecin->getPrenom() . ' ' . $medecin->getNom() ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                        <input required class="datepick form-control" id="date" type="text" name="date"
                               value="<?= $consultation->getDate() ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-clock"></i></span>
                        <input required class="form-control timepick" id="heure_debut" type="text" name="heure_debut"
                               value="<?= $consultation->getHeureDebut() ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-stopwatch"></i></span>
                        <input autocomplete="off" required id="duree" type="text" class="form-control" name="duree"
                               value="<?= $consultation->getDuree() ?>"/>
                    </div>
                </div>
                <input type="hidden" value="<?= $consultation->getIdMedecin() ?>" name="old_id_medecin">
                <input type="hidden" value="<?= $consultation->getIdPatient() ?>" name="old_id_patient">
                <input type="hidden" value="<?= $consultation->getDateDebut() ?>" name="old_date_debut">
                <button type="submit" class="btn btn-outline-primary">Modifier</button>
            </div>
        </div>

    </form>
</div>
