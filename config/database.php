<?php

class Database {
    private $host = 'localhost';
    private $db_name = "elections";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Configuration pour PHP 5.6
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);

        } catch (PDOException $e) {
            error_log("Erreur de connexion : " . $e->getMessage());
            throw new Exception("La connexion à la base de données a échoué. Veuillez vérifier vos paramètres de connexion.");
        }

        return $this->conn;
    }
}
