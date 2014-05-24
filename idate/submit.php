<?php

include './settings.php';

if (!isset($_SESSION['userID'])) {
    header("Location: ./login.php?ref=./submit.php");
}


$title = 'Submit Date';

$body = <<<HTML
    <h2>Submit a Date</h2>
    <form action="./submit.php" method="post">
        <p><label for="title">Date Title</label></p>
        <p><input type="text" name="title" id="title" /></p>
        <p><label for="type">Type of Date</label><p>
        <p>
            <select name="type" id="type">
                <option>Couple</option>
                <option>Group</option>
            </select>
        </p>
        <p><label for="category">Category</label><p>
        <p>
            <select name="category" id="category">
                <option>dinner</option>
                <option>movie</option>
                <option>Outdoor</option>
            </select>
        </p>
        <p><label for="cost">Cost of the Date</label></p>
        <p>$ <input type="text" name="cost" id="cost" value="0.00" style="width: 70px;" /></p>
        <p><label for="description">Describe the date</label></p>
        <p><textarea name="description" id="description"></textarea></p>
        <p><input type="submit" value="Submit Date" style="padding: 3px; background: #DDD; border: 1px solid #AAA; color: #777; width: 200px;" /></p>
    </form>
HTML;


include 'template.php';


?>