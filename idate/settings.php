<?php

/**
 * Get Session Data Ready
 */
session_start();


/**
 * Connect to the Database
 */

//Open Shift Credentials
$host = getEnv("OPENSHIFT_MYSQL_DB_HOST");
$port = ':'.getEnv("OPENSHIFT_MYSQL_DB_PORT");
$user = getEnv("OPENSHIFT_MYSQL_DB_USERNAME");
$pass = getEnv("OPENSHIFT_MYSQL_DB_PASSWORD");

//Offline credentials
if ($host == '') {
    $host = 'localhost';
    $port = '';
    $user = 'root';
    $pass = 'root';
}

//Open the connection
try {
    $pdo = new PDO("mysql:host=$host$port;dbname=php", $user, $pass);
} catch (PDOException $e) {
    die('Could Not Connect!');
}



?>