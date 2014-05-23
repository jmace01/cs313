<!doctype html>
    <html lang="en">
<head>
    
    <!--
    
        Copyright 2014 by Jason Mace
    
    -->
  
    <title><?php echo $title; ?> : Jason Mace</title>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="stylesheet" href="../template.css" type="text/css" />
    <script src="general.js"></script>
    <style type="text/css">
        h2, h3 {
            color: #727273;
        }
        #bodyWrapper {
            background: #EEE !important;
        }
        div#body {
            box-shadow: none;
            border: 1px solid #DDD;
            background: #FFF;
        }
    </style>
</head>
<body>
    <div id="backdrop" onclick="hidePopup();"></div>
    <div id="popup"></div>
    
    <header style="background: #326BA9">
        <h1>BYU-IDATE <span style="font-size: 18px; padding-left: 120px;">(Site not sponsored or endorsed by BYU&ndash;I)</span></h1>
    </header>
    
    <div id="bodyWrapper">
        <div id="body">
            <div id="menu">
                <a href="./">Home</a>
                <a href="./search.php">Search</a>
                <a href="./">Submit Date</a>
                <a href="./">Register</a>
            </div>
            <div id="content">
                <?php echo $body; ?>
            </div>
        </div>
    </div>
    
    <div id="footer" style="background: #326BA9">
        <p>Copyright <?php echo date('Y'); ?> by Jason Mace</p>
    </div>

</body>
    </html>
