<?php

if (isset($_POST['send'])) {
    $places = '';
    if (isset($_POST['northamerica'])) $places .= 'North America<br />';
    if (isset($_POST['southamerica'])) $places .= 'South America<br />';
    if (isset($_POST['europe'])) $places .= 'Europe<br />';
    if (isset($_POST['asia'])) $places .= 'Asia<br />';
    if (isset($_POST['australia'])) $places .= 'Australia<br />';
    if (isset($_POST['africa'])) $places .= 'Africa<br />';
    if (isset($_POST['antarctica'])) $places .= 'Antarctica<br />';
    
    echo <<< HTML
<!doctype html>
    <html lang="en">
<head>
    <title>Jason Mace : Hello</title>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
</head>
<body>
    <h1>Thank you!</h1>
    <p>Name: $_POST[name]</p>
    <p>Email: <a href="mailto:$_POST[email]">$_POST[email]</a></p>
    <p>Major: $_POST[major]</p>
    <p>Places: <br />$places</p>
    <p>Comments:</p>
    <p>$_POST[comments]</p>
</body>
    </html>
HTML;

    die();
}

?>
<!doctype html>
    <html lang="en">
<head>
    <title>Jason Mace : Hello</title>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
</head>
<body>
  <form action="" method="post">
      <p><label for="name">Name</label></p>
      <p><input type="text" id="name" name="name" /></p>
      <p><label for="email">Email Address</label></p>
      <p><input type="email" id="email" name="email" /></p>
      
      <p>Please select your major:</p>
      <p><input type="radio" name="major" value="Computer Science" id="cs"/><label for="cs">Computer Science</label></p>
      <p><input type="radio" name="major" value="Web Development and Design" id="wd"/><label for="wd">Web Development and Design</label></p>
      <p><input type="radio" name="major" value="Computer Information Technology" id="cit"/><label for="cit">Computer Information Technology</label></p>
      <p><input type="radio" name="major" value="Computer Engineering" id="ce"/><label for="ce">Computer Engineering</label></p>
      
      <p>Check the places you have visited:</p>
      <p><input type="checkbox" name="northamerica" id="na" /><label for="na">North America</label></p>
      <p><input type="checkbox" name="southamerica" id="sa" /><label for="sa">South America</label></p>
      <p><input type="checkbox" name="europe" id="eur" /><label for="eur">Europe</label></p>
      <p><input type="checkbox" name="asia" id="asia" /><label for="asia">Asia</label></p>
      <p><input type="checkbox" name="australia" id="aus" /><label for="aus">Australia</label></p>
      <p><input type="checkbox" name="africa" id="af" /><label for="af">Africa</label></p>
      <p><input type="checkbox" name="antarctica" id="ant" /><label for="ant">Antarctica</label></p>
      
      <p><label for="comments">Comments:</label></p>
      <p>
          <textarea name="comments" style="width: 300px; height: 150px;">Your comments here</textarea>
      </p>
      
      <p><input type="submit" name="send" value="Send Your Information" /></p>
  </form>
</body>
    </html>
