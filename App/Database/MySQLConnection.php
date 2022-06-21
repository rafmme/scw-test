<?php

namespace App\Database;

use PDO;
use App\Database\DBConnectionInterface;
use App\Lib\DotEnv;

class MySQLConnection implements DBConnectionInterface {
    private static $dbConnection;

    public static function getConnection() {
        try {
        
            (new DotEnv('.env'))->load();

            $host =  \getenv('DB_HOST');
            $port =  \getenv('DB_PORT');
            $db =  \getenv('DB_NAME');
            $user =  \getenv('DB_USER');
            $password = \getenv('DB_PASSWORD');
            $dsn = "mysql:host=$host;port=$port;dbname=$db;";

            if (!isset(self::$dbConnection)) {
                self::$dbConnection = new PDO(
                    $dsn,
                    $user,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            }

            return self::$dbConnection;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

?>


