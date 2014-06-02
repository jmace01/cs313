<?php

require './password.php';

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


$pdo->query("CREATE TABLE IF NOT EXISTS userdemo
    ( id SERIAL
    , username VARCHAR(40)
    , password VARCHAR(70)
    )
");


if (isset($_POST['username'])) {
    //Hash password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    //Attempt to insert information into the database
    $statement = $pdo->prepare("INSERT INTO userdemo (username, password) VALUES (:u, :p)");
    $statement->bindValue(':u',$_POST['username'],PDO::PARAM_STR);
    $statement->bindValue(':p',$password,PDO::PARAM_STR);
    $success = $statement->execute();
    
    //Redirect
    header("Location: ./index.php");
}



?>
<!DOCTYPE html>
    <html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <form action="./signup.php" method="post">
        <p>Username</p>
        <p><input type="text" name="username" /></p>
        <p>Password</p>
        <p><input type="password" name="password" /></p>
        <p><input type="submit" value="GO!" /></p>
    </form>
</body>
    </html>