<?php

class Medecin extends Personne
{

    /**
     * Donne une liste des champs de l'entite
     * @return array
     *      nom des champs de l'entite
     */
    public function getFields()
    {
        return array(
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'civilite' => $this->getCivilite()
        );
    }
}