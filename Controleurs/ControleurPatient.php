<?php

class ControleurPatient extends Controleur
{

    public function __construct()
    {
        $this->DAO = new PatientDAO(DBConnection::getInstance());
    }

    public function afficher($id)
    {
        // Verifier que le patient existe
        if ($this->DAO->exists_id($id)) {
            // Recuperer le patient
            $patient = $this->DAO->getById($id);
            // Choisir l'icone en fonction de la civilité
            if ($patient->getCivilite() == 'Monsieur')
                $icone = '/images/man.svg';
            else
                $icone = '/images/woman.svg';
            // Recuperer son medecin traitant s'il existe
            $traitant = new Medecin();
            $traitant->setPrenom('Aucun');
            // Si le patient a un traitant
            if ($id_traitant = $this->DAO->getIdMedecinTraitant($patient)) {
                $med_DAO = new MedecinDAO(DBConnection::getInstance());
                // Le recuperer à partir de son id et remplacer le medecin vide
                $traitant = $med_DAO->getById($id_traitant);
            }
            // Afficher la vue
            $this->vue = new Vue('AfficherPatient');
            $this->vue->generate(array(
                'patient' => $patient,
                'icone' => $icone,
                'traitant' => $traitant
            ));
        } else {
            $this->vue = new Vue('Erreur');
            $this->vue->generate(array(
                'titre_erreur' => 'Patient non trouvé',
                'message' => 'Désolé, ce patient n\'existe pas',
                'bouton' => 'Retour à la liste des patients',
                'chemin' => '/patients'
            ));
        }
    }

    public function afficher_page_modif($id)
    {
        if ($this->DAO->exists_id($id)) {
            $med_DAO = new MedecinDAO(DBConnection::getInstance());
            // Liste de tous les médecins
            $medecins = $med_DAO->getAll();
            $patient = $this->DAO->getById($id);
            // Recuperer son medecin traitant s'il existe
            $traitant = new Medecin();
            // Par defaut le medecin a un nom et prenom vide
            $traitant->setNom(' ');
            $traitant->setPrenom('Aucun');
            // Si le patient a un traitant
            if ($id_traitant = $this->DAO->getIdMedecinTraitant($patient)) {
                // Le recuperer à partir de son id et remplacer le medecin vide
                $traitant = $med_DAO->getById($id_traitant);
                // Le retirer de la liste des medecins pour ne pas avoir de doublon
                $this->delete_from_array($medecins, $traitant);
            }
            $this->vue = new Vue('ModifierPatient');
            // Passer à la vue les informations du patient et du medecin traitant
            $this->vue->generate(array(
                'patient' => $patient,
                'traitant' => $traitant,
                'medecins' => $medecins
            ));
        } else {
            $this->vue = new Vue('Erreur');
            $this->vue->generate(array(
                'titre_erreur' => 'Patient non trouvé',
                'message' => 'Désolé, ce patient n\'existe pas',
                'bouton' => 'Retour à la liste des patients',
                'chemin' => '/patients'
            ));
        }
    }

