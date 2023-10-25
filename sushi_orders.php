<?php
session_start();

$screenOverlay = null;
$errorField = array();
$confirmSushiSave = false;

if (!isset($_SESSION['receipt'])) {
    $_SESSION['receipt'] = array();
}

$divContent = null;

include("db_connection.php");
global $result;

//Updates shushi amount on local side so customer doesn't order more than which is present in the database.
foreach ($_SESSION['receipt'] as $productInfo) {
    foreach ($result as &$product) {
        global $productInfo;
        $receiptProduct = $productInfo[0];

        if ($receiptProduct["id"] == $product["id"]) {
            $product["available_amount"] = intval($product["available_amount"]) - intval($productInfo[1]);
        }
    }
}

//Sushi Loader
$divContent = "<div class='row d-flex align-items-stretch'>";
//Checks if a sushi button has already been pressed once and saves the sushi & its amount to the receipt
foreach ($result as $product) {
    $errorField[$product["id"]] = null; //Creates the array index

    //Checks for the sushi that has been selected
    if (isset($_POST['add-sushi-' . $product["id"]])) {
        //Checks if given amount is a valid number
        if (filter_input(INPUT_POST, "sushi-{$product["id"]}-amount", FILTER_VALIDATE_INT)) {
            //Checks if requested amount is within the range of the available amount
            if ($product["available_amount"] >= $_POST["sushi-{$product["id"]}-amount"]) {
                $errorField[$product["id"]] = "<div class=text-success>" . $_POST["sushi-{$product["id"]}-amount"] . "x " . $product["name"] . " aan uw bon toegevoegd</div>";//Adds confirmation message
                //Adds sushi to receipt
                $_SESSION['receipt'][] = [$product, $_POST["sushi-{$product["id"]}-amount"]];
                $product["available_amount"] -= $_POST["sushi-{$product["id"]}-amount"];
            } else {
                $errorField[$product["id"]] = "Helaas kunnen wij niet meer dan {$product["available_amount"]} {$product["name"]} leveren.";//Error message in case the user wants more sushi than there is available
            }
        } else {
            $errorField[$product["id"]] = "Vul een getal in!";
        }

        // CREATE MESSAGE FOR NOT ENOUGH AVAILABILITY
    }
}

//Creates a card for every sushi in the database
foreach ($result as $product) {
    $divContent .= "<form method='post' class='card m-3 d-flex flex-column p-3' style='width: 18rem;'>";
    $divContent .= "<img src='{$product["image"]}' class='card-img-top' alt='Afbeelding van de sushi'>";
    $divContent .= "<div class='card-body'>";
    $divContent .= "<h5 class='card-title'>{$product["name"]}</h5>";
    $divContent .= "<p class='card-text'>Ingrediënten:<br><br>{$product["ingredients"]}</p>";
    $divContent .= "<h5 class='card-title'>{$product["price"]}</h5></div>";
    $divContent .= "<div class='text-center'><p>Aantal:</p><br><input type='number' name='sushi-{$product["id"]}-amount' class='small-num-input' value='1'></div><br>";
    $divContent .= "<div class='text-center error-field'>" . $errorField[$product["id"]] . "</div><br>";
    $divContent .= "<input type='submit' name='add-sushi-{$product["id"]}' class='btn btn-primary justify-self-end' value='Bestellen'></form>";
}

$divContent .= "</div>";
//Sushi Loader End
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
    <title>ZuZu | Bestellen</title>
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
                        <a class="nav-link active" href="sushi_orders.php">Sushi</a>
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
    <div class="overlay <?= $screenOverlay; ?>">
        <div class="row mt-5">
            <div class="col-2"></div>
            <div class="col-8">
                <h2>Sushi's bestellen</h2>
                <div class="sushi-overview">
                    <?= $divContent; ?>
                </div>
                <a href="order_overview.php">
                    <button type="button" class="btn btn-dark mt-5">Naar bestel overzicht</button>
                </a>
            </div>
            <div class="col-2"></div>
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>