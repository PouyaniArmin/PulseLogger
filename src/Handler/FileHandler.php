<?php


namespace Armin\PulseLogger\Handler;

use Exception;
use Throwable;

/**
 * Base class for all file handlers.
 * Provides common logic to write content to a file.
 */
class FileHandler
{
    /**
     * Base directory path where log files will be stored.
     */
    private string $basePath;
    /**
     * Constructor.
     * 
     * Initializes the base path for log storage. 
     * The base path is mandatory; if it is not provided, an exception is thrown.
     * Also ensures that the directory exists; if not, it attempts to create it.
     *
     * @param string|null $basePath Optional base path for logs (must be provided)
     * @throws Exception if $basePath is not provided
     */
    public function __construct(?string $basePath = null)
    {
        if (!$basePath) {
            throw new Exception("BasePath for logs must be provided. Logging aborted.");
        }
        $this->basePath = rtrim($basePath, '/');


        // Create the directory if it does not exist
        if (!is_dir($this->basePath)) {
            mkdir($this->basePath, 0777, true);
        }
    }

    /**
     * Write content to a file.
     * Appends the content if the file already exists.
     *
     * @param string $filename Name of the file
     * @param string $content Content to write
     */
    public function write(string $filename, string $content)
    {
        $filePath = $this->basePath . '/' . $filename;
        file_put_contents($filePath, $content, FILE_APPEND);
    }
}
