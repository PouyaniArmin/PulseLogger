<?php

namespace Armin\PulseLogger\Formatter;

interface InterfaceFormatter{
    public function format(string $level,string $message):string;
}