<?php

include './settings.php';

if (!isset($_SESSION['userID'])) {
    header("Location: ./login.php?ref=./submit.php");
    die();
}

if (isset($_POST['title'])) {
    //Check that all information was submitted
    $error = '';
    if ($_POST['title'] == '') {
        $error .= 'Title<br />';
    }
    else if ($_POST['type'] == '') {
        $error .= 'Type<br />';
    }
    else if ($_POST['category'] == '') {
        $error .= 'Category<br />';
    }
    else if ($_POST['cost'] == '') {
        $error .= 'Cost<br />';
    }
    else if ($_POST['location'] == '') {
        $error .= 'Location<br />';
    }
    else if ($_POST['description'] == '') {
        $error .= 'Description<br />';
    }
    
    //If information is missing, short circuit and redirect
    if ($error != '') {
        header("Location: ./submit.php?error=$error");
        die();
    }
    
    //Insert the date into the database
    $statement = $pdo->prepare("INSERT INTO `dates` (userID, title, type, category, cost, location, description) VALUES (:uid, :title, :type, :category, :cost, :location, :description)");
    $statement->bindValue(':uid',$_SESSION['userID'],PDO::PARAM_INT);
    $statement->bindValue(':title',$_POST['title'],PDO::PARAM_STR);
    $statement->bindValue(':type',$_POST['type'],PDO::PARAM_STR);
    $statement->bindValue(':category',$_POST['category'],PDO::PARAM_STR);
    $statement->bindValue(':cost',$_POST['cost'],PDO::PARAM_STR);
    $statement->bindValue(':location',$_POST['location'],PDO::PARAM_STR);
    $statement->bindValue(':description',$_POST['description'],PDO::PARAM_STR);
    $statement->execute();
    
    //Redirect the user
    header("Location: ./search.php");
    die();
}


$title = 'Submit Date';

$errorMsg = '';
if (isset($_GET['error'])) $errorMsg = '<p><b>Please enter</b><br /><i>'.$_GET['error'].'</i></p>';

$body = <<<HTML
    <h2>Submit a Date</h2>
    $errorMsg
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
        <p><label for="location">Location</label></p>
        <p><input type="text" name="location" id="location" /></p>
        <p><label for="description">Describe the date</label></p>
        <p><textarea name="description" id="description"></textarea></p>
        <p><input type="submit" value="Submit Date" style="padding: 3px; background: #DDD; border: 1px solid #AAA; color: #777; width: 200px;" /></p>
    </form>
HTML;


include 'template.php';


?>