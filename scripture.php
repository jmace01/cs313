<?php


/**
 * Connect to the Database
 */

//Open Shift Credentials
$host = getEnv("OPENSHIFT_MYSQL_DB_HOST");
$port = ':'.getEnv("OPENSHIFT_MYSQL_DB_PORT");
$user = getEnv("OPENSHIFT_MYSQL_DB_USERNAME");
$pass = getEnv("OPENSHIFT_MYSQL_DB_PASSWORD");

//Offline credentials
if ($host == '') {
    $host = 'localhost';
    $port = '';
    $user = 'root';
    $pass = 'root';
}

//Open the connection
try {
    $pdo = new PDO("mysql:host=$host$port;dbname=php", $user, $pass);
} catch (PDOException $e) {
    die('Could Not Connect!');
}




$pdo->query("CREATE TABLE IF NOT EXISTS `topics`
    ( id SERIAL
    , topicName VARCHAR(100)
    , PRIMARY KEY (id)
    )
");

//$pdo->query("TRUNCATE TABLE `topics`");
//$pdo->query("INSERT INTO topics (topicName) VALUES ('faith')");
//$pdo->query("INSERT INTO topics (topicName) VALUES ('sacrifice')");
//$pdo->query("INSERT INTO topics (topicName) VALUES ('charity')");



$pdo->query("CREATE TABLE IF NOT EXISTS scriptureTopics
    ( id          SERIAL
    , scriptureID BIGINT UNSIGNED
    , topicID     BIGINT UNSIGNED
    , PRIMARY KEY (id)
    , FOREIGN KEY (scriptureID) REFERENCES Scriptures(id)
    , FOREIGN KEY (topicID)     REFERENCES topics(id)
    )
");









##########



if (isset($_POST['book'])) {
    $statement = $pdo->prepare("INSERT INTO Scriptures (book, chapter, verse, content) VALUES (:b, :ch, :v, :co)");
    $statement->bindValue(':b', $_POST['book'], PDO::PARAM_STR);
    $statement->bindValue(':ch', $_POST['chapter'], PDO::PARAM_STR);
    $statement->bindValue(':v', $_POST['verse'], PDO::PARAM_STR);
    $statement->bindValue(':co', $_POST['content'], PDO::PARAM_STR);
    $statement->execute();
    $id = $pdo->lastInsertId();
    
    foreach($_POST['topic'] as $t) {
        $statement = $pdo->prepare("INSERT INTO scriptureTopics (scriptureID, topicID) VALUES (:sid, :tid)");
        $statement->bindValue(':sid', $id, PDO::PARAM_INT);
        $statement->bindValue(':tid', $t, PDO::PARAM_INT);
        $statement->execute();
    }
    
    header("Location: ./database.php");
    die();
}



$statement = $pdo->prepare("SELECT * FROM topics");
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$topics = '';
foreach($rows as $row) {
    $topics .= '<p><input type="checkbox" name="topic[]" value="'.$row['id'].'" />'.$row['topicName'].'</p>';
}





?>
<!DOCTYPE html>
    <html>
<head>
    <title></title>
</head>
<body>
    <form action="scripture.php" method="post">
        <p>Book</p>
        <p><input type="text" name="book" /></p>
        <p>Chapter</p>
        <p><input type="text" name="chapter" /></p>
        <p>Verse</p>
        <p><input type="text" name="verse" /></p>
        <p>Content</p>
        <p><textarea name="content"></textarea></p>
        <p>Topics</p>
        <?php echo $topics; ?>
        <p><input type="submit" name="Submit Verse" /></p>
    </form>
</body>
    </html>