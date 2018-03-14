<?php

class ControleurMedecin extends Controleur
{
    public function __construct()
    {
        $this->DAO = new MedecinDAO(DBConnection::getInstance());
    }

    /**
     * Affiche les détails d'un médecin
     * @param $id
     *      id du medecin
     */
    public function afficher($id)
    {
        // Verifier que le medecin existe
        if ($this->DAO->exists_id($id)) {
            // Recuperer le medecin
            $medecin = $this->DAO->getById($id);
            // Choisir l'icone en fontion de la civilité
            if ($medecin->getCivilite() == "Monsieur")
                $icone = "/images/doctor.svg";
            else
                $icone = "/images/doctor-femme.svg";
            // Afficher la vue
            $this->vue = new Vue('AfficherMedecin');
            $this->vue->generate(array(
                'medecin' => $medecin,
                'icone' => $icone
            ));
        } else {
            $this->vue = new Vue('Erreur');
            $this->vue->generate(array(
                'titre_erreur' => 'Erreur medecin non trouve',
                'message' => 'Désolé, ce médecin n\'existe pas',
                'chemin' => '/medecins',
                'bouton' => 'Retour à la liste des médecins'
            ));
        }
    }

    /**
     * Supprime le medecin dont l'id à été passé en POST
     */
    public function supprimer()
    {
        try {
            $id = InputHandler::post('id_medecin');
            // Si le medecin n'existe pas, lever une exception pour
            // se rendre directement dans le catch et afficher la page d'erreur
            if ($this->DAO->delete($id)) {
                // Renvoyer à la liste des medecins
                header('location: /medecins');
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            $this->vue = new Vue('Erreur');
            $this->vue->generate(array(
                'titre_erreur' => 'medecin inconnu',
                'message' => 'Impossible de supprimer ce médecin',
                'bouton' => 'Retour à la liste des médecins',
                'chemin' => '/medecins'
            ));
        }
    }

    /**
     * Affiche la page de modification d'un medecin
     * @param $id
     *      id du medecin à modifier
     */
    public function afficher_page_modif($id)
    {
        $medecin = $this->DAO->getById($id);
        $this->vue = new Vue('ModifierMedecin');
        $this->vue->generate(array(
            'medecin' => $medecin
        ));
    }

    /**
     * Modifie le médecin dont l'id à été passé en post
     */
    public function modifier()
    {
        try {
            // Recuperer l'id du medecin à modifier
            $id = InputHandler::post('id_medecin');
            // Créer un nouveau mededin à partir du formulaire
            $nouveau_medecin = new Medecin();
            $nouveau_medecin->setNom(InputHandler::post('nom'));
            $nouveau_medecin->setPrenom(InputHandler::post('prenom'));
            $nouveau_medecin->setCivilite(InputHandler::post('civilite'));
            // Mettre a jour le medecin dans la BDD
            $this->DAO->update($id, $nouveau_medecin);
            // Renvoyer à la liste des medecins
            header('location: ./medecins');
        } catch (Exception $e) {
            $this->vue = new Vue('Erreur');
            $this->vue->generate();
        }
    }

    public function ajouterMedecin()
    {
        if (InputHandler::isValid(array('civilite', 'nom', 'prenom'))) {
            try {
                // Cree un objet medecin
                $medecin = new Medecin();
                // Lui attribuer les valeurs des champs
                $medecin->setCivilite(InputHandler::post('civilite'));
                $medecin->setNom(InputHandler::post('nom'));
                $medecin->setPrenom(InputHandler::post('prenom'));
                // L'inserer dans la base de donnee
                if ($this->DAO->insert($medecin)) {
                    header('location: /');
                } else {
                    $this->afficherErreur();
                }
            } catch (Exception $e) {
                $this->afficher404();
            }
        } else {
            $this->formulaireInvalide('/ajout-medecin');
        }
    }

    /**
     * Recherche un médecin dans la liste
     */
    public function recherche()
    {
        try {
            $this->vue = new Vue('AfficherMedecins');
            // Les termes de la recherche sont séparés par des espaces
            $mot_cles = explode(' ', InputHandler::get('recherche'));
            if ($liste_medecin = $this->DAO->search($mot_cles)) {
                $this->vue->generate(array(
                    'listeMedecins' => $liste_medecin
                ));
            } else {
                $this->vue->generate(array(
                    'listeMedecins' => array()
                ));
            }
        } catch (Exception $e) {
            $this->afficher404();
        }
    }

    public function afficherTousMedecins()
    {
        $this->vue = new Vue('AfficherMedecins');
        if ($liste_medecins = $this->DAO->getAll()) {
            $this->vue->generate(array('listeMedecins' => $liste_medecins));
        } else {
            // Gerer le cas ou la liste est vide:
            $this->vue->generate(array('listeMedecins' => array()));
        }
    }
}