<?php

namespace Armin\PulseLogger\Formatter;

use Armin\PulseLogger\Handler\JsonFileHandler;
/**
 * Formatter class for logging messages in JSON format.
 * Extends the base Formatter class.
 */
class JsonFormatter extends Formatter
{
    /**
     * Handler responsible for writing JSON logs to file.
     */
    private ?JsonFileHandler $json = null;

    /**
     * Constructor.
     * Initializes the JSON file handler with an optional path.
     *
     * @param string|null $path Optional path for log storage.
     */
    public function __construct(?string $path = null)
    {
        $this->json = new JsonFileHandler($path);
    }

    /**
     * Log a message at a given level in JSON format.
     *
     * @param string $level Log level (info, error, etc.)
     * @param string $message Log message
     */
    public function log(string $level, string $message)
    {
        // Format the log entry using the base Formatter
        $format = $this->format($level, $message);
        // Write the formatted entry to the JSON log file
        $this->json->writeJson($format);
    }
}
