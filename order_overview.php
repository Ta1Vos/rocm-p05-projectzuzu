<?php
    session_start();

    $receipt = null;
    $receiptTotal = null;
    $customerInfoDiv = null;

    if ($_SESSION['customer-info']) {
        $customerArray = unserialize($_SESSION['customer-info']);

        $customerInfoDiv = "{$customerArray[0]} {$customerArray[1]}<br> {$customerArray[3]}<br> {$customerArray[4]} {$customerArray[5]}<br> {$customerArray[2]}";

        //Checks if any sushi has already been selected
        if (isset($_SESSION['receipt'])) {
            $totalPrice = 0;
            $row = 0;

            //Loops through the session and echoes the sushi, prices and amounts
            foreach ($_SESSION['receipt'] as $receiptLine) {
                //Checks if a row has been selected to be deleted
                if (isset($_POST['remove-row-' . $row])) {
                    //Removes a row
                    unset($_SESSION['receipt'][$row]);
                    //Restores array indexes
                    $_SESSION['receipt'] = array_values($_SESSION['receipt']);
                    //Refreshes page
                    header("Refresh:0");
                }

                $product = $receiptLine[0];
                $amount = $receiptLine[1];

                $receipt .= "&nbsp; <form method='post' class='row'><div class='col-7'><input type='submit' name='remove-row-{$row}' class='btn btn-danger' value='X'>&nbsp;&nbsp;";
                $receipt .= "{$product["name"]}</div><div class='col-3'></div><div class='col-2 text-end'>{$amount}x | &euro;" . number_format($product["price"], 2, ",", ".") . "</div></form> <br>";
                $totalPrice += $amount * $product["price"];
                $row++;
            }

            //Shows the total price of the receipt
            $receiptTotal = "&euro;" . number_format($totalPrice, 2, ",", ".");
        }
    } else {
        $customerInfoDiv = "U bent helaas niet ingelogd of u heeft nog geen gegevens doorgegeven. Hierdoor kunt u nog niets bestellen.";
    }
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>ZuZu | Besteloverzicht</title>
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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sushi_orders.php">Sushi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="order_overview.php">Besteloverzicht</a>
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
    <div class="row mt-5">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card p-2 ps-3">
                <h2 class="card-title">
                    Bestelling
                </h2>
                <div class="card-body p-1">
                    <p class="order-overview-result">
                        <?= $receipt; ?>
                    </p>
                    <p>
                        <h5 class="text-end">Totaal: <?= $receiptTotal; ?></h5>
                    </p>
                </div>
            </div>
            <div class="card p-2 ps-3">
                <h2 class="card-title">
                    Klantgegevens
                </h2>
                <div class="card-body p-1">
                    <?= $customerInfoDiv; ?>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</main>
<footer>
    <div class="row vh-20 bg-dark text-white text-center p-3 mt-5">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>