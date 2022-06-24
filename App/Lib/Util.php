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

    public static function validateInput($data)
    {
        $result = [];

        if (!$data->name) {
            $result['name'] = "Product Name field can't be empty!";
        }

        if (!$data->sku) {
            $result['sku'] = "Product SKU field can't be empty!";
        }

        if (!$data->price) {
            $result['price'] = "Product Price field can't be empty!";
        }

        if ($data->price && !\is_numeric($data->price)) {
            $result['price'] = "Product Price must be number";
        }

        if (($result['name']) || ($result['sku']) || ($result['price'])) {
            return $result;
        }

        return;
    }
}
