<?php

require 'settings.php';
$title = 'Search';


//Get Search Criteria
$keywords = (isset($_GET['keywords']) && $_GET['keywords'] != '') ? 'AND title LIKE :keywords' : '';
$type     = (isset($_GET['type'])     && $_GET['type'] != '')     ? 'AND type = :type'         : '';
$category = (isset($_GET['category']) && $_GET['category'] != '') ? 'AND category = :category' : '';


//Get Dates
$statement = $pdo->prepare("SELECT firstName, lastName, dateId, title, cost FROM dates LEFT JOIN users ON users.userID = dates.userID WHERE users.userID = dates.userID $keywords $type $category");
if (isset($_GET['keywords']) && $_GET['keywords'] != '') $statement->bindValue(':keywords','%'.$_GET['keywords'].'%',PDO::PARAM_STR);
if (isset($_GET['type'])     && $_GET['type'] != '')     $statement->bindValue(':type',$_GET['type'],PDO::PARAM_STR);
if (isset($_GET['category']) && $_GET['category'] != '') $statement->bindValue(':category',$_GET['category'],PDO::PARAM_STR);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$results = '';
foreach($rows as $row) {
    $results .= "<a href=\"./view.php?id=$row[dateId]\" style=\"color: inherit; text-decoration: none;\"><div style=\"padding: 40px; padding-top: 0px; float: left; width: 230px;\"><h3>$row[title]</h3><p>Cost: \$$row[cost]</p><p>Submitted by $row[firstName] $row[lastName]</p><p style=\"font-size: 12px;\">Click to read more.</p></div></a>";
}

if ($results == '') {
    $results = '<h3 style="text-align: center; margin-top: 60px;">No results matched your search!<h3>';
}



$body = <<<HTML
    <h2>Search Dates</h2>
    <div style="float: left; width: 179px; border-top: 1px solid #DDD; border-right: 1px solid #DDD; padding: 10px; min-height: 500px;">
        <form action="./search.php" method="get">
            <p><label for="keywords">Key Words:</label></p>
            <p><input type="text" name="keywords" id="keywords" value="" /></p>
            <p><label for="type">Date Type:</label></p>
            <p>
                <select name="type" id="type">
                    <option></option>
                    <option>Couple</option>
                    <option>Group</option>
                </select>
            </p>
            <p><label for="category">Category:</label></p>
            <p>
                <select name="category" id="category">
                    <option></option>
                    <option>Dinner</option>
                    <option>Movie</option>
                    <option>Outdoors</option>
                </select>
            </p>
            <p><input type="submit" value="Search Date-a-base" style="padding: 3px; background: #DDD; border: 1px solid #AAA; color: #777;" /></p>
        </form>
    </div>
    <div style="float: left; width: 650px; border-top: 1px solid #DDD;">
        $results
    </div>
HTML;


include 'template.php';

?>