<?php

namespace App\Lib;

class Util
{
    public static function generateSku(string $product_name): string
    {
        return strtoupper(\substr($product_name, 0, 4) . uniqid());
    }

    public static function removeNullValues($products_array)
    {
        if (is_array($products_array)) {
            $result = [];
            foreach ($products_array as $key => $value) {
                if ($value !== null) {
                    $result["$key"] = $value;
                }
            }
            return $result;
        }
        return $products_array;
    }
}
