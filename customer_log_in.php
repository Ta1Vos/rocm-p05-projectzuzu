<?php
session_start();

$firstNameError = null;
$lastNameError = null;
$emailError = null;

$firstNameInput = null;
$lastNameInput = null;
$emailInput = null;
$emailInputType = "email";

$submitDescription = null;

include("db_connection.php");
global $db;

//WORKING ON LOG IN
if (isset($_POST['submit-info'])) {
    $fieldError = false;

    $firstNameInput = strtolower($_POST['first-name-input']);
    $lastNameInput = strtolower($_POST['last-name-input']);
    $emailInput = $_POST['email-input'];

    include("check_basic_input.php");

    if (!$fieldError) {
        try {
            $query = $db->prepare("SELECT * FROM customer WHERE email = :email");

            $query->bindParam("email", $emailInput);

            if ($query->execute()) {
                $foundCustomer = false;
                $result = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $customer) {
                    if (strtolower($customer["first_name"]) == $firstNameInput && strtolower($customer["last_name"]) == $lastNameInput && $customer["email"] == $emailInput) {
                        $foundCustomer = true;
                        $_SESSION['customer-info'] = serialize([$customer["first_name"], $customer["last_name"], $customer["email"],
                            $customer["address"], $customer["postal_code"], $customer["residence"]]);

                        $submitDescription = "Het formulier is verzonden!<br>";

                        header("Location: http://localhost/sd22-p5-projectzuzu-Ta1Vos/order_overview.php");
                    }
                }

                if (!$foundCustomer) {
                    $submitDescription = "Helaas hebben wij uw gegevens niet kunnen vinden! Heeft u al een account aangemaakt?";
                }
            } else {
                $submitDescription = "Wij hebben helaas geen gegevens opgeslagen over de gegevens die u heeft ingevoerd.<br>
                   Heeft u al eens account gemaakt?";
            }
        } catch (PDOException $error) {
            die("Oh oh! Er is iets fout gegaan! Error code: " . $error->getMessage());
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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
                <h2><span class="border-end pe-3">Klantgegevens</span><span class="ps-3">Inloggen</span></h2>
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
                    <input type="<?= $emailInputType; ?>" class="form-control" name="email-input" value="<?= $emailInput; ?>">
                </div>
                <div class="error-field"><?= $submitDescription; ?></div>
                <input type="submit" class="btn btn-danger bg-red" name="submit-info" value="Inloggen">&nbsp;
                <a href="customer_info.php" class="text-danger underline">Heb je nog geen account? Klik hier om er één
                    te maken</a>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>
