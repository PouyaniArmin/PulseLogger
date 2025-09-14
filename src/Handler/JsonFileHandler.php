<?php

namespace Armin\PulseLogger\Handler;

/**
 * Handler class for writing logs in JSON format.
 * Extends the base FileHandler.
 */
class JsonFileHandler extends FileHandler
{
    /**
     * Constructor.
     * Initializes the JSON file handler with an optional base path.
     *
     * @param string|null $basePath Optional base path for JSON logs
     */
    public function __construct(?string $basePath = null)
    {
        parent::__construct($basePath);
    }

    /**
     * Write a log entry in JSON format to the file.
     * Each log entry is stored on a new line (JSON Lines format).
     *
     * @param mixed $data Log data as an associative array
     */
    public function writeJson(mixed $data)
    {
        // Encode data as JSON without escaping Unicode and with pretty print
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        // Append the JSON string to the log file
        $this->write('json.log', $json . "\n");
    }
}