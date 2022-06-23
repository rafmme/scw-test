<?php 

namespace App\Models;

use App\Models\Product;

class Dvd extends Product
{
    private $size;

    public function __construct() {
        parent::__construct();
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function save() {}
}




