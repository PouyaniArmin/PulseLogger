<?php

namespace Armin\PulseLogger;

use Armin\PulseLogger\Formatter\Formatter;
use Armin\PulseLogger\Formatter\JsonFormatter;
use Armin\PulseLogger\Formatter\TextFormatter;
use Armin\PulseLogger\Handler\FileHandler;
use Armin\PulseLogger\Handler\TextFileHandler;
use Exception;

class PulseLogger
{
    private static ?PulseLogger $pulseLogger = null;
    private ?TextFormatter $text_formatter = null;
    private ?JsonFormatter $json_formatter = null;
    private ?string $logPath = null;
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
    public function setLogPath(string $path)
    {
        $this->logPath = $path;
    }
    public function info(string $type, string $message)
    {
        $this->log($type, 'info', $message);
    }
    public function error(string $type, string $message)
    {
        $this->log($type, 'Error', $message);
    }
    public function log($type, string $level, $message)
    {

        switch (strtolower(trim($type))) {
            case 'json':
                if (!$this->json_formatter) $this->json_formatter = new JsonFormatter($this->logPath);
                $this->json_formatter->log($level, $message);
                break;
            case 'text':
                if (!$this->text_formatter) $this->text_formatter = new TextFormatter($this->logPath);
                $this->text_formatter->log($level, $message);
                break;
            default:
                if (!$this->text_formatter) $this->text_formatter = new TextFormatter($this->logPath);
                $this->text_formatter->log($level, $message);
                break;
        }
    }
}
