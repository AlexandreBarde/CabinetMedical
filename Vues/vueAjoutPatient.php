<?php

$this->title = "Ajouter un patient";

?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="display-3 text-center jumbotron-title">Ajouter un patient</h1>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
            <form action="./ajout-patient" method="post">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input autocomplete="off" required type="text" name="nom" id="nom" class="form-control">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input autocomplete="off" required type="text" name="prenom" id="prenom" class="form-control">
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <input autocomplete="off" required type="text" name="adresse" id="adresse" class="form-control">
                </div>
                <div class="form-group">
                    <label for="civilite">Civilité</label>
                    <select required name="civilite" class="form-control" id="civilite">
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
                    <input required type="text" name="date_naissance" id="date_naissance" class="form-control datepick">
                </div>
                <div class="form-group">
                    <label for="num_secu">Numéro de sécurité sociale</label>
                    <input autocomplete="off" required type="text" name="num_secu" id="num_secu" class="form-control">
                </div>
                <div class="form-group">
                    <label for="medecin">Médecin traitant</label>
                    <select name="medecin" class="form-control" id="medecin">
                        <option value="">Aucun</option>
                        <?php foreach ($medecins as $medecin): ?>
                            <option value="<?= $medecin->getId() ?>">
                                <?= $medecin->getPrenom() . ' ' . $medecin->getNom() ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary">Inscrire</button>
            </form>
        </div>
    </div>