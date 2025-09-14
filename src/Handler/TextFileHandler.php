<?php


namespace Armin\PulseLogger\Handler;

class TextFileHandler extends FileHandler
{
    
    public function __construct(?string $basePath = null)
    {
        parent::__construct($basePath);
    }
    public function writeText(mixed $data)
    {
        $this->write('app.log', $data);
    }
}
