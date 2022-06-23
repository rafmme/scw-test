<?php 

namespace App\Models;

use App\Models\Product;

class Book extends Product
{
    private $weight;

    public function __construct() {
        parent::__construct();
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function save() {
        self::setDB();
        $tableName = self::$tableName;
        $sku = $this->sku;
        $name = $this->name;
        $price = $this->price;
        $weight = $this->weight;

        $sql = "INSERT INTO $tableName (sku, name, price, weight) VALUES ($sku, $name, $price, $weight)";
        $stmt = self::$db->query($sql);
        $created = $stmt->fetch();
        return $created;
    }
}





