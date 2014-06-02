<?php

session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ./login.php");
    die();
}

?>
<h1>Welcome</h1>