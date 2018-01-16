<?php

require_once ('it-calendar.php');
require_once ('config.inc');
// 1. Mes y anio del POST
if (empty($_POST['incatrail_month'])) {
    $month=date("m");
} else {
    $month = $_POST['incatrail_month'];
}

if (empty($_POST['incatrail_year'])) {
    $year=date("Y");
} else {
    $year = $_POST['incatrail_year'];
}
if (empty($_POST['incatrail_lang'])) {
    $lang="en-US";
} else {
    $lang = $_POST['incatrail_lang'];
}
if (empty($_POST['incatrail_place'])) {
    $place = 1;
} else {
    $place = $_POST['incatrail_place'];
}

$availability = availabilityIncaTrail($month, $year, $place);

print  availabilityCalendar($availability,$month,$year,$lang);

?>