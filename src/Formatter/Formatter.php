<?php

namespace Armin\PulseLogger\Formatter;

/**
 * Abstract base class for all Formatter types.
 * Defines common formatting logic for log entries.
 */
abstract class Formatter
{
    /**
     * Default log format template.
     * This template is used to structure log information.
     */
    private string $format = "
    Timestamp: %s
    Level: %s
    Message: %s
    File: %s
    Class: %s
    Function: %s
    RequestID: %s
    ClientIP: %s\n";

    /**
     * Returns the list of internal classes to ignore when detecting the real caller.
     */
    private function internalClasses(): array
    {
        return [
            'Armin\PulseLogger\PulseLogger',
            'Armin\PulseLogger\Formatter\TextFormatter',
            'Armin\PulseLogger\Formatter\JsonFormatter',
            'Armin\PulseLogger\Formatter\Formatter'
        ];
    }

    /**
     * Find the actual caller outside of internal Formatter/Logger classes.
     * @param array $debug_backtrace The debug backtrace to analyze.
     * @return array Associative array containing 'file', 'class', 'function' keys.
     */
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

    /**
     * Format a log entry into an associative array with standard fields.
     * @param string $level Log level (e.g., info, error).
     * @param string $message The log message.
     * @return array Formatted log entry as associative array.
     */
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

    /**
     * Abstract method to log a message at a given level.
     * Must be implemented by child Formatter classes.
     * @param string $level Log level
     * @param string $message Log message
     */
    abstract public function log(string $level, string $message);
}
