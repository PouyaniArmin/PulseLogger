<?php

namespace Armin\PulseLogger\Handler;

class JsonFileHandler
{
    public function __construct(mixed $data)
    {
        $path = dirname(__DIR__,2) . '/logs';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($path . '/json.log', $json, FILE_APPEND);
    }
}
