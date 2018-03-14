<?php

class ControleurAccueil extends Controleur
{
    private $medecinDAO;
    private $patientDAO;


    public function __construct()
    {
        $this->medecinDAO = new MedecinDAO(DBConnection::getInstance());
        $this->patientDAO = new PatientDAO(DBConnection::getInstance());
    }

    public function afficherAuthentification()
    {
        $this->vue = new Vue('Connexion');
        $this->vue->generate();
    }

    public function checkAuthentification()
    {
        if (InputHandler::isValid(array('username', 'password'))) {
            try {
                // Récupérer le login et mot de passe
                $login = InputHandler::post('username');
                $password = InputHandler::post('password');
                // Essayer de connecter l'utilisateur
                $auth = new Authenticator();
                if ($auth->login($login, $password)) {
                    // Si l'authentification est correcte, accorder l'accès à l'utilisateur
                    $_SESSION['username'] = $login;
                }
                // Dans tous les cas, le renvoyer à l'accueil
                header('location: /');
            } catch (Exception $e) {
                $this->afficher404();
            }
        } else {
            $this->formulaireInvalide('/');
        }
    }

    public function isLogged()
    {
        return isset($_SESSION['username']);
    }

    public function logout()
    {
        unset($_SESSION['username']);
        header('location: /');
    }

    public function afficherAccueil()
    {
        $this->vue = new Vue('Accueil');
        $this->vue->generate();
    }

    public function afficherAjoutPatient()
    {
        // On veut pouvoir proposer la liste des médecins
        $medecins = $this->medecinDAO->getAll();
        $this->vue = new Vue('AjoutPatient');
        $this->vue->generate(array(
            'medecins' => $medecins
        ));
    }

    public function afficherAjoutMedecin()
    {
        $this->vue = new Vue('AjoutMedecin');
        $this->vue->generate();
    }

    public function afficherAjoutConsultation()
    {
        // Médecins et patients

        $medecins = $this->medecinDAO->getAll();
        $patients = $this->patientDAO->getAll();
        $this->vue = new Vue('AjoutConsultation');
        $this->vue->generate(array(
            'listeMedecins' => $medecins,
            'listePatients' => $patients
        ));
    }


    public function afficherStatistiques()
    {
        // Recuperer tous les patients
        $listePatients = $this->patientDAO->getAll();
        // Initialiser tous les compteurs
        $hommeMoins25 = 0;
        $homme25et50 = 0;
        $hommePlus50 = 0;
        $femmeMoins25 = 0;
        $femme25et50 = 0;
        $femmePlus50 = 0;
        // Parcourir tous les patients
        foreach ($listePatients as $patient) {
            if ($patient->getAge() < 25) {
                if ($patient->getCivilite() == 'Monsieur')
                    $hommeMoins25++;
                else
                    $femmeMoins25++;
            } else if ($patient->getAge() > 50) {
                if ($patient->getCivilite() == 'Monsieur')
                    $hommePlus50++;
                else
                    $femmePlus50++;
            } else {
                if ($patient->getCivilite() == 'Monsieur')
                    $homme25et50++;
                else
                    $femme25et50++;
            }
        }

        // Preparer un tableau à passer à la vue
        $stats_patients = array(
            'hommeMoins25' => $hommeMoins25,
            'hommePlus50' => $hommePlus50,
            'homme25et50' => $homme25et50,
            'femmeMoins25' => $femmeMoins25,
            'femmePlus50' => $femmePlus50,
            'femme25et50' => $femme25et50
        );

        // Recuperer tous les médecins
        $listeMedecins = $this->medecinDAO->getAll();
        // Tableau qui à chaque médecin associe sont nombre d'heures de consultation
        $heuresConsult = array();
        // Parcourir tous les médecins
        foreach ($listeMedecins as $medecin) {
            // Recuperer le nom et prénom du medecin
            $cle = $medecin->getNom() . ' ' . $medecin->getPrenom();
            // Et le nombre d'heures qui lui sont associées
            $nbHeures = $this->medecinDAO->getHeures($medecin);
            // Créer l'entrée dans la tableau
            $heuresConsult[$cle] = $nbHeures;
        }

        // Passer les valeurs à la vue
        $this->vue = new Vue('Statistiques');
        $this->vue->generate(array_merge($stats_patients, array(
            'stats_medecins' => $heuresConsult
        )));

    }


}