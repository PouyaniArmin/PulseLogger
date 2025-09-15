<?php

namespace Armin\PulseLogger;

use Armin\PulseLogger\Formatter\Formatter;
use Armin\PulseLogger\Formatter\JsonFormatter;
use Armin\PulseLogger\Formatter\TextFormatter;
use Armin\PulseLogger\Handler\FileHandler;
use Armin\PulseLogger\Handler\TextFileHandler;
use Exception;

/**
 * Singleton Logger class to manage logging in different formats (Text/JSON).
 */
class PulseLogger
{
    /**
     * Singleton instance
     */
    private static ?PulseLogger $pulseLogger = null;

    /**
     * Reusable TextFormatter instance
     */
    private ?TextFormatter $text_formatter = null;

    /**
     * Reusable JsonFormatter instance
     */
    private ?JsonFormatter $json_formatter = null;

    /**
     * Optional path for log storage
     */
    private ?string $logPath = null;

    /**
     * Private constructor to enforce singleton pattern
     */
    private function __construct() {}

    /**
     * Prevent unserialization of singleton
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton class PulseLogger.");
    }

    /**
     * Prevent cloning of singleton
     */
    private function __clone()
    {
        throw new Exception("Cannot clone singleton class PulseLogger");
    }

    /**
     * Get the singleton instance of PulseLogger
     *
     * @return PulseLogger
     */
    public static function getInstance()
    {
        if (self::$pulseLogger !== null) {
            return self::$pulseLogger;
        }
        return self::$pulseLogger = new PulseLogger();
    }
    /**
     * Initialize the logger with a mandatory log path.
     * 
     * @param string $path Absolute or relative path where logs should be stored.
     * @throws Exception if the provided path is empty.
     */

    public function init(string $path)
    {
        if (!$path) {
            throw new Exception("Log path cannot be empty. Call init() with a valid path.");
        }
        $this->logPath = rtrim($path, '/');
    }

    /**
     * Log an info-level message
     *
     * @param string $type Formatter type ('text' or 'json')
     * @param string $message Log message
     */
    public function info(string $type, string $message)
    {
        $this->log($type, 'info', $message);
    }

    /**
     * Log an error-level message
     *
     * @param string $type Formatter type ('text' or 'json')
     * @param string $message Log message
     */
    public function error(string $type, string $message)
    {
        $this->log($type, 'Error', $message);
    }

    /**
     * General log method that selects the correct formatter
     *
     * @param string $type Formatter type
     * @param string $level Log level
     * @param string $message Log message
     */
    public function log($type, string $level, $message)
    {
        $this->ensureInit();
        switch (strtolower(trim($type))) {
            case 'json':
                // Lazily instantiate JsonFormatter if not already created
                if (!$this->json_formatter) $this->json_formatter = new JsonFormatter($this->logPath);
                $this->json_formatter->log($level, $message);
                break;
            case 'text':
                // Lazily instantiate TextFormatter if not already created
                if (!$this->text_formatter) $this->text_formatter = new TextFormatter($this->logPath);
                $this->text_formatter->log($level, $message);
                break;
            default:
                // Default to TextFormatter
                if (!$this->text_formatter) $this->text_formatter = new TextFormatter($this->logPath);
                $this->text_formatter->log($level, $message);
                break;
        }
    }

    /**
     * Ensure that the logger has been initialized with a valid log path.
     * 
     * @throws Exception if init() was not called before logging.
     */
    private function ensureInit()
    {
        if (!$this->logPath) {
            throw new Exception("Logger not initialized. Call init() with a valid path first.");
        }
    }
}
