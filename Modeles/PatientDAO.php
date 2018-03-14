<?php

class PatientDAO extends GenericDAO
{

    /**
     * Constructeur de PatientDAO
     * @param PDO $connexion Connexion à la BDD
     */
    public function __construct(PDO $connexion)
    {
        parent::__construct($connexion);
        $this->table = 'Patient';
    }

    /**
     * Retourne tous les patients
     * @return mixed array boolean
     *      faux s'il n'y a aucun patient
     *      une liste de patient sinon
     */
    public function getAll()
    {
        if (sizeof(parent::getAll()) > 0) {
            $liste_patient = array();
            foreach (parent::getAll() as $row) {
                $patient = new Patient();
                $patient->setId($row['id_patient']);
                $patient->setIdMedecin($row['id_medecin']);
                $patient->setCivilite($row['civilite']);
                $patient->setNom($row['nom']);
                $patient->setPrenom($row['prenom']);
                $patient->setAdresse($row['adresse']);
                $patient->setDateNaissance($row['date_naissance']);
                $patient->setNumSecu($row['num_secu']);
                array_push($liste_patient, $patient);
            }
            return $liste_patient;
        }
        return false;
    }

    /**
     * Donne le nom de la clé primaire de la table Patient
     * @return string
     *      Clé primaire
     */
    public function getPrimaryKey()
    {
        return 'id_patient';
    }

    /**
     * Recupere l'id du medecin traitant d'un patient
     * @param Patient $pat
     *      Patient dont on veut récuperer le medecin
     * @return mixed
     *      Id du medecin si il existe, faux sinon
     *
     */
    public function getIdMedecinTraitant(Patient $pat)
    {
        $rqt = "SELECT id_medecin FROM $this->table WHERE id_patient = :id_patient";
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute(array('id_patient' => $pat->getId()));
        if ($prerqt->rowCount() == 1) {
            return $prerqt->fetch()['id_medecin'];
        }
        return false;
    }

    /**
     * Associe à un patient son medecin traitant
     * Ca sera peut etre plus pratique de  prendre les id en parametre
     * peut être à modifier
     * @param Patient $pat
     *      Patient concerné
     * @param Medecin $med
     *      Médecin traitant
     * @return boolean
     *      Vrai si l'opération réussit
     */
    public function setMedecinTraitant(Patient $pat, Medecin $med)
    {
        if ($this->getId($pat)) {
            $rqt = "UPDATE $this->table SET id_medecin = :id_medecin WHERE id_patient = :id_patient";
            $prerqt = $this->conn->prepare($rqt);
            $medecinDAO = new MedecinDAO($this->conn);
            return $prerqt->execute(array(
                'id_patient' => $this->getId($pat),
                'id_medecin' => $medecinDAO->getId($med)
            ));
        }
        return false;
    }

    /**
     * Récupere un patient à partir de son id
     * @param $id
     * @return bool|mixed|Patient
     */
    public function getById($id)
    {
        if ($data = parent::getById($id)) {
            $pat = new Patient();
            $pat->setId($data['id_patient']);
            $pat->setNom($data['nom']);
            $pat->setPrenom($data['prenom']);
            $pat->setCivilite($data['civilite']);
            $pat->setAdresse($data['adresse']);
            $pat->setDateNaissance($data['date_naissance']);
            $pat->setNumSecu($data['num_secu']);
            $pat->setIdMedecin($data['id_medecin']);
            return $pat;
        }
        return false;
    }

    /**
     * On doit Override la fonction de GenericDAO parceque id_medecin
     * peut être nul, donc l'opérateur = ne fonctionne pas
     * @param Personne $ent
     *      Personne dont on cherche l'id
     * @return mixed
     *      id du patient si trouvé, faut sinon
     */
    public function getId(Personne $ent)
    {
        $rqt = "SELECT id_patient FROM $this->table WHERE nom = :nom AND prenom = :prenom AND civilite = :civilite
                AND date_naissance = :date_naissance AND adresse = :adresse AND num_secu = :num_secu AND (id_medecin = :id_medecin OR id_medecin IS NULL)";
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute($ent->getFields());
        if ($prerqt->rowCount() == 1)
            return $prerqt->fetch()['id_patient'];
        return false;
    }


    /**
     * Recherche un patient dans la base de données à partir
     * de mots clés
     * @param $keywords
     * @return array|bool
     */
    public function search($keywords)
    {
        $pat = new Patient();
        $params = array();
        $rqt = "SELECT * FROM $this->table WHERE ";
        for ($i = 0; $i < sizeof($keywords); $i++) {
            foreach ($pat->getFields() as $field => $val) {
                $rqt .= 'LOWER(' . ($field) . ') LIKE :p' . $i . ' OR ';
                // Preparer le tableau d'execution
                $params[':p' . $i] = '%' . $keywords[$i] . '%';
            }
            $rqt = substr($rqt, 0, -3);
            $rqt .= 'AND ';
        }
        // Enlever le AND à la fin de la requête
        $rqt = substr($rqt, 0, -4);
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute($params);
        if ($prerqt->rowCount() > 0) {
            $pats = array();
            while ($data = $prerqt->fetch()) {
                $pat = new Patient();
                $pat->setId($data['id_patient']);
                $pat->setNom($data['nom']);
                $pat->setPrenom($data['prenom']);
                $pat->setCivilite($data['civilite']);
                $pat->setAdresse($data['adresse']);
                $pat->setDateNaissance($data['date_naissance']);
                array_push($pats, $pat);
            }
            return $pats;
        } else {
            return false;
        }
    }
}
