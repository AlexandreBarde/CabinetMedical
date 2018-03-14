<?php

class Patient extends Personne
{

    private $adresse;
    private $date_naissance;
    private $num_secu;
    private $id_medecin;


    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    public function getFormattedDateNaissance()
    {
        return (new DateTime($this->getDateNaissance()))->format('d/m/Y');
    }

    public function setDateNaissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;
    }

    public function getNumSecu()
    {
        return $this->num_secu;
    }

    public function setNumSecu($num_secu)
    {
        $this->num_secu = $num_secu;
    }

    public function getIdMedecin()
    {
        return $this->id_medecin;
    }

    public function setIdMedecin($id_medecin)
    {
        $this->id_medecin = $id_medecin;
    }

    public function getAge()
    {
        $now = new DateTime(date('d-m-Y'));
        $naiss = new DateTime($this->getDateNaissance());
        $age = $now->diff($naiss);
        return $age->format('%Y');
    }

    /**
     * Donne une liste des champs de l'entite
     * @return array
     *      nom des champs de l'entite
     */
    public
    function getFields()
    {
        return array(
            'id_medecin' => $this->getIdMedecin(),
            'civilite' => $this->getCivilite(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'adresse' => $this->getAdresse(),
            'date_naissance' => $this->getDateNaissance(),
            'num_secu' => $this->getNumSecu()
        );
    }
}

