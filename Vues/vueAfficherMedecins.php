<?php
$this->title = "Liste des médecins";
?>
<!-- Le jumbotron est giga grand c'est pas beau mais je pas quoi mettre d'autre -->
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="text-center display-3 jumbotron-title">Médecins</h1>
</div>
<div class="container-fluid">
    <div class="row search-row">
        <div class="col-xl-4 offset-xl-4">
            <form action="/medecins/recherche" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="recherche" placeholder="Rechercher un medecin"/>
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
                    <th class="text-center table-header">Civilité</th>
                    <th class="text-center table-header">Nom</th>
                    <th class="text-center table-header">Prénom</th>
                </tr>
                <?php foreach ($listeMedecins as $medecin): ?>
                    <tr class="table-row" data-href="/medecin/<?= $medecin->getId() ?>">
                        <td class="text-center table-column"><?= $medecin->getCivilite() ?></td>
                        <td class="text-center table-column"><?= $medecin->getNom() ?></td>
                        <td class="text-center table-column"><?= $medecin->getPrenom() ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
