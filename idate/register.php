<?php

include './settings.php';

if (isset($_POST['email'])) {
    $error = '';
    if ($_POST['firstName'] == '') {
        $error .= 'First Name<br />';
    }
    if ($_POST['lastName'] == '') {
        $error .= 'Last Name<br />';
    }
    if ($_POST['email'] == '') {
        $error .= 'Email<br />';
    }
    if ($_POST['password'] == '') {
        $error .= 'Password<br />';
    }
    
    if ($error != '') {
        header("Location: ./register.php?error=$error");
        die();
    }
    
    $statement = $pdo->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (:f, :l, :e, :p)");
    $statement->bindValue(':f',$_POST['firstName'],PDO::PARAM_STR);
    $statement->bindValue(':l',$_POST['lastName'],PDO::PARAM_STR);
    $statement->bindValue(':e',$_POST['email'],PDO::PARAM_STR);
    $statement->bindValue(':p',$_POST['password'],PDO::PARAM_STR);
    $success = $statement->execute();
    
    $to = './index.php';
    if ($success) {
        $_SESSION['userID'] = $pdo->lastInsertId();
    } else {
        $to = './register.php?v=1';
    }
    
    header('Location: $to');
    die();
}

$title = 'Register';

$body = <<<HTML
    <h2>Register</h2>
    <form action="./submit.php" method="post">
        <p><label for="firstName">First Name</label></p>
        <p><input type="text" name="firstName" id="firstName" /></p>
        <p><label for="lastName">Last Name</label></p>
        <p><input type="text" name="lastName" id="lastName" /></p>
        <p><label for="email">Email Address</label></p>
        <p><input type="email" name="email" id="email" /></p>
        <p><label for="password">Password</label></p>
        <p><input type="password" name="password" id="password" /></p>
        <p><input type="submit" value="Register" style="padding: 3px; background: #DDD; border: 1px solid #AAA; color: #777; width: 200px;" /></p>
    </form>
HTML;


include 'template.php';


?>