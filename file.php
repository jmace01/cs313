<?php

    //start session
    session_start();
    
    //initialize session visits variable
    if (!isset($_SESSION['visits']))
    {
        $_SESSION['visits'] = 0;
    }
    
    //increment visits
    $_SESSION['visits']++;

?>  
<!DOCTYPE html>
<html>
    <head>
        <title>Test Page!</title>
        <style>
            body {
                background: fuchsia;
                color: yellow;
            }
        </style>
    </head>
    <body>
<?php

    //output visits
    echo '<h1>You\'ve been scarred by this page: <span style="color: green;">'.$_SESSION['visits'].'</span> times.</h1>';

?>
        <p><u>This is not a link.</u></p>
        <img src="http://media3.giphy.com/media/zEO5eq3ZsEwbS/giphy.gif" />
    </body>
</html>