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
    if ($_POST['password'] != $_POST['password2'] || strlen($_POST['password']) < 7 || !preg_match('/\d/', $_POST['password'])) {
        header("Location: ./signup.php?e=1");
        die();
    }
    
    //Hash password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    //Attempt to insert information into the database
    $statement = $pdo->prepare("INSERT INTO userdemo (username, password) VALUES (:u, :p)");
    $statement->bindValue(':u',$_POST['username'],PDO::PARAM_STR);
    $statement->bindValue(':p',$password,PDO::PARAM_STR);
    $success = $statement->execute();
    
    //Redirect
    header("Location: ./index.php");
    die();
}


$error = (isset($_GET['e'])) ? '<h2>Password is invalid</h2>' : '';

?>
<!DOCTYPE html>
    <html>
<head>
    <title>Sign Up</title>
    <script>
        function validate() {
            var p1 = document.getElementById("p1").value;
            var p2 = document.getElementById("p2").value;
            
            if (p1 != p2) {
                alert("Passwords do not match!");
                return false;
            }
            
            if (p1.length < 7) {
                alert("Password is too short");
                return false;
            }
            
            if (p1.search(/[0-9]/) == -1) {
                alert("Password must have a number!");
                return false;
            }
            
            return true;
            
        }
    </script>
</head>
<body>
    <form action="./signup.php" method="post" onsubmit="return validate();">
        <? echo $error; ?>
        <p>Username</p>
        <p><input type="text" name="username" /></p>
        <p>Password</p>
        <p><input type="password" name="password" id="p1" /></p>
        <p>Retype Password</p>
        <p><input type="password" name="password2" id="p2" /></p>
        <p><input type="submit" value="GO!" /></p>
    </form>
</body>
    </html>