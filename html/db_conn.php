<?php

require_once __DIR__ . "/vendor/autoload.php";

// Load .env from the parent directory (/var/www/.env)
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Read environment variables with fallbacks
$servername = $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? 'my_mysql_db';
$username   = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? 'tooling_user';
$password   = $_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? 'Passw0rd!';
$dbname     = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? 'toolingdb';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
