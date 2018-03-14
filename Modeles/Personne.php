<?php

abstract class Personne
{
    private $id;
    protected $nom;
    protected $prenom;
    protected $civilite;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return ucfirst($this->nom);
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return ucfirst($this->prenom);
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getCivilite()
    {
        return ucfirst($this->civilite);
    }

    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    }

    /**
     * Donne tous les champs d'une entité
     * @return array
     *      Tableau du nom des champs
     */
    public abstract function getFields();
}