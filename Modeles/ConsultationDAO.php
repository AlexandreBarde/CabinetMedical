<?php

class ConsultationDAO
{
    private $table;
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
        $this->table = 'Consultation';
    }

    /**
     * Vérifie qu'un consultation existe
     * @param Consultation $cons
     *      Consultation à verifier
     * @return boolean
     *      Vrai si la consultation existe
     */
    public function exists(Consultation $cons)
    {
        $rqt = "SELECT id_medecin, id_patient, date_debut FROM $this->table WHERE id_medecin = :id_medecin
                AND id_patient = :id_patient AND date_debut = :date_debut";
        $prerqt = $this->conn->prepare($rqt);
        $fields = $cons->getFields();
        // Supprimer le dernier element du tableau: la date de fin
        array_pop($fields);
        $prerqt->execute($fields);
        return $prerqt->rowCount() > 0;
    }

    /**
     * Insere une consultation dans la base de données
     * @param Consultation $cons
     *      Consultation a inserer
     * @return boolean
     *      Vrai si l'insertion a reussi
     */
    public function insert(Consultation $cons)
    {
        if (!$this->exists($cons)) {
            $rqt = "INSERT INTO $this->table(id_medecin, id_patient, date_debut, date_fin)
                    VALUES(:id_medecin, :id_patient, :date_debut, :date_fin)";
            $prerqt = $this->conn->prepare($rqt);
            return $prerqt->execute($cons->getFields());
        }
        return false;
    }

    /**
     * Récupère toutes les consultations
     * @return array
     */
    public function getAll()
    {
        $res = $this->conn->query('SELECT * FROM ' . $this->table . ' ORDER BY date_debut');
        $liste_consultations = array();
        while ($data = $res->fetch()) {
            $cons = new Consultation();
            $cons->setDateDebut($data['date_debut']);
            $cons->setDateFin($data['date_fin']);
            $cons->setIdPatient($data['id_patient']);
            $cons->setIdMedecin($data['id_medecin']);
            array_push($liste_consultations, $cons);
        }
        return $liste_consultations;
    }

    /**
     * Supprime une consultation de la base de données
     * @param Consultation $cons
     * @return bool
     */
    public function delete(Consultation $cons)
    {
        if ($this->exists($cons)) {
            $rqt = "DELETE FROM $this->table where date_debut = :date_deb
                    and id_patient = :id_patient and id_medecin = :id_medecin";
            $prerqt = $this->conn->prepare($rqt);
            $prerqt->execute(array(
                'date_deb' => $cons->getDateDebut(),
                'id_patient' => $cons->getIdPatient(),
                'id_medecin' => $cons->getIdMedecin()
            ));
            return $this->exists($cons);
        }
        return false;
    }

    /**
     * Récupere une consultation à partir de l'id d'un patient, d'un médecin
     * et d'une date de début au format aaaa-mm-dd hh:mm:ss
     * @param $id_patient
     * @param $id_medecin
     * @param $date_deb
     * @return bool|Consultation
     */
    public function get($id_patient, $id_medecin, $date_deb)
    {
        $rqt = "SELECT * FROM $this->table WHERE id_medecin = :id_medecin AND id_patient = :id_patient
                AND date_debut = :date_debut";
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute(array(
            'id_medecin' => $id_medecin,
            'id_patient' => $id_patient,
            'date_debut' => $date_deb
        ));
        if ($prerqt->rowCount() > 0) {
            $cons = new Consultation();
            $data = $prerqt->fetch();
            $cons->setIdPatient($data['id_patient']);
            $cons->setIdMedecin($data['id_medecin']);
            $cons->setDateDebut($data['date_debut']);
            $cons->setDateFin($data['date_fin']);
            return $cons;
        }
        return false;
    }

    /**
     * Vérifie qu'un créneau soit libre,
     * donc que le patient et le médecin n'ont
     * pas déjà une consultationsur le créneau
     * @param Consultation $cons
     * @return bool
     */
    public function isFree(Consultation $cons)
    {
        /** Un créneau est libre si sa date de début et sa date de fin ne sont pas
         * comprise en la date de début et de fin d'un autre créneau pour le même
         * médecin ou le même patient.
         *
         * 2 créneau A1 -> A2 et B2 -> B2 se chevauchent si:
         * (A1 <= B2) && (A2 >= B1)
         */
        $rqt = "SELECT COUNT(*) from $this->table
                WHERE :debut <= date_fin
                AND :fin >= date_debut
                AND (id_medecin = :id_medecin OR id_patient = :id_patient)";
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute(array(
            'debut' => $cons->getDateDebut(),
            'fin' => $cons->getDateFin(),
            'id_medecin' => $cons->getIdMedecin(),
            'id_patient' => $cons->getIdPatient()
        ));
        // Si la consultation en chevauche une autre, alors COUNT > 0
        $res = $prerqt->fetch();
        return $res[0] == 0;
    }

    /**
     * Vérifie si un créneau est libre lors d'une modifcation
     * @param $date_debut
     * @param $med
     * @param $pat
     * @param Consultation $nouveau
     * @return bool
     */
    public function isFreeModif($date_debut, $med, $pat, Consultation $nouveau)
    {
        // Trouver les créneaux qui pourrait se chevaucher sans prendre en compte
        // l'ancien créneau qu'occupait, puisqu'il n'existera plus après la modification
        $rqt = "SELECT COUNT(*) from $this->table
                WHERE :debut <= date_fin
                AND :fin >= date_debut
                AND date_debut <> :old_debut
                AND (id_medecin = :id_medecin OR id_patient = :id_patient)";
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute(array(
            'debut' => $nouveau->getDateDebut(),
            'fin' => $nouveau->getDateFin(),
            'id_medecin' => $med,
            'id_patient' => $pat,
            'old_debut' => $date_debut,
        ));
        $res = $prerqt->fetch();
        return $res[0] == 0;

    }

    public function update($date_debut, $med, $pat, Consultation $nouveau)
    {
        if (!$this->exists($nouveau)) {
            $rqt = "UPDATE $this->table SET date_debut = :date_debut,
            date_fin = :date_fin, id_medecin = :id_medecin, id_patient = :id_patient
            WHERE id_medecin  = :old_id_medecin AND id_patient = :old_id_patient
            AND date_debut = :old_date_debut";
            $prerqt = $this->conn->prepare($rqt);
            return $prerqt->execute(array(
                'date_debut' => $nouveau->getDateDebut(),
                'date_fin' => $nouveau->getDateFin(),
                'id_medecin' => $nouveau->getIdMedecin(),
                'id_patient' => $nouveau->getIdPatient(),
                'old_id_medecin' => $med,
                'old_id_patient' => $pat,
                'old_date_debut' => $date_debut
            ));

        } else {
            return false;
        }
    }


    /**
     * Retourne un tableau de consultations
     * effectuées par un medecin d'id donné
     * @param $id_medecin
     * @return array
     */
    public function getByMedecin($id_medecin)
    {
        $rqt = "SELECT * FROM $this->table WHERE id_medecin = :id_medecin";
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute(array(
            'id_medecin' => $id_medecin
        ));
        $listeConsulation = array();
        while ($data = $prerqt->fetch()) {
            $cons = new Consultation();
            $cons->setDateDebut($data['date_debut']);
            $cons->setDateFin($data['date_fin']);
            $cons->setIdMedecin($data['id_medecin']);
            $cons->setIdPatient($data['id_patient']);
            array_push($listeConsulation, $cons);
        }
        return $listeConsulation;
    }

    /**
     * Recherche une consultation dans la base de données à partir
     * d'une liste de mots clés
     * @param $keywords
     * @return array|bool
     */
    public
    function search(array $keywords)
    {
        $params = array();
        // Base de la requête + jointures
        $rqt = 'SELECT Consultation.* FROM Consultation, Medecin, Patient WHERE Consultation.id_medecin = Medecin.id_medecin AND Consultation.id_patient = Patient.id_patient AND (';
        for ($i = 0; $i < sizeof($keywords); $i++) {
            // Dates
            $rqt .= " DATE_FORMAT(date_debut, \"%d/%m/%Y\") = '$keywords[$i]' OR ";
            $rqt .= " DATE_FORMAT(date_fin, \"%d/%m/%Y\") = '$keywords[$i]' OR ";
            // Noms
            $rqt .= "Medecin.nom LIKE '%$keywords[$i]%' OR ";
            $rqt .= "Patient.nom LIKE '%$keywords[$i]%'";
            $rqt .= 'AND ';
            $params[':p' . $i] = $keywords[$i];
        }
        // Enlever le AND à la fin de la requête
        $rqt = substr($rqt, 0, -4);
        $rqt .= ')';
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute($params);
        if ($prerqt->rowCount() > 0) {
            $consults = array();
            while ($data = $prerqt->fetch()) {
                $cons = new Consultation();
                $cons->setDateDebut($data['date_debut']);
                $cons->setDateFin($data['date_fin']);
                $cons->setIdMedecin($data['id_medecin']);
                $cons->setIdPatient($data['id_patient']);
                array_push($consults, $cons);
            }
            return $consults;
        } else {
            return false;
        }
    }

}
