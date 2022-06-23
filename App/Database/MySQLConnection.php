<?php

namespace App\Database;

use PDO;
use App\Database\IDBConnection;
use App\Lib\DotEnv;

class MySQLConnection implements IDBConnection
{
    private $dbConnection;

    public function __construct()
    {
        try {
            (new DotEnv('.env'))->load();

            $host =  \getenv('DB_HOST');
            $port =  \getenv('DB_PORT');
            $db =  \getenv('DB_NAME');
            $user =  \getenv('DB_USER');
            $password = \getenv('DB_PASSWORD');
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
