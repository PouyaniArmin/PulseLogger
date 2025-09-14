<?php 


namespace Armin\PulseLogger\Handler;
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
     * Initializes the base path for log storage. 
     * If no path is provided, defaults to 'logs' directory three levels up.
     *
     * @param string|null $basePath Optional base path for logs
     */
    public function __construct(?string $basePath = null)
    {
        if ($basePath) {
            $this->basePath = rtrim($basePath, '/');
        } else {
            $this->basePath = dirname(__DIR__, 3) . '/logs';
        }

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