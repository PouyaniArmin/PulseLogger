<?php

 namespace Armin\PulseLogger\Formatter;

use Armin\PulseLogger\Handler\JsonFileHandler;

 class JsonFormatter extends Formatter{

    public function log(string $level, string $message)
    {
        $format = $this->format($level, $message);
        new JsonFileHandler($format);
    }
 }