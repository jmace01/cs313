<?php

require 'settings.php';



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

$body = <<<HTML
    <h2>$row[title]</h2>
    <h3>Description</h3>
    $description
    <p><br /><br /></p>
    <p><b>Cost:</b> \$$row[cost]</p>
    <p><b>Located in:</b> $row[location]</p>
    <p><b>Date Type:</b> $row[type]</p>
    <p><b>Submitted by:</b> $row[firstName] $row[lastName]</p>
    
    $comments
HTML;


include 'template.php';

?>