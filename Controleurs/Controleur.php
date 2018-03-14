<?php

abstract class Controleur
{
    protected $DAO;
    protected $vue;

    protected function formulaireInvalide($chemin)
    {
        $this->vue = new Vue('Erreur');
        $this->vue->generate(array(
            'bouton' => 'Retour',
            'titre_erreur' => 'Mauvais formulaire',
            'message' => 'Ce formulaire est invalide',
            'chemin' => $chemin
        ));
    }

    /**
     * Créé un objet DateTime à partir
     * d'un string au format jj/mm/aaaa
     * @param $date
     * @return DateTime
     */
    protected function toDateTime($date)
    {
        $arr = explode('/', $date);
        return new DateTime($arr[0] . '-' . $arr[1] . '-' . $arr[2]);
    }

    public function afficher404()
    {
        header("HTTP/1.0 404 Not Found");
        $this->vue = new Vue('Erreur');
        $this->vue->generate(array(
            'titre_erreur' => 'Page non trouvée',
            'message' => 'Cette page n\'existe pas',
            'chemin' => '/',
            'bouton' => 'Retour à l\'accueil'
        ));
    }

    /**
     * Retire une personne d'un tableau
     * @param array $arr
     * @param Personne $personne
     */
    protected function delete_from_array(array &$arr, Personne $personne)
    {
        // Parcourir les medecins de la liste
        foreach ($arr as $key => $pers) {
            // Si l'id correspond
            if ($pers->getId() === $personne->getId()) {
                // Retirer le medecin de la liste grace a la clé
                unset($arr[$key]);
                // Pas besoin de continuer à parcourir la liste
                return;
            }
        }
    }
}
