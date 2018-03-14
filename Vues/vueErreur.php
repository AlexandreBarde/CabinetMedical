<?php
$this->title = $titre_erreur;
?>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-3">Oups</h1>
        <p class="lead"><?= $message ?></p>
        <hr class="my-4">
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="<?= $chemin ?>" role="button"><?= $bouton ?></a>
        </p>
    </div>
</div>
