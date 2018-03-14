<?php
$this->title = "Ajouter un médecin";
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="display-3 text-center jumbotron-title">Ajouter un médecin</h1>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
            <form action="/ajout-medecin" method="post">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input autocomplete="off" required type="text" name="nom" id="nom" class="form-control">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input autocomplete="off" required type="text" name="prenom" id="prenom" class="form-control">
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
                <button type="submit" class="btn btn-outline-primary">Inscrire</button>
            </form>
        </div>
    </div>
</div>
