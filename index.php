<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Lib\App;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;
use App\Controllers\ProductController;
use App\Database\MySQLConnection;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

\header("Access-Control-Allow-Origin: *");
\header("Access-Control-Allow-Headers: *");
\header("Access-Control-Allow-Methods: GET, POST, DELETE");


Router::get('/', function (Request $req, Response $res, $twig) {
    return ProductController::indexAction($twig);
});

Router::get('/products', function (Request $req, Response $res) {
    return ProductController::fetchAll($req, $res);
});

Router::get('/products/([A-Z-_a-z0-9]*)', function (Request $req, Response $res) {
    return ProductController::fetchOne($req, $res);
});

Router::delete('/products/([A-Z-_a-z0-9]*)', function (Request $req, Response $res) {
    return ProductController::delete($req, $res);
});

Router::post('/products', function (Request $req, Response $res) {
    return ProductController::create($req, $res);
});

App::run();

?>

