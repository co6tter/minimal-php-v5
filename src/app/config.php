<?php

require_once(__DIR__ . '/../vendor/autoload.php');

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host    = $_ENV['DB_HOST'] ?? 'localhost';
$port    = $_ENV['DB_PORT'] ?? 3306;
$dbname  = $_ENV['DB_NAME'] ?? 'test';
$user    = $_ENV['DB_USER'] ?? 'root';
$pass    = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

define('DSN', $dsn);
define('DB_USER', $user);
define('DB_PASSWORD', $pass);
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

spl_autoload_register(function ($class) {
    $prefix = 'MyApp\\';

    if (strpos($class, $prefix) === 0) {
        $fileName = sprintf(__DIR__ . '/%s.php', substr($class, strlen($prefix)));
        if (file_exists($fileName)) {
            require($fileName);
        } else {
            echo 'File not found: ' . $fileName . PHP_EOL;
            exit;
        }
    }
});
