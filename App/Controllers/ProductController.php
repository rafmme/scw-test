<?php

namespace App\Controllers;

class ProductController
{   
    public static function indexAction($twig)
    {
        echo $twig->render('index.html');
    }
}
