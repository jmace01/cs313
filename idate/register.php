<?php

include './settings.php';

if (isset($_POST['email'])) {
    //Make sure all values were entered
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
    
    //Short circuit if information is missing
    if ($error != '') {
        header("Location: ./register.php?error=$error");
        die();
    }
    
    //See if email already exists
    $statement = $pdo->prepare("SELECT userID FROM users WHERE email = :email");
    $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        header("Location: ./register.php?exists=1");
        die();
    }
    
    //Attempt to insert information into the database
    $statement = $pdo->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (:f, :l, :e, :p)");
    $statement->bindValue(':f',$_POST['firstName'],PDO::PARAM_STR);
    $statement->bindValue(':l',$_POST['lastName'],PDO::PARAM_STR);
    $statement->bindValue(':e',$_POST['email'],PDO::PARAM_STR);
    $statement->bindValue(':p',$_POST['password'],PDO::PARAM_STR);
    $success = $statement->execute();
    
    //Log the user in and set the redirect
    $to = './registered.php';
    if ($success) {
        $_SESSION['userID'] = $pdo->lastInsertId();
    } else {
        $to = './register.php?v=1';
    }
    
    //Execute Redirect
    header("Location: $to");
    die();
}

//Page title
$title = 'Register';

//Error Messages
$errorMsg = '';
if (isset($_GET['error'])) $errorMsg = '<p><b>Please enter</b><br /><i>'.$_GET['error'].'</i></p>';
else if (isset($_GET['exists'])) $errorMsg = '<p><b>That email already exists.</b></p>';
else if (isset($_GET['v'])) $errorMsg = '<p><b>Information could not be entered.</b></p>';

//Page content
$body = <<<HTML
    <h2>Register</h2>
    $errorMsg
    <form action="./register.php" method="post">
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