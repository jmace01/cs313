<?php

include './settings.php';

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