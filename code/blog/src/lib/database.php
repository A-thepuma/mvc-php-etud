<?php
namespace App\Lib;

use PDO;
use Exception;

class DatabaseConnection
{
    private $pdo;

    public function getConnection()
    {
        if ($this->pdo !== null) {
            return $this->pdo;
        }

        try {
            // UwAmp par défaut → MySQL sur 127.0.0.1:3307, user root, pas de mot de passe
            $host = 'localhost';
            $port = 3306;
            $dbname = 'blog';
            $user = 'root';
            $pass = 'root';

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname";

            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Forcer un charset lisible pour UwAmp
            $this->pdo->exec("SET NAMES utf8 COLLATE utf8_general_ci");

            return $this->pdo;

        } catch (Exception $e) {
            die("Erreur de connexion MySQL : " . $e->getMessage());
        }
    }
}
