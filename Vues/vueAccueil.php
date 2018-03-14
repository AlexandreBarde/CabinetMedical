<?php
$this->title = 'Accueil';
?>
<div class="jumbotron jumbotron-fluid jumbotron-header">
    <h1 class="display-3 text-center jumbotron-title">Bienvenue</h1>
</div>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-sm-4 col-md-4">
            <div class="card">
                <a href="#menu-medecin" data-toggle="collapse">
                    <img src="../images/doctor.svg" alt="icone medecin" height="100"
                         class="mx-auto d-block icone-accueil"/>
                    <h4 class="text-center">Médecins</h4>
                </a>
                <div class="collapse" id="menu-medecin">
                    <div class="list-group">
                        <a href="./medecins" class="list-group-item list-group-item-action text-center">
                            <span class="icon">
                                <i class="fas fa-list-ul"></i>
                            </span>
                            Consulter la liste des médecins
                        </a>
                        <a href="./ajout-medecin" class="list-group-item list-group-item-action text-center">
                            <span class="icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            Ajouter un medecin
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="card">
                <a href="#menu-patient" data-toggle="collapse">
                    <img src="../images/man.svg" alt="icone medecin" height="100"
                         class="mx-auto d-block icone-accueil"/>
                    <h4 class="text-center">Patients</h4>
                </a>
                <div class="collapse" id="menu-patient">
                    <div id="menu-patient" class="list-group">
                        <a href="./patients" class="list-group-item list-group-item-action text-center">
                            <span class="list-icon">
                                <i class="fas fa-list-ul"></i>
                            </span>
                            Consulter la liste des patients
                        </a>
                        <a href="./ajout-patient" class="list-group-item list-group-item-action text-center">
                            <span class="icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            Ajouter un patient
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="card">
                <a href="#menu-consultation" data-toggle="collapse">
                    <img src="../images/calendar.svg" alt="icone consultation" height="100"
                         class="mx-auto d-block icone-accueil"/>
                    <h4 class="text-center">Consultations</h4>
                </a>
                <div class="collapse" id="menu-consultation">
                    <div id="menu-consultation" class="list-group">
                        <a href="./consultations" class="list-group-item list-group-item-action text-center">
                            <span class="list-icon">
                                <i class="fas fa-list-ul"></i>
                            </span>
                            Voir les consultations
                        </a>
                        <a href="./ajout-consultation" class="list-group-item list-group-item-action text-center">
                            <span class="icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            Ajouter une consultation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
