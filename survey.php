<?php

$file = fopen('./survey.txt', 'r');

//fwrite($file, "Google | www.google.com\nBYU-Idaho | www.byui.edu\nESPN | www.espn.com");

$links = '';
while($line = fgets($file)) {
    $parts = explode(' | ', $line);
    $links .= '<a href="http://'.$parts[1].'">'.$parts[0].'</a><br />';
}

fclose($file);


$title = 'Survey';

$body = <<<HTML
    <h2>Take the survey!</h2>
    <p>Or go dierectly to <a href="">the results.</a></p>
    <p><a href="./assignments.php">&lt; Back to assignments</a></p>
    <form method="post" action="">
        <p>Please answer the following questions with your preferences so that we can better market you with our campus spam emails.</p>
        
        <fieldset>
            <legend>Operating System:</legend>
            <p>
                <input type="radio" name="os" id="mac" value="mac" /><label for="mac">Mac OS</label>
                <input type="radio" name="os" id="linux" value="linux" /><label for="linux">Linux</label>
                <input type="radio" name="os" id="win" value="windows" /><label for="win">Windows</label>
                <input type="radio" name="os" id="other" value="other" /><label for="other">Other</label>
            </p>
        </fieldset>
        
        <fieldset>
            <legend>Computer Type:</legend>
            <p>
                <input type="radio" name="type" id="laptop" value="laptop" /><label for="laptop">Laptop</label>
                <input type="radio" name="type" id="desktop" value="desktop" /><label for="desktop">Desktop</label>
                <input type="radio" name="type" id="other" value="other" /><label for="other">Other</label>
            </p>
        </fieldset>
        
        <fieldset>
            <legend>You spend most of your time on your computer:</legend>
            <p>
                <input type="radio" name="time" id="gaming" value="gaming" /><label for="gaming">Gaming</label>
                <input type="radio" name="time" id="working" value="working" /><label for="working">Working</label>
                <input type="radio" name="time" id="homework" value="homework" /><label for="homework">Doing Homework</label>
                <input type="radio" name="time" id="cats" value="cats" /><label for="cats">Looking at pictures of cats</label>
                <input type="radio" name="time" id="other" value="other" /><label for="other">Other</label>
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