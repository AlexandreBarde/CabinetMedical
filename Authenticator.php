<?php

class Authenticator
{

    private $conn;

    public function __construct()
    {
        $this->conn = DBConnection::getInstance();
    }

    /**
     * Tente d'authentifier un utilisateur
     * @param $user
     * @param $password
     * @return boolean | array
     */
    public function login($user, $password)
    {
        $prerqt = $this->conn->prepare("SELECT * FROM Utilisateurs WHERE login = :login");
        $prerqt->execute(array('login' => $user));
        $infos = $prerqt->fetch();
        // Si le nom d'utilisateur existe bien, comparer le mot de passe stocké et celui entré
        if ($infos) {
            return $infos['password'] == sha1($password);
        } else {
            return false;
        }

    }

}