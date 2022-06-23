<?php
    namespace App\Controllers;

    use App\Lib\Request;
    use App\Lib\Response;

interface IController
{
    public static function indexAction($twig);
    public static function fetchOne(Request $req, Response $res);
    public static function fetchAll(Request $req, Response $res);
    public static function create(Request $req, Response $res);
    public static function delete(Request $req, Response $res);
}
