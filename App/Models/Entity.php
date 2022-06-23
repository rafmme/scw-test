<?php
    namespace App\Models;

    use App\Lib\Util;
    use App\Lib\DotEnv;
    use App\Database\MySQLConnection;

abstract class Entity
{
    public static $db;
    public static $tableName;

    public static function setDB()
    {
        (new DotEnv('.env'))->load();
        self::$db = (new MySQLConnection())->getConnection();
        self::$tableName =  \getenv('TABLE_NAME');
    }

    public static function destroy($sku)
    {
        self::setDB();
        $tableName = self::$tableName;
        $sql = "DELETE FROM $tableName WHERE sku = :sku";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['sku' => $sku]);
        $deleted = $stmt->rowCount();
        return $deleted;
    }

    public static function findAll()
    {
        self::setDB();
        $tableName = self::$tableName;
        $stmt = self::$db->query("SELECT * from $tableName ORDER BY id ASC");
        $products = $stmt->fetchAll();
        $result = [];

        foreach ($products as $product) {
            array_push($result, Util::removeNullValues($product));
        }
        return $result;
    }

    public static function findOne($sku)
    {
        self::setDB();
        $tableName = self::$tableName;
        $sql = "SELECT * FROM $tableName WHERE sku = :sku";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['sku' => $sku]);
        $product = $stmt->fetch();
        return Util::removeNullValues($product);
    }

    abstract public function setSku($sku);

    abstract public function setName($name);

    abstract public function setPrice($price);

    abstract public function setSize($size);
    
    abstract public function getSize();

    abstract public function setWeight($weight);
    
    abstract public function getWeight();

    abstract public function setHeight($height);
    
    abstract public function setWidth($width);
    
    abstract public function setLength($length);
    
    abstract public function getHeight();
    
    abstract public function getWidth();
    
    abstract public function getLength();

    abstract public function getSku();

    abstract public function getName();

    abstract public function getPrice();

    abstract public function save();
}
