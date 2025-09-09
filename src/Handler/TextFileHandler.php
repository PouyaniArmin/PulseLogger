<?php


namespace Armin\PulseLogger\Handler;

class TextFileHandler
{
    public function __construct(mixed $data)
    {

        $path = dirname(__DIR__, 2) . '/logs';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $separator="\n------------------------------------------\n";
        file_put_contents($path . '/app.log', rtrim($data).$separator,FILE_APPEND);
    }
}
