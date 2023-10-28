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

            $customerInfoDiv = "<span class='fs-4 underlined'>$customerArray[0]</span> <span class='fs-4'>$customerArray[1]</span><br> <span class='fs-4'>$customerArray[3]</span>
            <br> <span class='fs-4'>$customerArray[4]</span> <span class='fs-4'>$customerArray[5]</span><br> <span class='fs-4'>$customerArray[2]</span>"; //Loads customer information

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

                    $receipt .= "<span>{$product["name"]}</span></div><div class='col-1 col-lg-3'></div><div class='col-4 col-lg-2 text-end border-start'>{$amount}x | &euro;" . number_format($price, 2, ",", ".") . "</div></form> <br>";
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

                    $confirmButton .= "<input type='submit' name='confirm-order' value='Bestellen' class='btn btn-dark mt-3'>";
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
            $customerInfoDiv = "<div class='text-center mt-2 fw-bold'>U bent helaas niet ingelogd of u heeft nog geen gegevens doorgegeven. Hierdoor kunt u nog niets bestellen.<br><br>
            <a href='customer_info.php' class='btn btn-danger bg-red my-3'>Ga naar de registratiepagina</a></div>";
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
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card shadow border-bg-red">
                <h2 class="card-header text-dred text-center py-2">
                    Bestelling
                </h2>
                <div class="card-body p-2 ps-3">
                    <p class="order-overview-result">
                        <?= $receipt; ?>
                    </p>
                    <form method="post" class="row d-flex">
                        <span class="col-lg-4"></span>
                        <span class="col-12 col-lg-4 text-center"><?= $confirmButton; ?></span>
                        <div class="col-lg-2"></div>
                        <h5 class="col-12 col-lg-2 text-center text-lg-end pt-3 pt-lg-0 align-self-center">Totaal: <?= $receiptTotal; ?></h5>
                    </form>
                </div>
            </div>
            <div class="card shadow border-bg-red">
                <h2 class="card-header text-dred text-center py-2">
                    Klantgegevens
                </h2>
                <div class="card-body p-2 ps-3 text-center">
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