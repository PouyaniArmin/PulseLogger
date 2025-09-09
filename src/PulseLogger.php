<?php

namespace Armin\PulseLogger;

use Armin\PulseLogger\Formatter\Formatter;
use Armin\PulseLogger\Formatter\JsonFormatter;
use Armin\PulseLogger\Formatter\TextFormatter;
use Armin\PulseLogger\Handler\FileHandler;
use Exception;

class PulseLogger
{
    private static ?PulseLogger $pulseLogger = null;
    private function __construct() {}
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton class PulseLogger.");
    }
    private function __clone()
    {
        throw new Exception("Cannot clone singleton class PulseLogger");
    }
    public static function getInstance()
    {
        if (self::$pulseLogger !== null) {
            return self::$pulseLogger;
        }
        return self::$pulseLogger = new PulseLogger();
    }
    public function info(string $type, string $message)
    {
        $this->log($type, 'info', $message);
    }
    public function error(string $type, string $message)
    {
        $this->log($type, 'Erorr', $message);
    }
    public function log($type, string $level, $message)
    {
        if ($type === 'Text') {
            $text=new TextFormatter;
            $text->log($level,$message);
        }
        if ($type==='Json') {
           $json=new JsonFormatter;
           $json->log($level,$message);
        }
    }
}
