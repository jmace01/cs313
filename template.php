<!doctype html>
    <html lang="en">
<head>
    
    <!--
    
        Copyright 2014 by Jason Mace
    
    -->
  
    <title><?php echo $title; ?> : Jason Mace</title>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="stylesheet" href="template.css" type="text/css" />
    <script src="general.js"></script>
</head>
<body>
    <div id="backdrop" onclick="hidePopup();"></div>
    <div id="popup"></div>
    
    <header>
        <h1>&lt; / &gt; JASON MACE : WEB DEVELOPMENT</h1>
    </header>
    
    <div id="bodyWrapper">
        <div id="body">
            <div id="menu">
                <a href="./">About Jason</a>
                <a href="./assignments.php">Assignments</a>
            </div>
            <div id="content">
                <?php echo $body; ?>
            </div>
        </div>
    </div>
    
    <div id="footer">
        <p>Copyright <?php echo date('Y'); ?> by Jason Mace</p>
    </div>

</body>
    </html>
