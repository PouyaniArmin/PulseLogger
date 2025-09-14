<?php

namespace Armin\PulseLogger\Handler;

class JsonFileHandler extends FileHandler
{

    public function __construct(?string $basePath=null)
    {
        parent::__construct($basePath);
    }
    public function writeJson(mixed $data)
    {
        $json=json_encode($data,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->write('json.log',$json."\n");
    }
}