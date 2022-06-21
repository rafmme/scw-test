<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Lib\App;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;
use App\Controllers\ProductController;
use App\Model\Product;
use App\Database\MySQLConnection;


Router::get('/', function (Request $req, Response $res, $twig) {
    $stmt = MySQLConnection::getConnection()->query('SELECT sku from Products');

    while($row = $stmt->fetch()) {
        echo $row['sku'] . "\n";
    }
    // ProductController::indexAction($twig);
});

App::run();

?>



