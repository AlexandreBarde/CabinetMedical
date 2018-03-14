<?php

class Route
{
    private $path;
    private $func;
    private $matches;

    public function __construct($path, $func)
    {
        $this->func = $func;
        $this->path = trim($path, '/');
    }

    /**
     * Verifie qu'une url corresponde à
     * une route
     * @param $url
     *      url à vérifier
     * @return boolean
     *      correspondance de l'url
     */
    public function match($url)
    {
        // Enlever les / au début et à la fin de l'url
        $url = trim($url, '/');
        // Remplacer la partie significative de l'url par une regex
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        // Créer l'expression de l'url complete
        $regex = '#^' . $path . '$#';
        // Verifier que l'url corresponde à l'expression regulière
        // enregistre la correspondance dans le tableau matches
        if (!preg_match($regex, $url, $matches))
            return false;
        // Supprimer le 1er élément du tableau
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    /**
     * Appelle la fonction correspondant au chemin
     * avec les paramètres trouvés
     */
    public function call()
    {
        return call_user_func_array($this->func, $this->matches);
    }
}