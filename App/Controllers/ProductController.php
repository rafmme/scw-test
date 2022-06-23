<?php

namespace App\Controllers;

use App\Controllers\IController;
use App\Services\ProductsService;
use App\Lib\Request;
use App\Lib\Response;

class ProductController implements IController
{

    public static function indexAction($twig)
    {
        echo $twig->render('index.html');
    }

    public static function fetchAll(Request $req, Response $res)
    {
        $products_list = ProductsService::fetchAll();
        return $res->toJSON(['message' => 'All available products', 'products' => $products_list]);
    }

    public static function fetchOne(Request $req, Response $res)
    {
        $sku = $req->params[0];
        $product = ProductsService::fetchOne($sku);

        if (!$product) {
            return $res->status(404)->toJSON(['error' => "No product matches the SKU of $sku"]);
        }
        return $res->toJSON([
            'message' => "Product with the SKU of $sku was fetched successfully!",
            'product' => $product
        ]);
    }

    public static function create(Request $req, Response $res)
    {
        $data = $req->getJSON();
        $product =  ProductsService::create($data);
        return $res->toJSON($product);
    }

    public static function delete(Request $req, Response $res)
    {
        $sku = $req->params[0];
        $product = ProductsService::fetchOne($sku);

        if (!$product) {
            return $res->status(404)->toJSON(['error' => "No product matches the SKU of $sku"]);
        }

        $deleted = ProductsService::remove($sku);
        return $res->status(204)->toJSON(['message' => "Product with the SKU of $sku has been deleted!"]);
    }
}
