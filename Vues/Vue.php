<?php

class Vue
{

    private $template = null;
    private $title;
    private $jumbotron;

    public function __construct($template)
    {
        $this->template = 'vue' . $template . '.php';
    }

    /**
     * Genere la vue demandée
     * @param array $data
     *      Données à passer à la vue, par défaut, on ne passe pas de données
     */
    public function generate(array $data=array())
    {
        $contenu = $this->render($this->template, $data);
        $vue = $this->render('template.php', array(
            'titre' => $this->title,
            'contenu' => $contenu,
            'jumbotron' => $this->jumbotron
        ));
        echo $vue;
    }


    /**
     * Prepare la vue avec les données appropriées
     * @param $template
     *      Vue a rendre
     * @param array $data
     *      Données à passer
     * @return string
     *      HTML de la vue
     */
    private function render($template, array $data)
    {
        extract($data);
        ob_start();
        include($template);
        return ob_get_clean();
    }

}