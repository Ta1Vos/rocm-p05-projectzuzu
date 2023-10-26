<?php
    session_start();

    $receipt = null;
    $receiptTotal = null;
    $customerInfoDiv = null;
    $confirmButton = null;

    if (!isset($_POST['confirm-order'])) {
        //If there hasn't been an order confirmation yet
        if (isset($_SESSION['customer-info'])) {
            $customerArray = unserialize($_SESSION['customer-info']);

            $customerInfoDiv = "<span>$customerArray[0]</span> <span>$customerArray[1]</span><br> <span>$customerArray[3]</span>
            <br> <span>$customerArray[4]</span> <span>$customerArray[5]</span><br> <span>$customerArray[2]</span>"; //Loads customer information

            //Checks if any sushi has already been selected on the sushi page
            if (isset($_SESSION['receipt'])) {
                $totalPrice = 0;
                $row = 0;

                //Loops through the session and echoes the sushi, prices and amounts
                foreach ($_SESSION['receipt'] as $receiptLine) {
                    //Checks if a row has been selected to be deleted
                    if (isset($_POST['remove-row-' . $row])) {
                        unset($_SESSION['receipt'][$row]); //Removes a row
                        $_SESSION['receipt'] = array_values($_SESSION['receipt']); //Restores array indexes
                        header("Refresh:0"); //Refreshes page so the receipt does not break
                    }
                    //Shortcuts to array items
                    $product = $receiptLine[0];
                    $amount = $receiptLine[1];
                    $price = $product["price"];
                    //Adds a row to the receipt
                    $receipt .= "&nbsp; <form method='post' class='row'><div class='col-7'><input type='submit' name='remove-row-{$row}' class='btn btn-danger' value='X'>&nbsp;&nbsp;";

                    $price = $amount * $price; //Calculates the total price

                    $receipt .= "{$product["name"]}</div><div class='col-3'></div><div class='col-2 text-end'>{$amount}x | &euro;" . number_format($price, 2, ",", ".") . "</div></form> <br>";
                    $totalPrice += $amount * $product["price"];
                    $row++; //Adds up 1 row as a new one will be created
                }

                //Shows order button after there is at least something to be purchased
                if ($totalPrice > 0) {
                    include("calc_open_time.php");
                    global $opened;
                    $confirmButton = "";

                    if (!$opened) {
                        $confirmButton = "<small>(Helaas zijn wij op dit moment gesloten. Ivm presentatie benodigdheden blijft de besteloptie zichtbaar)</small><br>";
                    }

                    $confirmButton .= "<input type='submit' name='confirm-order' value='Bestellen' class='btn btn-dark'>";
                }

                //Shows the total price of the receipt
                $receiptTotal = "&euro;" . number_format($totalPrice, 2, ",", ".");

                if (count($_SESSION['receipt']) <= 0) {
                    $receipt = "<div class='text-center'>U heeft nog geen sushi geselecteerd.<br><br><a href='sushi_orders.php' class='btn btn-dark'>Ga naar de sushi's</a></div>";
                }
            } else {
                $receipt = "<div class='text-center'>U heeft nog geen sushi geselecteerd.<br><br><a href='sushi_orders.php' class='btn btn-dark'>Ga naar de sushi's</a></div>";
            }
        } else {
            $customerInfoDiv = "U bent helaas niet ingelogd of u heeft nog geen gegevens doorgegeven. Hierdoor kunt u nog niets bestellen.";
        }
    } else {
        //If the order has been confirmed
        if (!isset($_SESSION['receipt'])) {// Small failsafe in case the session doesn't exist for some reason
            $_SESSION['receipt'] = array();
            header("Location: http://localhost/sd22-p5-projectzuzu-Ta1Vos/index.php");
        } else {
            include("db_connection.php");
            global $db;

            foreach ($_SESSION['receipt'] as $productLine) {
                try {
                    $product = $productLine[0];
                    $query = $db->prepare("UPDATE sushi SET available_amount = " . $product["available_amount"] - $productLine[1] . " WHERE id = " . $product["id"]);
                    $query->execute();
                } catch (PDOException $error) {
                    die("Oh oh! Er is iets fout gegaan! Error code: " . $error->getMessage());
                }
            }

            unset($_SESSION['receipt']);
            unset($_POST['confirm-order']);
            $receipt = "<h2 class='text-center'>Uw bestelling is doorgegeven!</h2>";
            $confirmButton = "<small>(Dit is geen fictieve bestelwebsite, er wordt helaas NIETS bezorgd)</small>";
        }
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
    <?= $navOverviewClass = "active"; ?>
    <?php include("navbar.php"); ?>
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
                    <form method="post" class="row">
                        <span class="col-4"></span>
                        <span class="col-4 text-center"><?= $confirmButton; ?></span>
                        <h5 class="col-4 text-end">Totaal: <?= $receiptTotal; ?></h5>
                    </form>
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
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>