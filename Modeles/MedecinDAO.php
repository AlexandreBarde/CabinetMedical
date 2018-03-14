<?php

class MedecinDAO extends GenericDAO
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
        $this->table = 'Medecin';
    }

    /**
     * Donne le nom de la clé primaire de l'entité
     * @return string
     *      Nom de la clé
     */
    public function getPrimaryKey()
    {
        return 'id_medecin';
    }

    /**
     * Retourne un tableau contenant tous les médecins
     * @return array|bool
     *      Le tableau si il existe au moins un médecin
     *      Faux sinon
     */
    public function getAll()
    {
        if (sizeof(parent::getAll()) > 0) {
            $liste_medecins = array();
            foreach (parent::getAll() as $row) {
                $med = new Medecin();
                $med->setNom($row['nom']);
                $med->setPrenom($row['prenom']);
                $med->setCivilite($row['civilite']);
                $med->setId($row['id_medecin']);
                array_push($liste_medecins, $med);
            }
            return $liste_medecins;
        }
        return false;
    }

    /**
     * Recupere un medecin à partir de son id
     * @param $id
     * @return mixed
     *      Medecin si trouve, faux sinon
     */
    public function getById($id)
    {
        if ($data = parent::getById($id)) {
            $med = new Medecin();
            $med->setId($data['id_medecin']);
            $med->setNom($data['nom']);
            $med->setPrenom($data['prenom']);
            $med->setCivilite($data['civilite']);
            return $med;
        }
        return false;
    }

    /**
     * Recherche un medecin dans la base de données à partir
     * de mots clés
     * @param $keywords
     * @return array|bool
     */
    public function search($keywords)
    {
        $med = new Medecin();
        $params = array();
        $rqt = "SELECT * FROM $this->table WHERE ";
        for ($i = 0; $i < sizeof($keywords); $i++) {
            foreach ($med->getFields() as $field => $val) {
                $rqt .= 'LOWER(' . ($field) . ') LIKE :p' . $i . ' OR ';
                // Preparer le tableau d'execution
                $params[':p' . $i] = '%' . $keywords[$i] . '%';
            }
            // Enlever le dernier OR
            $rqt = substr($rqt, 0, -3);
            $rqt .= 'AND ';
        }
        // Enlever le AND OR à la fin de la requête
        $rqt = substr($rqt, 0, -4);
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute($params);
        if ($prerqt->rowCount() > 0) {
            $meds = array();
            while ($data = $prerqt->fetch()) {
                $med = new Medecin();
                $med->setId($data['id_medecin']);
                $med->setNom($data['nom']);
                $med->setPrenom($data['prenom']);
                $med->setCivilite($data['civilite']);
                array_push($meds, $med);
            }
            return $meds;
        } else {
            return false;
        }
    }

    /**
     * Retourne le nombre d'heure de consultation
     * pour un medecin donné
     * @param Medecin $med
     * @return String
     */
    public function getHeures(Medecin $med)
    {
        // Recuperer un tableau de toutes les consultations effectuée par le medecin
        $consultationDAO = new ConsultationDAO(DBConnection::getInstance());
        $cons = $consultationDAO->getByMedecin($med->getId());
        $totalMinutes = 0;
        foreach ($cons as $consultation) {
            $totalMinutes += $consultation->getDuree();
        }
        $heures = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        if ($minutes > 0) {
            if ($minutes < 10)
                $minutes = '0' . $minutes;
            return $heures . 'h' . $minutes;
        } else {
            return strval($heures);
        }
    }

}
