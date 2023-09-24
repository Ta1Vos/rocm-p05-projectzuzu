<?php
    $currentTime = date("G");

    if ($currentTime >= 18) {
        $greeting = "Goedenavond";
    } else if ($currentTime >= 12) {
        $greeting = "Goedemiddag";
    } else if ($currentTime >= 6) {
        $greeting = "Goedemorgen";
    } else {
        $greeting = "Goedenacht";
    }
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
    <div class="container-fluid ps-0">
        <img class="vw-100 vh-5" src="img/sushi_header.png" alt="Afbeelding van sushi">
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark">
        <div class="row container-fluid ps-0 ps-3">
            <div class="col-4"></div>
            <a class="col-1 navbar-brand ps-3 text-bright-red" href="index.php">ZuZu</a>
            <div class="col-1 collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sushi_orders.php">Sushi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order_overview.php">Besteloverzicht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer_info.php">Klantgegevens</a>
                    </li>
                </ul>
            </div>
            <div class="col-5"></div>
        </div>
    </nav>
</header>
<main>
    <div class="row text-center">
        <div class="col-4"></div>
        <div class="col-4">
            <h2>
                <span><?php echo $greeting; ?></span>, welkom bij ZuZu
            </h2>
            <small>
                Wij zijn gespecialiseerd in de Japanse keuken.<br>
                Het woord "sushi" is afkomstig van "su", wat azijn betekent en "shi" rijst.
            </small>
            <p class="fs-5 fw-bold">
                Vandaag dinsdag 7 september 2023
            </p>
            <p class="fs-6 fw-bold">
                Bezorgtijd: 17.00-21.00<br>
                Openingstijd: 12.00-21.00
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
            </div>
        </div>
        <div class="col-4">
            <div class="card mb-3 bg-red">
                <img src="img/sushi_image2.jpg" class="card-img-top" alt="Foto van sushi">
                <div class="card-body">
                    <h5 class="card-title">Keuze uit verschillende soorten sushi's</h5>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</main>
<footer>
    <div class="row vh-20 bg-dark text-white text-center p-3">
        <div class="col-2"></div>
        <div class="col-2">
            <h6>Contactgegevens</h6>
            <small>
                Restaurant ZuZu<br>
                Appelstraat 1<br>
                1111AA Fruit<br>
                zuzu@gmail.com<br>
                +06-12345678
            </small>
        </div>
        <div class="col-4"></div>
        <div class="col-2">
            <h6>Openingstijden</h6>
            <small>
                Maandag: Gesloten<br>
                Dinsdag: Gesloten<br>
                Woensdag: 16.00-20.00<br>
                Donderdag: 16.00-20.00<br>
                Vrijdag: 15.00-21.00<br>
                Zaterdag: 12.00-21.00<br>
                Zondag: 12.00-20.00<br>
            </small>
        </div>
        <div class="col-2"></div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>
