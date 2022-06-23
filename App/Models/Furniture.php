<?php 

namespace App\Models;

use App\Models\Product;

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct() {
        parent::__construct();
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getLength() {
        return $this->length;
    }

    public function save() {}
}




