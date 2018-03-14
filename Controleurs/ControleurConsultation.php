<?php

class ControleurConsultation extends Controleur
{
    public function __construct()
    {
        $this->DAO = new ConsultationDAO(DBConnection::getInstance());
    }


    /**
     * Ajoute une consultation dans la base de données
     */
    public function ajouterConsultation()
    {
        if (InputHandler::isValid(array('id_patient', 'id_medecin', 'heure_debut', 'duree', 'date'))) {
            try {
                $consultation = new Consultation();
                $consultation->setIdMedecin(InputHandler::post('id_medecin'));
                $consultation->setIdPatient(InputHandler::post('id_patient'));
                $date = $this->makeDateTime(InputHandler::post('date'), InputHandler::post('heure_debut'));
                $consultation->setDateDebut($this->toDBFormatHours($date));
                $consultation->dateFinFromDuree(InputHandler::post('duree'));
                if ($this->DAO->isFree($consultation)) {
                    if ($this->DAO->insert($consultation)) {
                        header('location: /consultations');
                    } else {
                        $this->vue = new Vue("Erreur");
                        $this->vue->generate(array(
                            'titre_erreur' => 'Ajout impossible',
                            'message' => "Cette consultation n'est pas valide",
                            'chemin' => '/ajout-consultation',
                            'bouton' => 'Retour'
                        ));
                    }
                } else {
                    $this->vue = new Vue("Erreur");
                    $this->vue->generate(array(
                        'titre_erreur' => 'Chevauchement de consultation',
                        'message' => 'Ce créneau est déjà occupé',
                        'chemin' => '/ajout-consultation',
                        'bouton' => 'Retour'
                    ));
                }
            } catch (Exception $e) {
                $this->afficher404();
            }
        } else {
            $this->formulaireInvalide('/ajout-consultation');

        }
    }

    /**
     * Affiche la liste de toutes les consultations
     */
    public function afficherToutesConsultations()
    {
        $consultations = $this->DAO->getAll();
        array_map(array('ControleurConsultation', 'setMedecinPatient'), $consultations);
        $this->vue = new Vue('AfficherConsultations');
        $this->vue->generate(array(
            'listeConsultations' => $consultations
        ));
    }

    /**
     * Affiche les détails d'une consultation
     * @param $date
     * @param $med
     * @param $pat
     */
    public function afficher($date, $med, $pat)
    {
        $consultation = $this->DAO->get($pat, $med, $date);
        // Associer le nom du médecin et du patient à la consultation
        $this->setMedecinPatient($consultation);
        $this->vue = new Vue('AfficherConsultation');
        $this->vue->generate(array(
            'consultation' => $consultation
        ));
    }

    /**
     * Recherche une consultation à partir d'une liste de
     * mots clés
     */
    public function recherche()
    {
        try {
            $this->vue = new Vue('AfficherConsultations');
            // Les termes de la recherche sont séparés par des espaces
            $mot_cles = explode(' ', InputHandler::get('recherche'));
            if ($liste_consultations = $this->DAO->search($mot_cles)) {
                array_map(array('ControleurConsultation', 'setMedecinPatient'), $liste_consultations);
                $this->vue->generate(array(
                    'listeConsultations' => $liste_consultations
                ));
            } else {
                $this->vue->generate(array(
                    'listeConsultations' => array()
                ));
            }
        } catch (Exception $e) {
            $this->afficher404();
        }
    }

