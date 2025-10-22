<?php
// src/lib/database.php

class DatabaseConnection
{

    public $pdo = null;

    public $host = '127.0.0.1';
    public $port = '3307';
    public $dbname = 'blog';
    public $user = 'root';
    public $password = 'root';
    public $charset = 'utf8';

    public function getConnection()
    {
        if ($this->pdo === null) {
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;

            try {
                $this->pdo = new PDO(
                    $dsn,
                    $this->user,
                    $this->password,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        // Force l'encodage côté client (évite le warning charset 255)
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $this->charset
                    )
                );

                // Fallbacks pour vieux clients libmysql sous Windows
                $this->pdo->exec("SET NAMES " . $this->charset);
                $this->pdo->exec("SET CHARACTER SET " . $this->charset);
                $this->pdo->exec("SET collation_connection = utf8_general_ci");

            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        return $this->pdo;
    }
}
