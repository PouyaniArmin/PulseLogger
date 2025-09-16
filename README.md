# PulseLogger

PulseLogger is a lightweight and easy-to-use PHP logging library.  
It supports **text and JSON logging**, provides detailed log metadata, and follows the **Singleton pattern** for consistent logging across your application.

## Features

| Feature | Description |
|---------|-------------|
| Singleton Logger | Consistent logging across the application. Calling `getInstance()` always returns the same logger instance. |
| TextFormatter & JsonFormatter | Supports both text and JSON output. |
| Configurable Log Path | The log path must be initialized once using `init()` before logging. Once set, it is used globally across your application, no need to re-initialize in controllers or classes. |
| Detailed Metadata | Timestamp, Level, Message, File, Class, Function, Request ID, Client IP. |
| JSON Lines | Each JSON entry is a single object, easy for programmatic processing. |
| Text Separator | Adds a separator line for readability in text logs. |

## Installation

PulseLogger can be installed via Composer in your project:

```bash
composer require pouyaniarmin/pulse-logger
```
## Usage / Examples

### Basic Setup

```php
<?php
require_once "./vendor/autoload.php";

use Armin\PulseLogger\PulseLogger;

// Initialize logger with mandatory log path (once)
$logger = PulseLogger::getInstance();
$logger->init(__DIR__ . '/logs');

// Log an informational message in text format
$logger->info('text', 'Application started successfully.');

// Log an error message in JSON format
$logger->error('json', 'Failed to connect to the database.');

```
### Example in a Class
```php
<?php

class UserService
{
    public function fetchUserData(int $userId)
    {
        $logger = PulseLogger::getInstance();

        $logger->info('text', "Fetching user data for user ID: $userId");

        $url = "https://api.example.com/users/$userId";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            // Logger path already initialized in bootstrap, no need to init again
            $logger->error('json', "Error fetching user data: " . curl_error($ch));
        } else {
            $logger->info('text', "User data fetched successfully for user ID: $userId");
        }

        curl_close($ch);
        return $response;
    }
}

// Usage example
$service = new UserService();
$userData = $service->fetchUserData(42);
echo $userData;


```

## Log Files / Output

PulseLogger creates log files in your specified log directory.  

- **Text logs:** `logs/app.log`  
  - Each entry is formatted as key:value pairs  
  - A separator line (`--------------------------------------------------`) is added between entries for readability  

- **JSON logs:** `logs/json.log`  
  - Each entry is a JSON object on a separate line (JSON Lines format)  
  - Useful for processing logs programmatically or with tools like ELK stack
## Contributing

Contributions to PulseLogger are welcome!  

- Feel free to **open issues** if you find bugs or have feature requests.  
- You can **submit pull requests** to improve the library or add new features.  
- Please follow **PSR-12 coding standards** for PHP code.  
- Make sure to **write clear commit messages** for your changes.
## License

PulseLogger is licensed under the **MIT License**.  

You are free to use, modify, and distribute this software, as long as you include the original license notice.
