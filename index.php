<?php
include("calc_open_time.php");
global $greeting, $dateToday, $currentOpenTime, $deliveryStatus;

$deliveryStatus = "Het spijt ons, maar rond deze tijden bezorgen wij nog niet";

//Attempted to define all variables for navbar, having no result in the end. The include file still has an undefined error
$navHomeClass = "active";
$navSushiClass = null;
$navOverviewClass = null;
$navInfoClass = null;
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>ZuZu | Home</title>
</head>
<body>
<header>
    <?php include("navbar.php"); ?>
</header>
<main>
    <div class="row text-center">
        <div class="col-4"></div>
        <div class="col-4">
            <h2>
                <span><?= $greeting; ?></span>, welkom bij ZuZu
            </h2>
            <small>
                Wij zijn gespecialiseerd in de Japanse keuken.<br>
                Het woord "sushi" is afkomstig van "su", wat azijn betekent en "shi" rijst.
            </small>
            <p class="fs-5 fw-bold">
                Het is vandaag <?= $dateToday; ?>
            </p>
            <p class="fs-6 fw-bold">
                Openingstijd: <?= $currentOpenTime; ?><br>
                Bezorgtijd vanaf nu: <?= $deliveryStatus; ?><br>
            </p>
        </div>
        <div class="col-4"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-4">
            <div class="card mb-3 bg-red">
                <img src="img/sushi_image1.jpg" class="card-img-top" alt="Foto van sushi">
                <div class="card-body">
                    <h5 class="card-title">Bestel bij ons uw sushi's</h5>
                </div>
                <a href="order_overview.php" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-4">
            <div class="card mb-3 bg-red">
                <img src="img/sushi_image2.jpg" class="card-img-top" alt="Foto van sushi">
                <div class="card-body">
                    <h5 class="card-title">Keuze uit verschillende soorten sushi's</h5>
                </div>
                <a href="sushi_orders.php" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</main>
<footer>
    <?php include("footer.php"); ?>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>