    /**
     * Supprime la consultation dont l'id est passée en post
     */
    public function supprimer()
    {
        try {
            if ($consultation = $this->DAO->get(InputHandler::post('id_patient'), InputHandler::post('id_medecin'), InputHandler::post('date_debut'))) {
                $this->DAO->delete($consultation);
                header('location: /consultations');
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            $this->afficher404();
        }
    }

    /**
     * Affiche le formulaire pour la modification d'une consultation
     * d'id donné
     * @param $date
     * @param $med
     * @param $pat
     */
    public function afficher_page_modif($date, $med, $pat)
    {
        if ($consultation = $this->DAO->get($pat, $med, $date)) {
            $medecinDAO = new MedecinDAO(DBConnection::getInstance());
            $patientDAO = new PatientDAO(DBConnection::getInstance());
            $this->setMedecinPatient($consultation);
            // Recuperer les patients et les medecins
            $listePatients = $patientDAO->getAll();
            $listeMedecins = $medecinDAO->getAll();
            // Enlever de la liste le médecin  et la patient concerné
            // pour éviter la répétition dans la vue
            $this->delete_from_array($listeMedecins, $medecinDAO->getById($med));
            $this->delete_from_array($listePatients, $patientDAO->getById($pat));
            $this->vue = new Vue('ModifierConsultation');
            $this->vue->generate(array(
                'listePatients' => $listePatients,
                'listeMedecins' => $listeMedecins,
                'consultation' => $consultation
            ));
        } else {
            $this->afficher404();
        }
    }

    public function modifier()
    {
        // Verifier que le formulaire soit bien valide
        if (InputHandler::isValid(array('id_patient', 'id_medecin', 'heure_debut', 'duree', 'date'))) {
            try {
                // Créer une consultation à partir des infos du formulaire
                $cons = new Consultation();
                $cons->setIdMedecin(InputHandler::post('id_medecin'));
                $cons->setIdPatient(InputHandler::post('id_patient'));
                $date = $this->makeDateTime(InputHandler::post('date'), InputHandler::post('heure_debut'));
                $cons->setDateDebut($this->toDBFormatHours($date));
                $cons->dateFinFromDuree(InputHandler::post('duree'));
                $old_id_patient = InputHandler::post('old_id_patient');
                $old_id_medecin = InputHandler::post('old_id_medecin');
                $old_date_debut = InputHandler::post('old_date_debut');
                // Verifier que le créneau soit libre
                if ($this->DAO->isFreeModif($old_date_debut, $old_id_medecin, $old_id_patient, $cons)) {
                    // Modifier la consultation avec les nouvelle informations
                    $this->DAO->update($old_date_debut, $old_id_medecin, $old_id_patient, $cons);
                    // Puis afficher la liste des consultations
                    $this->afficherToutesConsultations();
                } else {
                    $this->vue = new Vue("Erreur");
                    $this->vue->generate(array(
                        'titre_erreur' => 'Chevauchement de consultation',
                        'message' => 'Ce créneau est déjà occupé par un autre médecin',
                        'chemin' => "/modifier-consultation/$old_date_debut/$old_id_medecin/$old_id_patient",
                        'bouton' => 'Retour'
                    ));
                }
            } catch (Exception $e) {
                $this->afficher404();
            }
        } else {
            $this->formulaireInvalide('/consultations');
        }
    }

    /**
     * Construit une date au format jj/mm/aaaa hh:mm:ss
     * a partir d'une date et d'une heure dans les
     * mêmes formats
     * @param $date
     * @param $time
     * @return string
     */
    public function makeDateTime($date, $time)
    {
        $dt = $this->toDateTime($date);
        $arr = explode(':', $time);
        $hours = $arr[0];
        $minutes = $arr[1];
        $dt->add(new DateInterval('PT' . $hours . 'H' . $minutes . 'M'));
        return $dt->format('d/m/Y H:i:s');
    }

    /**
     * Retourne une date+heure au format
     * aaaa-mm-jj h:m:s depuis un string
     * au format jj/mm/aaaa h:m:s
     * @param $date
     * @return string
     */
    protected function toDBFormatHours($date)
    {
        $dt = $this->toDateTime($date);
        return $dt->format('Y-m-d H:i:s');
    }

    /**
     * Associe à une consultation le nom de son médecin et
     * de son patient
     * @param Consultation $con
     */
    private function setMedecinPatient(Consultation $con)
    {
        $medecinDAO = new MedecinDAO(DBConnection::getInstance());
        $patientDAO = new PatientDAO(DBConnection::getInstance());
        $con->setMedecin($medecinDAO->getById($con->getIdMedecin()));
        $con->setPatient($patientDAO->getById($con->getIdPatient()));
    }
}
