<?php

    namespace App\Models;

    use App\Models\Entity;
    use App\Lib\Util;
    use App\Lib\DotEnv;
    use App\Database\MySQLConnection;

class Product extends Entity
{
    private $sku;
    private $name;
    private $price;
    private $size;
    private $weight;
    private $height;
    private $width;
    private $length;

    public function setSku($sku = '')
    {
        $this->sku = $sku !== '' || $sku !== null ? $sku : Util::generateSku($this->getName());
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function save()
    {
        parent::setDB();
        $tableName = parent::$tableName;

        $sql = "INSERT INTO $tableName (sku, name, price, weight, size, height, length, width) 
                VALUES (:sku, :name, :price, :weight, :size, :height, :length, :width)";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':sku', $this->getSku());
        $stmt->bindParam(':name', $this->getName());
        $stmt->bindParam(':price', $this->getPrice());
        $stmt->bindParam(':weight', $this->getWeight());
        $stmt->bindParam(':size', $this->getSize());
        $stmt->bindParam(':height', $this->getHeight());
        $stmt->bindParam(':length', $this->getLength());
        $stmt->bindParam(':width', $this->getWidth());

        if ($stmt->execute()) {
            $products = [
                'sku' => $this->getSku(),
                'name' => $this->getName(),
                'price' => $this->getPrice(),
                'weight' => $this->getWeight(),
                'size' => $this->getSize(),
                'height' => $this->getHeight(),
                'length' => $this->getLength(),
                'width' => $this->getWidth(),
            ];

            return [
                'message' => 'New product was successfully added!',
                'product' => Util::removeNullValues($products)
            ];
        }

        return ['error' => "Unable to add new product!"];
    }
}
