<?php

namespace Armin\PulseLogger\Formatter;

use Armin\PulseLogger\Handler\JsonFileHandler;

class JsonFormatter extends Formatter
{


    private ?JsonFileHandler $json = null;

    public function __construct(?string $path = null)
    {
        $this->json = new JsonFileHandler($path);
    }
    public function log(string $level, string $message)
    {
        $format = $this->format($level, $message);
        $this->json->writeJson($format);
    }
}
