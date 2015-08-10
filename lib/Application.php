<?php

namespace SE;

class Application
{
    private static $app = null;
    public static function getInstance()
    {
        if (!self::$app){
            self::$app = new \Silex\Application();
            return self::$app;
        }
        return self::$app;
    }
}