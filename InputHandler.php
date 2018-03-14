<?php

class InputHandler
{
    /**
     * Retourne un parametre de get par son nom
     * apres l'avoir banalise
     * @param $param
     *      nom du parametre a recuperer
     * @return string
     *      parametre banalise
     * @throws Exception
     *      si le parametre n'existe pas
     */
    public static function get($param)
    {
        if (!isset($_GET[$param]))
            throw new Exception("Le paramètre $param n\'existe pas");
        // Enlever les espaces, les majuscules et les caractere speciaux
        return (trim(htmlspecialchars(strtolower($_GET[$param]))));
    }

    /**
     * Retourne un parametre de post par son nom
     * apres l'avoir banalise
     * @param $param
     *      nom du parametre a recuperer
     * @return string
     *      parametre banalise
     * @throws Exception
     *      si le parametre n'existe pas
     */
    public static function post($param)
    {
        if (!isset($_POST[$param])) {
            throw new Exception("Le paramètre $param n\'existe pas");
        }
        // Enlever les espaces, les majuscules et les caractere speciaux
        return (trim(htmlspecialchars(strtolower($_POST[$param]))));
    }

    /**
     * Vérifie si un formulaire de champs donnés est valide
     * @param array $fields
     * @return bool
     */
    public static function isValid(array $fields)
    {
        $valid = true;
        // Pour chaque champ
        foreach ($fields as $field) {
            // Permet de faire des vérification spécifiques pour les champs classique: telephone, date de naissance...
            switch ($field) {
                case 'date_naissance':
                case 'date':
                    $valid = isset($_POST[$field]) && !empty($_POST[$field]) && self::isDate($_POST[$field]);
                    break;
                case 'num_secu':
                case 'id_patient':
                case 'id_medecin':
                case 'duree':
                    $valid = isset($_POST[$field]) && !empty($_POST[$field]) && is_numeric($_POST[$field]);
                    break;
                case 'heure_debut':
                    $valid = isset($_POST[$field]) && !empty($_POST[$field]) && self::isTime($_POST[$field]);
                    break;
                default:
                    // Tous les champs ne doivent pas être vides
                    $valid = isset($_POST[$field]) && !empty($_POST[$field]);
            }
            // Si le champ courant n'est pas valide arreter de parcourir le formulaire.
            if (!$valid)
                break;
        }
        return $valid;
    }


    /**
     * Vérifie si un string est une date au format jj/mm/aaaa
     * @param $str
     * @return bool
     */
    private static function isDate($str)
    {
        return (DateTime::createFromFormat('d/m/Y', $str) != false);
    }

    /**
     * Vérifie si un string est une heure au format hh/mm
     * @param $str
     * @return bool
     */
    private static function isTime($str)
    {
        return (DateTime::createFromFormat('H:i', $str) != false);
    }
}

