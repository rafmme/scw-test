<?php

namespace App\Database;

use PDO;
use App\Database\IDBConnection;

class MySQLConnection implements IDBConnection
{
    private $dbConnection;

    public function __construct()
    {
        try {
            $host =  $_ENV['DB_HOST'];
            $port =  $_ENV['DB_PORT'];
            $db =  $_ENV['DB_NAME'];
            $user =  $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];
            $dsn = "mysql:host=$host;port=$port;dbname=$db;";

            $this->dbConnection = new PDO(
                $dsn,
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
