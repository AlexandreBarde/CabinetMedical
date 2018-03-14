<?php

// Charger l'autoloader
require('Autoloader.php');
Autoloader::register();

// Initialiser le routeur
$router = new Router($_GET['url']);
$cont = new ControleurAccueil();
$cont_med = new ControleurMedecin();
$cont_pat = new ControleurPatient();
$cont_cons = new ControleurConsultation();

// Demarrer la session
session_start();

// Si l'utilisateur n'est pas connecté
if (!$cont->isLogged()) {
    // Afficher le formulaire de connexion quand il arrive sur l'accueil
    $router->get('/', function () use ($cont) {
        $cont->afficherAuthentification();
    });
    // Quand le formulaire est validé, verifier ses informations de connection
    $router->post('/', function () use ($cont) {
        $cont->checkAuthentification();
    });

    // Si il essaie d'accéder à n'importe quelle autre url
    // sans être connecté, le renvoyer au formulaire de connexion
    try {
        $router->run();
    } catch (Exception $e) {
        header('location: /');
    }

} else {
    // Sinon, laisser l'accès à toutes les pages
    $router->get('/', function () use ($cont) {
        $cont->afficherAccueil();
    });

    $router->get('/ajout-patient', function () use ($cont) {
        $cont->afficherAjoutPatient();
    });

    $router->post('/ajout-patient', function () use ($cont_pat) {
        $cont_pat->ajouterPatient();
    });

    $router->post('/ajout-medecin', function () use ($cont_med) {
        $cont_med->ajouterMedecin();
    });

    $router->get('/ajout-medecin', function () use ($cont) {
        $cont->afficherAjoutMedecin();
    });


    $router->get('/patients', function () use ($cont_pat) {
        $cont_pat->afficherTousPatients();
    });

    $router->get('/medecins', function () use ($cont_med) {
        $cont_med->afficherTousMedecins();
    });

    $router->get('/medecins/recherche', function () use ($cont_med) {
        $cont_med->recherche();
    });

    $router->get('/patients/recherche', function () use ($cont_pat) {
        $cont_pat->recherche();
    });

    $router->get('/medecin/:id', function ($id) use ($cont_med) {
        $cont_med->afficher($id);
    });

    $router->get('/patient/:id', function ($id) use ($cont_pat) {
        $cont_pat->afficher($id);
    });

    $router->post('/supprimer-medecin', function () use ($cont_med) {
        $cont_med->supprimer();
    });

    $router->post('/supprimer-patient', function () use ($cont_pat) {
        $cont_pat->supprimer();
    });

    $router->get('/modifier-medecin/:id', function ($id) use ($cont_med) {
        $cont_med->afficher_page_modif($id);
    });

    $router->post('/modifier-medecin', function () use ($cont_med) {
        $cont_med->modifier();
    });

    $router->get('/modifier-patient/:id', function ($id) use ($cont_pat) {
        $cont_pat->afficher_page_modif($id);
    });

    $router->post('/modifier-patient', function () use ($cont_pat) {
        $cont_pat->modifier();
    });

    $router->get('/consultations', function () use ($cont_cons) {
        $cont_cons->afficherToutesConsultations();
    });

    $router->get('/consultation/:date/:med/:pat', function ($date, $med, $pat) use ($cont_cons) {
        $cont_cons->afficher($date, $med, $pat);
    });

    $router->get('/consultations/recherche', function () use ($cont_cons) {
        $cont_cons->recherche();
    });

    $router->get('/ajout-consultation', function () use ($cont) {
        $cont->afficherAjoutConsultation();
    });

    $router->get('/ajout-consultation/:id', function ($id) use ($cont_pat) {
        $cont_pat->afficherAjoutConsultationPatient($id);
    });

    $router->post('/ajout-consultation', function () use ($cont_cons) {
        $cont_cons->ajouterConsultation();
    });

    $router->get('/modifier-consultation/:date/:med/:pat', function ($date, $med, $pat) use ($cont_cons) {
        $cont_cons->afficher_page_modif($date, $med, $pat);
    });

    $router->post('/modifier-consultation', function () use ($cont_cons) {
        $cont_cons->modifier();
    });

    $router->post('/supprimer-consultation', function () use ($cont_cons) {
        $cont_cons->supprimer();
    });


    $router->get('/statistiques', function () use ($cont) {
        $cont->afficherStatistiques();
    });

    $router->get('/logout', function () use ($cont) {
       $cont->logout();
    });

    try {
        $router->run();
    } catch (Exception $e) {
        $cont->afficher404();
    }

}
