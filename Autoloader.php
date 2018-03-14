<?php

class Autoloader
{

    /**
     * Active un autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Require automatiquement les classes utilisee dans un fichier
     * @param $className
     * @return boolean
     *      Vrai si la classe a été trouvee
     */
    public static function autoload($className)
    {
        if (file_exists(__DIR__ . '/Modeles/' . $className . '.php')) {
            require(__DIR__ . '/Modeles/' . $className . '.php');
            return true;
        } else if (file_exists(__DIR__ . '/Vues/' . $className . '.php')) {
            require(__DIR__ . '/Vues/' . $className . '.php');
            return true;
        } else if (file_exists(__DIR__ . '/Controleurs/' . $className . '.php')) {
            require(__DIR__ . '/Controleurs/' . $className . '.php');
            return true;
        } else if (file_exists(__DIR__ . '/' . $className . '.php')) {
            require(__DIR__ . '/' . $className . '.php');
            return true;
        }
        return false;
    }
}