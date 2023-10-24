<?php

$openTime = null;
$opened = false;

$currentHour = date("G");
$currentDay = date("w");
$dateToday = date("j F Y");
$currentMinute = date("i");

//Starts at sunday(0), ends at saturday(6)
$openTimes = [[12, 21, "Zondag"], [false, false, "Maandag"], [false, false, "Dinsdag"],
    [16, 20, "Woensdag"], [16, 20, "Donderdag"], [15, 21, "Vrijdag"], [12, 21, "Zaterdag"]];

if ($openTimes[$currentDay][0]) {
    $openTime = number_format((float)$openTimes[$currentDay][0], 2, ".")  . "-" . number_format((float)$openTimes[$currentDay][1], 2, ".");
} else {
    $openTime = "Gesloten";
}

if ($currentHour >= 18) {
    $greeting = "Goedenavond";
} else if ($currentHour >= 12) {
    $greeting = "Goedemiddag";
} else if ($currentHour >= 6) {
    $greeting = "Goedemorgen";
} else {
    $greeting = "Goedenacht";
}

if ($currentHour + 1 >= 24) {
    $currentHour -= 23;
} else {
    $currentHour++;
}

if ($currentHour > $openTimes[$currentDay][0] && $currentHour < $openTimes[$currentDay][1]) {
    $deliveryStatus = "$currentHour:$currentMinute";
}

$currentOpenTime = "{$openTimes[$currentDay][2]}; $openTime";

if ($openTimes[$currentDay][0] && $openTimes[$currentDay][1]) {
    $opened = true;
}