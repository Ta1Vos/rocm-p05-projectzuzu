<?php
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