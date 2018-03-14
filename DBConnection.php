<?php

class DBConnection
{
    private static $host = 'localhost';
    private static $db = 'CabinetMedical';
    private static $user = 'root';
    private static $pass = '';
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new pdo('mysql:host=' . self::$host . ';dbname=' . self::$db, self::$user, self::$pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec('SET CHARACTER SET utf8');
            } catch (Exception $pdoe) {
                die('La BDD est KO ' . $pdoe->getMessage());
            }
        }
        return self::$instance;
    }
}
