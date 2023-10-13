<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=zuzu", "root", "");

    $query = $db->prepare("SELECT * FROM sushi");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $error) {
    die("Oh oh! Er is iets fout gegaan! Error code: " . $error->getMessage());
}

?>
