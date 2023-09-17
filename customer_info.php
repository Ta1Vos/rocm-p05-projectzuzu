<?php
//Error fields
$firstNameError = null;
$lastNameError = null;
$emailError = null;
$addressError = null;
$postalCodeError = null;
$residenceError = null;

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

    if (!filter_var($emailInput, FILTER_VALIDATE_EMAIL))  {
        $emailError = "*Vul dit veld in";
        $fieldError = true;
    }

    if (strlen($addressInput) <= 4) {
        $addressError = "*Vul dit veld in";
        $fieldError = true;
    }

    if (strlen($postalCodeInput) != 6) {
        $postalCodeError = "*Vul dit veld in";
        $fieldError = true;
    }

    if (empty($residenceInput)) {
        $residenceError = "*Vul dit veld in";
        $fieldError = true;
    }

    if (!$fieldError) {
        $firstNameInput = "Alles is ingevuld!";
    } else {
        $firstNameInput = "Niet alles is ingevuld!";
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
                        <a class="nav-link" href="order_overview.php">Besteloverzicht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="customer_info.php">Klantgegevens</a>
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
                <input type="submit" class="btn btn-dark" name="submit-info" value="Ga naar sushi's">
            </form>
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