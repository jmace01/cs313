<?php

function getArray($line) {
    $arr = array();
    $data = explode('|',$line);
    foreach ($data as $d) {
        $d = explode(':', $d);
        $arr[$d[0]] = $d[1];
    }
    return $arr;
}



function getQuestion($title, $array) {
    //Question Header
    $results = '<h3>'.$title.'</h3>';
    //Total Submitted
    $total = 0;
    foreach ($array as $val) $total += $val;
    //Results
    foreach ($array as $key => $value) {
        $percent = round($value * 100 / $total);
        $results .= "<div style=\"position: relative; margin-top: 10px;\"><div style=\"width: $percent%; height: 40px; background: lavender;\"><p style=\"position: absolute; left: 10px; top: 0px;\"><b>$key</b> ($value vote or $percent%)</p></div></div>";
    }
    return $results;
}



$file = fopen('./survey.txt', 'r+');

$os   = getArray(fgets($file));
$type = getArray(fgets($file));
$time = getArray(fgets($file));
$spam = getArray(fgets($file));


fclose($file);


$results  = getQuestion('Operating System', $os);
$results .= getQuestion('Computer Type', $type);
$results .= getQuestion('Time Spent', $time);
$results .= getQuestion('Spam', $spam);


$title = 'Survey Results';

$body = <<<HTML
    <h2>Survey Results!</h2>
    <p><a href="./assignments.php">&lt; Back to assignments</a></p>
    $results
HTML;


include 'template.php';

?>