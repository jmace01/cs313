<?php

require 'settings.php';

/**
 * Handle Log In's
 */
if (isset($_POST['email'])) {
    $statement = $pdo->prepare("SELECT userID FROM users WHERE email = :email AND password = :password");
    $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $statement->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $_SESSION['userID'] = $row['userID'];
        $ref = isset($_GET['ref']) ? $_GET['ref'] : './index.php';
        header("Location: $ref");
    } else {
        header("Location: ./login.php?wrong=1");
    }
    die();
}

$title = 'Log In';
$ref = isset($_GET['ref']) ? '?ref='.$_GET['ref'] : '';

if (isset($_SESSION['userID'])) {
    $content = '<p>You are already logged in!</p>';
} else {
    $error = (isset($_GET['wrong'])) ? '<h3>Invalid Email/Password combination</h3>' : '';
    $content = <<<HTML
    $error
    <form action="login.php$ref" method="post">
        <p><label for="email">Email Address:</label></p>
        <p><input type="email" name="email" id="email" style="width: 200px;" /></p>
        <p><label for="password">Password:</label></p>
        <p><input type="password" name="password" id="password" style="width: 200px;" /></p>
        <p><input type="submit" value="Log In" style="padding: 3px; background: #DDD; border: 1px solid #AAA; color: #777; width: 200px;" /></p>
    </form>
HTML;
}

$body = <<<HTML
    <h2>Log In</h2>
    $content
HTML;


include 'template.php';

?>