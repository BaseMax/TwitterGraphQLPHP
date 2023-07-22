<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();




$schema = require dirname(__DIR__) . "/schema.php";

$schemaInstance = new Schema([
    "query" => $schema["query"],
    "mutation" => $schema["mutation"]
]);

try {
    $dbHost = $_ENV['DB_HOST'];
    $dbPort = $_ENV["DB_PORT"];
    $dbName = $_ENV["DB_DATABASE"];
    $dbUsername = $_ENV["DB_USERNAME"];
    $dbPassword = $_ENV["DB_PASSWORD"];

    
    $pdo = new PDO(
        "mysql:dbname=$dbName;host=$dbHost",
        $dbUsername,
        $dbPassword
    );


    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$request = $data["query"];
$rootValue = null;
$context = [
    "db" => $pdo
];
$variables = isset($data['variables']) ? $data['variables'] : null;


try {
    $result = GraphQL::executeQuery($schemaInstance, $request, $rootValue, $context, $variables);
    $output = $result->toArray();
} catch (Exception $e) {
    $output = [
        "error" => [
            "message" => $e->getMessage()
        ]
    ];
}

header("Content-Type: application/json");
echo json_encode($output);
