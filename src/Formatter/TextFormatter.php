<?php

namespace Armin\PulseLogger\Formatter;

use Armin\PulseLogger\Handler\FileHandler;
use Armin\PulseLogger\Handler\TextFileHandler;

/**
 * Formatter class for logging messages in plain text format.
 * Extends the base Formatter class.
 */
class TextFormatter extends Formatter
{
    /**
     * Handler responsible for writing text logs to file.
     */
    private ?TextFileHandler $text = null;

    /**
     * Constructor.
     * Initializes the Text file handler with an optional path.
     *
     * @param string|null $path Optional path for log storage.
     */
    public function __construct(?string $path = null)
    {
        $this->text = new TextFileHandler($path);
    }

    /**
     * Log a message at a given level in plain text format.
     *
     * @param string $level Log level (info, error, etc.)
     * @param string $message Log message
     */
    public function log(string $level, string $message)
    {
        // Format the log entry using the base Formatter
        $format = $this->format($level, $message);

        // Convert associative array to a readable string
        $str = implode("\n", array_map(fn($k, $v) => "$k: $v", array_keys($format), $format));

        // Add a separator line for readability between log entries
        $str .= "\n--------------------------------------------------\n";

        // Write the formatted text entry to the log file
        $this->text->writeText($str);
    }
}
