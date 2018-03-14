<?php

class Consultation
{
    private $id_medecin;
    private $id_patient;
    private $date_debut;
    private $date_fin;
    private $medecin;
    private $patient;

    /**
     * @return mixed
     */
    public function getIdMedecin()
    {
        return $this->id_medecin;
    }

    /**
     * @param mixed $id_medecin
     */
    public function setIdMedecin($id_medecin)
    {
        $this->id_medecin = $id_medecin;
    }

    /**
     * Calcule la date de fin d'une consultation à partir de
     * sa date de début et de sa durée en minutes
     * @param $duree
     */
    public function dateFinFromDuree($duree)
    {
        $deb = new DateTime($this->date_debut);
        $deb->add(new DateInterval('PT' . $duree . 'M'));
        $this->setDateFin($deb->format('Y-m-d H:i:s'));
    }

    /**
     * @return mixed
     */
    public function getIdPatient()
    {
        return $this->id_patient;
    }

    /**
     * @param mixed $id_patient
     */
    public function setIdPatient($id_patient)
    {
        $this->id_patient = $id_patient;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * @param mixed $date_debut
     */
    public function setDateDebut($date_debut)
    {
        $this->date_debut = $date_debut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * @param mixed $date_fin
     */
    public function setDateFin($date_fin)
    {
        $this->date_fin = $date_fin;
    }

    /**
     * Retourne tous les champs avec leurs noms et leur valeurs
     * sous la forme d'un tableau associatif
     * @return array
     */
    public function getFields()
    {
        return array(
            'id_patient' => $this->getIdPatient(),
            'id_medecin' => $this->getIdMedecin(),
            'date_debut' => $this->getDateDebut(),
            'date_fin' => $this->getDateFin()
        );
    }

    /**
     * @return mixed
     */
    public function getMedecin()
    {
        return $this->medecin;
    }

    /**
     * @param $medecin
     */
    public function setMedecin($medecin)
    {
        $this->medecin = $medecin;
    }

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param $patient
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
    }

    /**
     * Retourne la date de début au format jj/mm/aaaaa
     * @return string
     */
    public function getDate()
    {
        $dt = new DateTime($this->getDateDebut());
        return $dt->format('d/m/Y');
    }

    /**
     * Retourne l'heure du début au format hh:mm
     * @return string
     */
    public function getHeureDebut()
    {
        $dt = new DateTime($this->getDateDebut());
        return $dt->format('H:i');
    }

    /**
     * Retourne l'heure de fin au format hh:mm
     * @return string
     */
    public function getHeureFin()
    {
        $dt = new DateTime($this->getDateFin());
        return $dt->format('H:i');
    }

    public function getDuree()
    {
        $deb = new DateTime($this->getHeureDebut());
        $fin = new DateTime($this->getHeureFin());
        $inter = $deb->diff($fin);
        return $inter->format('%i');
    }


}
