<?php
namespace App\Lib;

use PDO;
use Exception;

class DatabaseConnection
{
    public function getConnection()
    {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: 3307;
        $dbname = getenv('DB_NAME') ?: 'blog';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

        try {
            $connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false,
            ]);

            return $connection;
        } catch (Exception $e) {
            throw new Exception("Impossible de se connecter à MySQL ({$host}:{$port}) — " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }
}