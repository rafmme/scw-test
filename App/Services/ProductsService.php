<?php

    namespace App\Services;

    use App\Services\IService;
    use App\Models\Product;

class ProductsService implements IService
{
    public static function create($data)
    {
        $product = new Product();
        $product->setName($data->name);
        $product->setSku(strtoupper($data->sku));
        $product->setPrice($data->price);
        $product->setWeight($data->weight);
        $product->setSize($data->size);
        $product->setHeight($data->height);
        $product->setLength($data->length);
        $product->setWidth($data->width);

        $sku = $product->getSku();
        $productExist = self::fetchOne($sku);

        if ($productExist) {
            return ['error' => "There is a product already with the SKU of $sku"];
        }

        return $product->save();
    }

    public static function fetchAll()
    {
        return Product::findAll();
    }

    public static function fetchOne($sku)
    {
        return Product::findOne($sku);
    }

    public static function remove($sku)
    {
        return  Product::destroy($sku);
    }
}
