<?php

namespace Armin\PulseLogger\Formatter;

use Armin\PulseLogger\Handler\TextFileHandler;

class TextFormatter extends Formatter
{
    public function log(string $level, string $message)
    {
        $format = $this->format($level, $message);
        $str=implode("\n",array_map(fn($k,$v)=> "$k:$v",array_keys($format),$format));
        // error_log("Handler called at " . date('c'));
        new TextFileHandler($str);
    }
}
