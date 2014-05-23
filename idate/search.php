<?php

require 'settings.php';
$title = 'Search';



//Get Dates
$statement = $pdo->prepare("SELECT firstName, lastName, dateId, title, cost FROM dates LEFT JOIN users ON users.userID = dates.userID");
//$statement->bindValue(':book',$_GET['book'],PDO::PARAM_STR);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$results = '';
foreach($rows as $row) {
    $results .= "<a href=\"./view.php?id=$row[dateId]\" style=\"color: inherit; text-decoration: none;\"><div style=\"padding: 40px; float: left; min-width: 150px;\"><h3>$row[title]</h3><p>Cost: \$$row[cost]</p><p>Submitted by $row[firstName] $row[lastName]</p><p style=\"font-size: 12px;\">Click to read more.</p></div></a>";
}



$body = <<<HTML
    <h2>Search Dates</h2>
    $results
HTML;


include 'template.php';

?>