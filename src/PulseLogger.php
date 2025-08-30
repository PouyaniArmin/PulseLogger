<?php

namespace Armin\PulseLogger;

use Exception;

class PulseLogger{
    private static ?PulseLogger $pluseLogger=null;
    private function __construct()
    {
        
    }
    private function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton class PulseLogger.");
    }
    private function __clone()
    {
        throw new Exception("Cannot clone singleton class PulseLogger");
    }
    public static function getInstance(){
        if (self::$pluseLogger!==null) {
            return self::$pluseLogger;
        }
        return self::$pluseLogger=new PulseLogger();
    }
}