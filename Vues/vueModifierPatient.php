<?php

$this->title = "Modifier un patient";

?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="display-3 text-center jumbotron-title">Modifier un patient</h1>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
            <form action="/modifier-patient" method="post">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input autocomplete="off" type="text" name="nom" id="nom" class="form-control" value="<?= $patient->getNom() ?>">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input autocomplete="off" type="text" name="prenom" id="prenom" class="form-control"
                           value="<?= $patient->getPrenom() ?>">
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <input autocomplete="off" type="text" name="adresse" id="adresse" class="form-control"
                           value="<?= $patient->getAdresse() ?>">
                </div>
                <div class="form-group">
                    <label for="civilite">Civilité</label>
                    <select name="civilite" class="form-control" id="civilite">
                        <option value="Monsieur">
                            Monsieur
                        </option>
                        <option value="Madame">
                            Madame
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date_naissance">Date de naissance</label>
                    <input autocomplete="off" type="text" name="date_naissance" id="date_naissance" class="form-control datepick"
                           value="<?= $patient->getFormattedDateNaissance() ?>">
                </div>
                <div class="form-group">
                    <label for="num_secu">Numéro de sécurité sociale</label>
                    <input autocomplete="off" type="text" name="num_secu" id="num_secu" class="form-control"
                           value="<?= $patient->getNumSecu() ?>">
                </div>
                <div class="form-group">
                    <label for="medecin">Médecin traitant</label>
                    <select name="medecin" class="form-control" id="medecin">
                        <option selected value="<?= $traitant->getId() ?>">
                            <?= $traitant->getPrenom() . ' ' . $traitant->getNom() ?>
                        </option>
                        <?php foreach ($medecins as $med): ?>
                            <option value="<?= $med->getId() ?>">
                                <?= $med->getPrenom() . ' ' . $med->getNom() ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <input type="hidden" value="<?= $patient->getId() ?>" name="id_patient">
                <button type="submit" class="btn btn-outline-primary">Modifier</button>
            </form>
        </div>
    </div>

