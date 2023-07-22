<?php

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$createUsersSql = "CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(256) PRIMARY KEY,
    name VARCHAR(256) NOT NULL,
    username VARCHAR(256) NOT NULL
);";

$createTweetsSql = "CREATE TABLE IF NOT EXISTS tweets (
    id VARCHAR(256) PRIMARY KEY,
    text VARCHAR(256) NOT NULL,
    author VARCHAR(256) NOT NULL,
    FOREIGN KEY (author) REFERENCES users(id) ON DELETE CASCADE
);";


$dbName = $_ENV["DB_DATABASE"];
$dbPassword = $_ENV["DB_PASSWORD"];
$dbHost = $_ENV["DB_HOST"];
$dbUsername = $_ENV["DB_USERNAME"];

$pdo = new PDO(
    "mysql:dbname=$dbName;host=$dbHost",
    $dbUsername,
    $dbPassword
);

($pdo->prepare($createUsersSql))->execute();
($pdo->prepare($createTweetsSql))->execute();
