<?php
session_start();

$screenOverlay = null;
$errorField = array();
$confirmSushiSave = false;
$amountInputType = "number";

//Cheatcode for testing with JOSF, turns amount input of sushis into text input.
if (isset($_SESSION['customer-info'])) {
    $overrideCodes = unserialize($_SESSION['customer-info']);

    //Overrides inputs if the code has been entered.
    if ($overrideCodes[0] == "josf" && $overrideCodes[1] == "tester") {
        $amountInputType = "text";
    }
}

if (!isset($_SESSION['receipt'])) {
    $_SESSION['receipt'] = array();
}

$divContent = null;

include("db_connection.php");
global $result;

//Updates sushi amount on local side so customer doesn't order more than which is present in the database.
/* NOTE: I used chatGPT to debug in this part due to the fact I couldn't troubleshoot a bug. The issue was, is that I
used `&$product`, instead of a key:value pair. This mistake made the array modification unpredictable and started to duplicate
and replace the next item in the array. By using a key:value reference (key is $i), and altering $result indirectly using
the key, I made the modification predictable and only working on this specific index, so it wouldn't be able to affect
other indexes. */
foreach ($_SESSION['receipt'] as $productInfo) {
    foreach ($result as $i => $product) { // Removed the & operator, replaced it with key:value
        $receiptProduct = $productInfo[0];

        if ($receiptProduct["id"] == $product["id"]) {
            $product["available_amount"] = intval($product["available_amount"]) - intval($productInfo[1]);
            $result[$i] = $product; // Update the original array, instead of directly changing it using `$product`
            break;
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
            //Checks if the customer doesn't give a negative number.
            if ($_POST["sushi-{$product["id"]}-amount"] > 0) {
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
                $errorField[$product["id"]] = "Vul een getal boven de 0 in!";
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
    $divContent .= "<div class='text-center'><p>Aantal:</p><br><input type='$amountInputType' name='sushi-{$product["id"]}-amount' class='small-num-input' value='1'></div><br>";
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
    <?= $navSushiClass = "active"; ?>
    <?php include("navbar.php"); ?>
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
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>