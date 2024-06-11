<?php
function getDbConnection(){
    $lines = file(__DIR__ . '\..\..\.env');
    foreach ($lines as $line) {
        $line = trim($line);
        [$key, $value] = explode('=', $line);
        $$key = $value;
    }

    try {
        $conn = new PDO("mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}