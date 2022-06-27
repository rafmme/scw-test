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
            $dbUrl = parse_url($_ENV['DATABASE_URL']);
            $host =  $dbUrl['host'];
            $port =  $dbUrl['port'];
            $db =  substr($dbUrl['path'], 1);
            $user =  $dbUrl['user'];
            $password = $dbUrl['pass'];
            $driver =  $_ENV['DB_DRIVER'];
            $dsn = "$driver:host=$host;port=$port;dbname=$db;";

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
