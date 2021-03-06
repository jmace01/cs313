<form action="" method="get">
    <p><input type="text" name="book" value="<?php if (isset($_GET['book'])) echo $_GET['book']; ?>" /> <input type="submit" value="Search by Book Name" /></p>
</form>
<?php

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

try {
    $pdo = new PDO("mysql:host=$host$port;dbname=php", $user, $pass);
}
catch (PDOException $e) {
    print_r($e);
    die('Could Not Connect!');
}

$pdo->query("
    CREATE TABLE IF NOT EXISTS Scriptures
    ( id      SERIAL
    , book    VARCHAR(40)
    , chapter INT
    , verse   INT
    , content TEXT
    , PRIMARY KEY (id)
    )
");
/*
$pdo->query("TRUNCATE TABLE Scriptures");

$pdo->query("
    INSERT INTO Scriptures VALUES
        ( NULL
        , 'John'
        , 1
        , 5
        , 'And the light shineth in darkness; and the darkness comprehended it not.'
    );
");

$pdo->query("
    INSERT INTO Scriptures VALUES
        ( NULL
        , 'Doctrine and Covenants'
        , 88
        , 49
        , 'The light shineth in darkness, and the darkness comprehendeth it not; nevertheless, the day shall come when you shall comprehend even God, being quickened in him and by him.'
    );
");

$pdo->query("
    INSERT INTO Scriptures VALUES
        ( NULL
        , 'Doctrine and Covenants'
        , 93
        , 28
        , 'He that keepeth his commandments receiveth truth and light, until he is glorified in truth and knoweth all things.'
    );
");

$pdo->query("
    INSERT INTO Scriptures VALUES
        ( NULL
        , 'Mosiah'
        , 16
        , 9
        , 'He is the light and the life of the world; yea, a light that is endless, that can never be darkened; yea, and also a life which is endless, that there can be no more death.'
    );
");
*/

$search = '';
if (isset($_GET['book'])) {
    $search = 'WHERE book=:book';
}

$statement = $pdo->prepare("SELECT * FROM Scriptures $search");
if (isset($_GET['book'])) {
    $statement->bindValue(':book',$_GET['book'],PDO::PARAM_STR);
}
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($rows as $row) {
    $topics = '';
    $id = $row['id'];
    $s = $pdo->prepare("SELECT * FROM `topics` LEFT JOIN scriptureTopics ON scriptureTopics.topicID = `topics`.id WHERE scriptureTopics.scriptureID = $id");
    $s->execute();
    $rs = $s->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rs as $r) {
        $topics .= "$r[topicName] ";
    }
    echo "<p><b>$row[book] $row[chapter]:$row[verse]</b> &mdash; $row[content] <i>[ $topics ]</i></p>";
}


?>