<?php
    namespace App\Models;

    use App\Lib\Util;
    use App\Lib\DotEnv;
    use App\Database\MySQLConnection;

    abstract class Product{
        private $sku;
        private $name;
        private $price;
        private static $db;
        private static $tableName;

        public static function setDB() {
            (new DotEnv('.env'))->load();
            self::$db = (new MySQLConnection())->getConnection();
            self::$tableName =  \getenv('TABLE_NAME');
        }


        public function setSku($sku = null) {
            $this->sku =   isset($sku) ? $sku : Util::generate_sku($this->getName());
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function setPrice($price) {
            $this->price = $price;
        }

        public function getSku() {
            return $this->sku;
        }

        public function getName() {
            return $this->name;
        }

        public function getPrice() {
            return $this->price;
        }

        abstract public function save();

        public static function destroy($sku) {
            self::setDB();
            $tableName = self::$tableName;
            $sql = "DELETE FROM $tableName WHERE sku = :sku";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(['sku' => $sku]);
            $deleted = $stmt->rowCount();
            return $deleted;
        }

        public static function findAll() {
            self::setDB();
            $tableName = self::$tableName;
            $stmt = self::$db->query("SELECT * from $tableName ORDER BY id ASC");
            return ($stmt->fetchAll());
        }

        public static function findOne($sku) {
            self::setDB();
            $tableName = self::$tableName;
            $sql = "SELECT * FROM $tableName WHERE sku = :sku";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(['sku' => $sku]);
            $product = $stmt->fetch();
            return $product;
        }
    }





