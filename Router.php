<?php

class Router
{
    private $url;
    // Liste des routes valides
    private $routes;

    /**
     * Router constructor.
     * @param $url
     *      url a laquelle l'utilisateur tente d'accéder
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->routes = array("GET" => array(), "POST" => array());
    }

    /**
     * Definit un comportement du type:
     * quand j'accède a tel chemin,
     * lancer telle fonction avec le methode get
     * @param $path
     *      chemin auquel on accede
     * @param $func
     *      fonction à lancer
     */
    public function get($path, $func)
    {
        // Creer une route
        $route = new Route($path, $func);
        // L'ajouter à la liste des routes valides
        // avec la méthode get
        array_push($this->routes["GET"], $route);
    }

    /**
     * @see get
     * Idem avec la methode post
     */
    public function post($path, $func)
    {
        $route = new Route($path, $func);
        array_push($this->routes["POST"], $route);
    }

    /**
     * Effectue le routage
     * @throws Exception
     */
    public function run()
    {
        // Même traitement pour post et get
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url))
                return $route->call();
        }
        throw new Exception("Cette route n'existe pas");
    }
}