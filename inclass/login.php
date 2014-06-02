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

if (isset($_POST['username'])) {
    //Get the password
    $statement = $pdo->prepare("SELECT username, password, id FROM userdemo WHERE username = :u");
    $statement->bindValue(':u',$_POST['username'],PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    
    //verify the password
    $valid = password_verify($_POST['password'], $row['password']);
    
    if ($valid) {
        $_SESSION['userID'] = $row['id'];
    }
    
    //Redirect
    header("Location: ./index.php");
    die();
}



?>
<!DOCTYPE html>
    <html>
<head>
    <title>Sign In</title>
</head>
<body>
    <h1>Log In</h1>
    <form action="./login.php" method="post">
        <p>Username</p>
        <p><input type="text" name="username" /></p>
        <p>Password</p>
        <p><input type="password" name="password" /></p>
        <p><input type="submit" value="GO!" /></p>
    </form>
</body>
    </html>