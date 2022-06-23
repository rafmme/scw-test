<?php

    namespace App\Services;

    interface iService {
        public static function create($data);
        public static function fetchAll();
        public static function fetchOne($sku);
        public static function remove($sku);
    }