    public function modifier()
    {
        try {
            $id = InputHandler::post('id_patient');
            $nouveau_patient = new Patient();
            $nouveau_patient->setNom(InputHandler::post('nom'));
            $nouveau_patient->setPrenom(InputHandler::post('prenom'));
            $nouveau_patient->setCivilite(InputHandler::post('civilite'));
            $nouveau_patient->setNumSecu(InputHandler::post('num_secu'));
            $date = $this->toDateTime(InputHandler::post('date_naissance'))->format('Y-m-d');
            $nouveau_patient->setDateNaissance($date);
            $nouveau_patient->setAdresse(InputHandler::post('adresse'));
            if (InputHandler::post('medecin')) {
                $nouveau_patient->setIdMedecin(InputHandler::post('medecin'));
                echo 'MEDECIN' . InputHandler::post('medecin');

            }
            if ($this->DAO->update($id, $nouveau_patient)) {
                $this->afficherTousPatients();
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            $this->vue = new Vue('Erreur');
            $this->vue->generate(array(
                'titre_erreur' => 'Ajout impossible',
                'message_erreur' => "Impossible d'ajouter ce patient",
                'bouton' => 'Retour',
                'chemin' => '/ajout-patient'
            ));
        }
    }

    public function supprimer()
    {
        try {
            $id = InputHandler::post('id_patient');
            // Si le patient n'existe pas, lever une exception pour
            // se rendre directement dans le catch et afficher la page d'erreur
            if ($this->DAO->delete($id)) {
                // Renvoyer à la liste des patients
                header('location: /patients');
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            $this->vue = new Vue('Erreur');
            $this->vue->generate();
        }
    }

    public function ajouterPatient()
    {
        if (InputHandler::isValid(array('civilite', 'nom', 'prenom', 'date_naissance', 'adresse', 'num_secu'))) {
            try {
                // Cree un objet patient
                $patient = new Patient();
                // Lui attribuer les valeurs des champs
                $patient->setCivilite(InputHandler::post('civilite'));
                $patient->setNom(InputHandler::post('nom'));
                $patient->setPrenom(InputHandler::post('prenom'));
                $patient->setDateNaissance($this->toDBFormat(InputHandler::post('date_naissance')));
                $patient->setAdresse(InputHandler::post('adresse'));
                $patient->setNumSecu(InputHandler::post('num_secu'));
                if (InputHandler::post('medecin'))
                    $patient->setIdMedecin(InputHandler::post('medecin'));
                // L'inserer dans la base de donnee
                if ($this->DAO->insert($patient)) {
                    $this->vue = new Vue("Accueil");
                    $this->vue->generate(array());
                } else {
                    $this->vue = new Vue('Erreur');
                    $this->vue->generate(array(
                        'titre_erreur' => 'Erreur insertion',
                        'message_erreur' => 'Un patient avec les mêmes informations existe déjà',
                        'chemin' => '/ajouter-patient',
                        'bouton' => 'Retour'
                    ));
                }
            } catch (Exception $e) {
                $this->afficher404();
            }
        } else {
            $this->formulaireInvalide('/ajout-patient');
        }
    }

    public function afficherTousPatients()
    {
        $this->vue = new Vue('AfficherPatients');
        if ($liste_patients = $this->DAO->getAll()) {
            $this->vue->generate(array('listePatients' => $liste_patients));
        } else {
            // Gerer le cas ou la liste est vide:
            $this->vue->generate(array('listePatients' => array()));
        }
    }

    public function afficherAjoutConsultationPatient($id_patient)
    {
        $medecinDAO = new MedecinDAO(DBConnection::getInstance());
        $patientDAO = new PatientDAO(DBConnection::getInstance());
        $medecins = $medecinDAO->getAll();
        $patients = $patientDAO->getAll();
        $patient = $patientDAO->getById($id_patient);
        $medecin = $medecinDAO->getById($patient->getIdMedecin());
        if (!$medecin) {
            $medecin = null;
        } else {
            $this->delete_from_array($medecins, $medecin);
        }
        $this->delete_from_array($patients, $patient);
        $this->vue = new Vue('AjoutConsultation');
        $this->vue->generate(array(
            'listeMedecins' => $medecins,
            'listePatients' => $patients,
            'patient' => $patient,
            'medecin' => $medecin,
        ));

    }


    /**
     * Recherche un patient dans la liste
     */
    public function recherche()
    {
        try {
            $this->vue = new Vue('AfficherPatients');
            // Les termes de la recherche sont séparés par des espaces
            $mot_cles = explode(' ', InputHandler::get('recherche'));
            if ($liste_patients = $this->DAO->search($mot_cles)) {
                $this->vue->generate(array(
                    'listePatients' => $liste_patients
                ));
            } else {
                $this->vue->generate(array(
                    'listePatients' => array()
                ));
            }
        } catch (Exception $e) {
            // Un mauvais paramètre à été passé en get
            $this->afficher404();
        }
    }

    /**
     * Créé un string au format aaaa-mm-jj
     * compatible avec le format mySQL
     * depuis un string au foramt jj/mm/aaaa
     * @param $date
     * @return string
     */
    private function toDBFormat($date)
    {
        $dt = $this->toDateTime($date);
        return $dt->format('Y-m-d');
    }
}
