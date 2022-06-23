<?php

    namespace App\Services;

    use App\Services\iService;
    use App\Models\Product;


class ProductsService implements iService
{
    public static function create($data){

    }

    public static function fetchAll() {
        return Product::findAll();
    }

    public static function fetchOne($sku) {
        return Product::findOne($sku);
    }

    public static function remove($sku) {
        return  Product::destroy($sku);
    }
}





