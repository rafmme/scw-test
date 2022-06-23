<?php

namespace App\Controllers;

use App\Controllers\iController;
use App\Services\ProductsService;
use App\Lib\Request;
use App\Lib\Response;

class ProductController implements iController
{   
    public static function indexAction($twig)
    {
        echo $twig->render('index.html');
    }

    public static function fetchAll(Request $req, Response $res) {
        $products_list = ProductsService::fetchAll();
        return $res->toJSON($products_list);
    }

    public static function fetchOne(Request $req, Response $res) {
        $sku = $req->params[0];
        $product = ProductsService::fetchOne($sku);

        if (!$product) {
            return $res->status(404)->toJSON(['error' => "No product matches the SKU of $sku"]);
        }
        return $res->toJSON($product);
    }

    public static function create(Request $req, Response $res) {
        $res->toJSON(['create' => 'creation']);
    }

    public static function delete(Request $req, Response $res) {
        $sku = $req->params[0];
        $product = ProductsService::fetchOne($sku);

        if (!$product) {
            return $res->status(404)->toJSON(['error' => "No product matches the SKU of $sku"]);
        }

        $deleted = ProductsService::remove($sku);
        return $res->status(204)->toJSON(['message' => "Product with the SKU of $sku has been deleted!"]);
    }
}



