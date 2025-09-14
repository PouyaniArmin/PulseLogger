<?php


namespace Armin\PulseLogger\Handler;


/**
 * Handler class for writing logs in plain text format.
 * Extends the base FileHandler.
 */
class TextFileHandler extends FileHandler
{
    /**
     * Constructor.
     * Initializes the Text file handler with an optional base path.
     *
     * @param string|null $basePath Optional base path for text logs
     */
    public function __construct(?string $basePath = null)
    {
        parent::__construct($basePath);
    }

    /**
     * Write a log entry in plain text format to the file.
     *
     * @param mixed $data Log data as a formatted string
     */
    public function writeText(mixed $data)
    {
        // Write the formatted text entry to 'app.log'
        $this->write('app.log', $data);
    }
}
