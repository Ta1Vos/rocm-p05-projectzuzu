<?php
session_start();
$db = new PDO("mysql:host=localhost;dbname=zuzu", "root", "");

$query = $db->prepare("SELECT * FROM sushi");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

//Updates available sushi amount to 50!
foreach ($result as $sushi) {
    $sushi["available_amount"] = 50;

    $query = $db->prepare("UPDATE sushi SET available_amount = 50 WHERE id = " . $sushi["id"]);

    if ($query->execute()) {
        echo "sushi {$sushi["id"]} aangepast!<br>";
    } else {
        echo "sushi {$sushi["id"]} NIET aangepast!<br>";
    }
}

session_destroy();
header("location:http://localhost/sd22-p5-projectzuzu-Ta1Vos/index.php");
sleep(5);

?>