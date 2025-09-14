<?php

namespace Armin\PulseLogger\Formatter;

use Armin\PulseLogger\Handler\FileHandler;
use Armin\PulseLogger\Handler\TextFileHandler;

class TextFormatter extends Formatter
{
    private ?TextFileHandler $text = null;

    public function __construct(?string $path = null)
    {
        $this->text = new TextFileHandler($path);
    }
    public function log(string $level, string $message)
    {
        $format = $this->format($level, $message);
        $str = implode("\n", array_map(fn($k, $v) => "$k:$v", array_keys($format), $format));
        $str.="\n--------------------------------------------------\n";
        $this->text->writeText($str);
    }
}
