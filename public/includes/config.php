<?php
require_once __DIR__ . '\..\vendor\autoload.php';
function getDbConnection(){
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "\..\..");
    $dotenv->load();

    $DB_HOST = $_ENV['DB_HOST'];
    $DB_USER = $_ENV['DB_USER'];
    $DB_PASS = $_ENV['DB_PASS'];
    $DB_NAME = $_ENV['DB_NAME'];

    try {
        $conn = new PDO("mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}

function verifyToken($id, $token){
    $sql = "SELECT name, email, mobile_number, dob, town_or_city, country FROM users WHERE user_id=:id AND token=:token";

    $conn = getDbConnection();
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        return ['success' => true, 'data' => $results[0]];
    } else {
        return ['success' => false, 'data' => []];
    }
}