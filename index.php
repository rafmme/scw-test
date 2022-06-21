<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Lib\App;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;
use App\Controllers\ProductController;
use App\Model\Product;


Router::get('/', function (Request $req, Response $res, $twig) {
    ProductController::indexAction($twig);
});

App::run();
