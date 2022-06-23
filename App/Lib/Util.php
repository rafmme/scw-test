<?php

namespace App\Lib;

class Util
{
    public static function generate_sku(string $product_name): string
    {
        return strtoupper(\substr($product_name, 0, 4) . uniqid());
    }
}






