<?php
$this->title = "Ajouter une consultation";
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="display-3 text-center jumbotron-title">Ajouter une consultation</h1>
</div>
<div class="container-fluid">
    <form action="/ajout-consultation" method="post">
        <div class="row">
            <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <div class="form-group">
                    <label for="patient">Patient</label>
                    <select required name="id_patient" class="form-control" id="patient">
                        <?php if (isset($patient)): ?>
                            <option selected value=<?= $patient->getId() ?>>
                                <?= $patient->getPrenom() . ' ' . $patient->getNom() ?>
                            </option>
                        <?php endif; ?>
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
                        <?php if (isset($medecin)): ?>
                            <option selected value=<?= $medecin->getId() ?>>
                                <?= $medecin->getPrenom() . ' ' . $medecin->getNom() ?>
                            </option>
                        <?php endif; ?>
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
                               placeholder="Date: jj/mm/aaaa"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-clock"></i></span>
                        <input required class="form-control timepick" id="heure_debut" type="datetime-local"
                               name="heure_debut" placeholder="Heure: hh:mm"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-stopwatch"></i></span>
                        <input autocomplete="off" required id="duree" type="text" class="form-control" name="duree"
                               placeholder="Durée en minutes"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Inscrire</button>
            </div>
        </div>
    </form>
</div>
