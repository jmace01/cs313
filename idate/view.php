<?php

require 'settings.php';


if (isset($_POST['comment'])) {
    //Check that all information was submitted
    $error = '';
    if ($_POST['title'] == '') {
        $error .= 'Title<br />';
    }
    else if ($_POST['comment'] == '') {
        $error .= 'Comment<br />';
    }
    
    //If information is missing, short circuit and redirect
    if ($error != '') {
        header("Location: ./view.php?id=$_GET[id]&error=$error");
        die();
    }
    
    //Insert the date into the database
    $statement = $pdo->prepare("INSERT INTO `comments` (userID, dateID, title, ccomment) VALUES (:uid, :did, :title, :comment)");
    $statement->bindValue(':uid',$_SESSION['userID'],PDO::PARAM_INT);
    $statement->bindValue(':did',$_GET['id'],PDO::PARAM_INT);
    $statement->bindValue(':title',$_POST['title'],PDO::PARAM_STR);
    $statement->bindValue(':comment',$_POST['comment'],PDO::PARAM_STR);
    $statement->execute();
    
    //Redirect the user
    header("Location: ./view.php?id=".$_GET['id']);
    die();
}


//Get Date information
$statement = $pdo->prepare("SELECT firstName, lastName, dateId, title, cost, type, description, location FROM dates LEFT JOIN users ON users.userID = dates.userID WHERE dateId = :date");
$statement->bindValue(':date',$_GET['id'],PDO::PARAM_STR);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);

$title = $row['title'];
$description = '<p>'.str_replace("\n",'</p><p>',$row['description']).'</p>';


$statement = $pdo->prepare("SELECT firstName, lastName, ccomment, title FROM comments LEFT JOIN users ON users.userId = comments.userId WHERE dateId = :date");
$statement->bindValue(':date',$_GET['id'],PDO::PARAM_STR);
$statement->execute();
$rows = $statement->fetchAll();


$comments = '';
foreach($rows as $crow) {
    $comments .= '<hr style="border: 0px; border-top: 1px dotted #AAA" /><p><b>'.$crow['title'].'</b></p><p>'.$crow['ccomment'].'</p><p>&mdash; '.$crow['firstName'].' '.$crow['lastName'].'</p>';
}

if ($comments != '') {
    $comments = '<h3 style="margin-top: 100px;">Comments</h3>'.$comments;
}

//If the user is logged in, show the comment form
$form = '';
if (isset($_SESSION['userID'])) {
    $form = <<<HTML
    <h3 style="margin-top: 100px;">Post a comment</h3>
    <form action="./view.php?id=$_GET[id]" method="post">
        <p><label for="title">Comment Title</label></p>
        <p><input type="text" name="title" id="title" /></p>
        <p><label for="comment">Comment</label></p>
        <p><textarea name="comment" id="comment"></textarea></p>
        <p><input type="submit" value="Post Comment" style="padding: 3px; background: #DDD; border: 1px solid #AAA; color: #777; width: 200px;" /></p>
    </form>
HTML;
}

$errorMsg = '';
if (isset($_GET['error'])) $errorMsg = '<p><b>Please enter</b><br /><i>'.$_GET['error'].'</i></p>';

$body = <<<HTML
    $errorMsg
    <h2>$row[title]</h2>
    <h3>Description</h3>
    $description
    <p><br /><br /></p>
    <p><b>Cost:</b> \$$row[cost]</p>
    <p><b>Located in:</b> $row[location]</p>
    <p><b>Date Type:</b> $row[type]</p>
    <p><b>Submitted by:</b> $row[firstName] $row[lastName]</p>
    
    $comments
    $form
HTML;


include 'template.php';

?>