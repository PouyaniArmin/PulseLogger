<?php

namespace Armin\PulseLogger\Formatter;

abstract class Formatter
{
    private string $format = "
    Timestamp: %s
    Level: %s
    Message: %s
    File: %s
    Class: %s
    Function: %s
    RequestID: %s
    ClientIP: %s\n";
    private function internalClasses(): array
    {
        return [
            'Armin\PulseLogger\PulseLogger',
            'Armin\PulseLogger\Formatter\TextFormatter',
            'Armin\PulseLogger\Formatter\JsonFormatter',
            'Armin\PulseLogger\Formatter\Formatter'
        ];
    }
    private function findRealCaller($debug_backtrace)
    {
        $data = [];
        foreach ($debug_backtrace as $frame) {
            if (isset($frame['class']) && !in_array($frame['class'], $this->internalClasses())) {
                $data = [
                    'file' => $frame['file'] ?? '-',
                    'class' => $frame['class'] ?? '-',
                    'function' => $frame['function'] ?? '-'
                ];
            }
        }
        return $data;
    }
    public function format(string $level, string $message): array
    {
        $backTrack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $caller = $this->findRealCaller($backTrack);

        return [
            'timestamp' => date('c'),
            'level' => $level,
            'message' => $message,
            'file' => $caller['file'],
            'class' => $caller['class'],
            'function' => $caller['function'],
            'request_id' => $_SERVER['HTTP_X_REQUEST_ID'] ?? 'N/A',
            'client_ip' => $_SERVER['REMOTE_ADDR'] ?? 'N/A',
        ];
    }
    abstract public function log(string $level, string $message);
}
