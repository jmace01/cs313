<?php


$title = 'About Jason';

$body = <<<HTML
    <img src="Jason_above.jpg" onclick="showPopup('&lt;img src=&quot;Jason_above.jpg&quot; style=&quot;width: 100%;&quot; /&gt;');" />
    <h2>Introducing Jason Mace</h2>
    <p>Hello world! I'm Jason, a computer science major from Houston, Texas.</p>
    <p>I'm enjoy Tae Kwon Do, playing the ukulele, and long walks on the beach.</p>
    <p>Check out my assignments.</p>
HTML;


include 'template.php';

?>