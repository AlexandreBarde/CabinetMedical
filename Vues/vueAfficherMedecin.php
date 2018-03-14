<?php

$this->title = "Afficher médecin";

?>
<div class="container">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-12">
            <div class="card affiche">
                <div class="card-body">
                    <img class="card-img-top" height="200" src="<?= $icone ?>" alt="image homme/femme">
                    <hr>
                    <h4 class="card-title text-center">Docteur <?= $medecin->getNom() . " " . $medecin->getPrenom() ?></h4>
                </div>
                <div class="list-group">
                    <a href="/modifier-medecin/<?= $medecin->getId() ?>" class="list-group-item list-group-item-action">
                        <span class="icon">
                            <i class="fas fa-edit"></i>
                        </span>
                        Modifier
                    </a>
                    <!-- On est obligé d'utiliser un formulaire pour passer l'id du medecin en post -->
                    <form action="/supprimer-medecin" method="post">
                        <input type="hidden" name="id_medecin" value="<?= $medecin->getId() ?>">
                        <button type="submit" class="list-group-item list-group-item-action">
                            <span class="icon">
                                <i class="fas fa-trash"></i>
                            </span>Supprimer
                        </button>
                    </form>
                    <a href="/medecins" class="list-group-item list-group-item-action">
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
