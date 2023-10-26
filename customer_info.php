<?php
session_start();

include("db_connection.php");
global $db;

//Error fields
$firstNameError = null;
$lastNameError = null;
$emailError = null;
$addressError = null;
$postalCodeError = null;
$residenceError = null;
$submitDescription = null;

//Input fields
$firstNameInput = null;
$lastNameInput = null;
$emailInput = null;
$addressInput = null;
$postalCodeInput = null;
$residenceInput = null;

if (isset($_POST['submit-info'])) {
    $fieldError = false;

    $firstNameInput = $_POST['first-name-input'];
    $lastNameInput = $_POST['last-name-input'];
    $emailInput = $_POST['email-input'];
    $addressInput = $_POST['address-input'];
    $postalCodeInput = $_POST['postal-code-input'];
    $residenceInput = $_POST['residence-input'];

    if (empty($firstNameInput)) {
        $firstNameError = "*Vul dit veld in";
        $fieldError = true;
    }

    if (empty($lastNameInput)) {
        $lastNameError = "*Vul dit veld in";
        $fieldError = true;
    }

    if (empty($emailInput)) {
        $emailError = "*Vul dit veld in";
        $fieldError = true;
    } else if (!filter_var($emailInput, FILTER_VALIDATE_EMAIL))  {
        $emailError = "*Vul een correcte email in";
        $fieldError = true;
    }

    if (empty($addressInput)) {
        $addressError = "*Vul dit veld in";
        $fieldError = true;
    } else if (strlen($addressInput) <= 4)  {
        $addressError = "*Vul een correct adres in";
        $fieldError = true;
    }

    if (empty($postalCodeInput)) {
        $postalCodeError = "*Vul dit veld in";
        $fieldError = true;
    } else if (strlen($postalCodeInput) != 6)  {
        $postalCodeError = "*Vul een correcte postcode in";
        $fieldError = true;
    }

    if (empty($residenceInput)) {
        $residenceError = "*Vul dit veld in";
        $fieldError = true;
    }

    if (!$fieldError) {
        $query = $db->prepare("INSERT INTO customer(first_name, last_name, email, address, postal_code, residence)
VALUES (:firstName, :lastName, :email, :address, :postalCode, :residence)");

        $query->bindParam("firstName", $firstNameInput);
        $query->bindParam("lastName", $lastNameInput);
        $query->bindParam("email", $emailInput);
        $query->bindParam("address", $addressInput);
        $query->bindParam("postalCode", $postalCodeInput);
        $query->bindParam("residence", $residenceInput);

        if ($query->execute()) {
            $submitDescription = "Het formulier is verzonden!<br>";
            //Information save code/advanced validation system with real life locations.
            $_SESSION['customer-info'] = serialize([$firstNameInput, $lastNameInput, $emailInput, $addressInput, $postalCodeInput, $residenceInput]);
            header("Location: http://localhost/sd22-p5-projectzuzu-Ta1Vos/order_overview.php");
        } else {
            $submitDescription = "Er is iets fout gegaan! Uw gegevens zijn NIET toegevoegd aan onze database. Als dit probleem blijft voorkomen neem a.u.b. contact met ons op.";
        }
    } else {
        $submitDescription = "Niet alles is correct ingevuld, het formulier is niet verzonden<br>";
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
    <title>ZuZu | Klantgegevens</title>
</head>
<body>
<header>
    <?= $navInfoClass = "active"; ?>
    <?php include("navbar.php"); ?>
</header>
<main>
    <div class="row mt-5">
        <div class="col-2"></div>
        <div class="col-8">
            <form method="post" action="">
                <h2>Klantgegevens</h2>
                <!-- First name -->
                <div class="mb-3">
                    <div class="error-field"><?= $firstNameError; ?></div>
                    <label for="exampleInputPassword1" class="form-label">Voornaam</label>
                    <input type="text" class="form-control" name="first-name-input" value="<?= $firstNameInput; ?>">
                </div>
                <!-- Last name -->
                <div class="mb-3">
                    <div class="error-field"><?= $lastNameError; ?></div>
                    <label for="exampleInputPassword1" class="form-label">Achternaam</label>
                    <input type="text" class="form-control" name="last-name-input" value="<?= $lastNameInput; ?>">
                </div>
                <!-- Email -->
                <div class="mb-3">
                    <div class="error-field"><?= $emailError; ?></div>
                    <label for="exampleInputPassword1" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email-input" value="<?= $emailInput; ?>">
                </div>
                <!-- Address -->
                <div class="mb-3">
                    <div class="error-field"><?= $addressError; ?></div>
                    <label for="exampleInputPassword1" class="form-label">Adres</label>
                    <input type="text" class="form-control" name="address-input" value="<?= $addressInput; ?>">
                </div>
                <!-- Postcode -->
                <div class="mb-3">
                    <div class="error-field"><?= $postalCodeError; ?></div>
                    <label for="exampleInputPassword1" class="form-label">Postcode</label>
                    <input type="text" class="form-control" name="postal-code-input" value="<?= $postalCodeInput; ?>">
                </div>
                <!-- City -->
                <div class="mb-3">
                    <div class="error-field"><?= $residenceError; ?></div>
                    <label for="exampleInputPassword1" class="form-label">Woonplaats</label>
                    <input type="text" class="form-control" name="residence-input" value="<?= $residenceInput; ?>">
                </div>
                <div class="error-field"><?= $submitDescription; ?></div>
                <input type="submit" class="btn btn-dark" name="submit-info" value="Ga naar sushi's">
            </form>
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