<?php

abstract class GenericDAO
{
    protected $table;
    protected $conn;

    protected function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Donne le nom de la clé primaire de l'entité
     * @return string
     *      Nom de la clé
     */
    public abstract function getPrimaryKey();

    /**
     * Insere une entite dans la base de données
     * @param Personne $ent
     *      Entite à insérer
     * @return boolean
     *      Vrai si l'insertion a réussi
     */
    public function insert(Personne $ent)
    {
        if ($this->getId($ent) == false) {
            $rqt = "INSERT INTO $this->table(";
            foreach (array_keys($ent->getFields()) as $field) {
                $rqt .= "$field, ";
            }
            $rqt = trim($rqt, ', ');
            $rqt .= ") VALUES(";
            foreach (array_keys($ent->getFields()) as $field) {
                $rqt .= ":$field, ";
            }
            $rqt = trim($rqt, ', ');
            $rqt .= ')';
            $prerqt = $this->conn->prepare($rqt);
            return $prerqt->execute($ent->getFields());
        }
        return false;
    }

    /**
     * Verifie si une entite existe deja à partir de son id
     * @param $id
     *      id de l'entite à verifier
     * @return boolean
     *      Vrai si l'entite existe
     */
    public function exists_id($id)
    {
        $rqt = 'SELECT ' . $this->getPrimaryKey() . " FROM $this->table WHERE " . $this->getPrimaryKey() . ' = :id';
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute(array('id' => $id));
        return $prerqt->rowCount() > 0;
    }

    /**
     * Supprime une entite de la base de données
     * @param $id
     *      id de l'entite
     * @return boolean
     *      Vrai si la suppression a réussi
     */
    public function delete($id)
    {
        if ($this->exists_id($id)) {
            $rqt = "DELETE FROM  $this->table WHERE " . $this->getPrimaryKey() . ' = :id';
            $prerqt = $this->conn->prepare($rqt);
            $prerqt->execute(array('id' => $id));
            return !$this->exists_id($id);
        }
        return false;
    }

    /**
     * Donne toutes les entites
     * @return array
     *      Tableau de toutes les entités.
     */
    public function getAll()
    {
        return $this->conn->query("SELECT * FROM $this->table ORDER BY nom")->fetchAll();
    }

    /**
     * Recupere l'id d'une entite
     * @param Personne $ent
     *      Entite dont on veut recuperer l'id
     * @return mixed
     *      l'id si trouve, faux sinon
     *
     */
    public function getId(Personne $ent)
    {
        $rqt = 'SELECT ' . $this->getPrimaryKey() . " FROM $this->table WHERE ";
        foreach (array_keys($ent->getFields()) as $field) {
            $rqt .= " $field = :$field AND";
        }
        // Enlever le AND en trop
        $rqt = substr($rqt, 0, -3);
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute($ent->getFields());
        if ($prerqt->rowCount() > 0) {
            return $prerqt->fetch()[$this->getPrimaryKey()];
        } else
            return false;
    }

    /**
     * Met à jour une entite dans la base de données
     * @param Personne $nouveau
     *      Entite contenant les nouvelles informations
     * @param $id
     *      id de l'entite a modifier
     * @return boolean
     *      Vrai si la mise à jour à réussi
     */
    public function update($id, Personne $nouveau)
    {
        if ($this->exists_id($id)) {
            $rqt = "UPDATE $this->table SET";
            foreach (array_keys($nouveau->getFields()) as $field) {
                $rqt .= " $field = :$field,";
            }
            $rqt = trim($rqt, ',');
            $rqt .= ' WHERE ' . $this->getPrimaryKey() . ' = :id';
            $prerqt = $this->conn->prepare($rqt);
            return $prerqt->execute(array_merge($nouveau->getFields(), array('id' => $id)));
        }
        return false;
    }

    /**
     * Donne les informations d'une personne en fonction de son id
     * @param $id
     * @return bool|mixed
     *      Faux en cas d'echec
     */
    public function getById($id)
    {
        $rqt = "SELECT * FROM $this->table WHERE " . $this->getPrimaryKey() . ' = :id';
        $prerqt = $this->conn->prepare($rqt);
        $prerqt->execute(array('id' => $id));
        if ($prerqt->rowCount() == 1) {
            return $prerqt->fetch();
        }
        return false;
    }
}
