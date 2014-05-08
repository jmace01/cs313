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



function getLine($array) {
    $items = array();
    foreach ($array as $key => $item) {
        $items[] = "$key:$item";
    }
    return implode('|',$items);
}



if (isset($_POST['submit'])) {
    $file = fopen('./survey.txt', 'r+');
    
    $os   = getArray(fgets($file));
    $type = getArray(fgets($file));
    $time = getArray(fgets($file));
    $spam = getArray(fgets($file));
    
    //Validate answers and add them to the results
    if (key_exists($_POST['os'], $os)) {
        $os[$_POST['os']]++;
    }
    
    if (key_exists($_POST['type'], $type)) {
        $type[$_POST['type']]++;
    }
    
    if (key_exists($_POST['time'], $time)) {
        $time[$_POST['time']]++;
    }
    
    if (isset($_POST['spam'])) {
        $spam['yes']++;
    }
    
    file_put_contents("survey.txt", "");
    $output  = getLine($os);
    $output .= getLine($type);
    $output .= getLine($time);
    $output .= getLine($spam);

    
    fwrite($file, $output);
    
    fclose($file);
    
    header("Location: survey_results.php");
    die();
}



$title = 'Survey';

$body = <<<HTML
    <h2>Take the survey!</h2>
    <p>Or go dierectly to <a href="./survey_results.php">the results.</a></p>
    <p><a href="./assignments.php">&lt; Back to assignments</a></p>
    <form method="post" action="">
        <p>Please answer the following questions with your preferences so that we can better market you with our campus spam emails.</p>
        
        <fieldset>
            <legend>Operating System:</legend>
            <p>
                <input type="radio" name="os" id="mac" value="Mac OS" /><label for="mac">Mac OS</label>
                <input type="radio" name="os" id="linux" value="Linux" /><label for="linux">Linux</label>
                <input type="radio" name="os" id="windows" value="Windows" /><label for="win">Windows</label>
                <input type="radio" name="os" id="other" value="Other" /><label for="other">Other</label>
            </p>
        </fieldset>
        
        <fieldset>
            <legend>Computer Type:</legend>
            <p>
                <input type="radio" name="type" id="laptop" value="Laptop" /><label for="laptop">Laptop</label>
                <input type="radio" name="type" id="desktop" value="Desktop" /><label for="desktop">Desktop</label>
                <input type="radio" name="type" id="other" value="Other" /><label for="other">Other</label>
            </p>
        </fieldset>
        
        <fieldset>
            <legend>You spend most of your time on your computer:</legend>
            <p>
                <input type="radio" name="time" id="gaming" value="Gaming" /><label for="gaming">Gaming</label>
                <input type="radio" name="time" id="working" value="Working" /><label for="working">Working</label>
                <input type="radio" name="time" id="homework" value="Doing Homework" /><label for="homework">Doing Homework</label>
                <input type="radio" name="time" id="cats" value="Looking at pictures of cats" /><label for="cats">Looking at pictures of cats</label>
                <input type="radio" name="time" id="other" value="Other" /><label for="other">Other</label>
            </p>
        </fieldset>
        
        <fieldset>
            <legend>Click if you enjoy spam emails:</legend>
            <p><input type="checkbox" name="spam" id="spam" /> <label for="spam">I enjoy spam emails!</label></p>
        </fieldset>
        
        <p><input type="submit" value="Submit Answers!" name="submit" onclick="return validate()" /></p>
    </form>
    
    <script type="text/javascript">
        function validate() {
            if (!document.getElementById('spam').checked) {
                alert("You must love spam to submit the form.");
                return false;
            }
            return true;
        }
    </script>
HTML;


include 'template.php';

?>