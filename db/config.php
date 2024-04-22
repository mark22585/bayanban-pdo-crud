<?php
define('DB_SERVER', 'localhost');
define('DB_NAME', 'u593341949_db_bayanban');
define('DB_USERNAME', 'u593341949_dev_bayanban');
define('DB_PASSWORD', '20221800Bayanban');

try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>