<?php
$this->title = "Authentification";
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
<h1 class="display-3 text-center jumbotron-title">Authentification</h1>
</div>
<h2 class="text-center display-4">Veuillez vous connecter pour accéder à l'application</h2>
<div class="container" id="auth">
    <div class="row">
        <div class="col-xl-4 offset-xl-4 col-lg-4 offset-lg-4">
            <form action="/" method="post">
                <div class="form-group">
                    <input required class="form-control" type="text" name="username" id="username"
                           placeholder="Identifiant">
                </div>
                <div class="form-group">
                    <input required
                           class="form-control" type="password" name="password" id="password"
                           placeholder="Mot de passe">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="login" type="submit">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>
