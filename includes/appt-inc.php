<?php
include_once './functions-inc.php';
session_start();
if(isset($_SESSION["adminID"])){
    header("Location: ../appt.php?error=noadmappt");
    exit();
}

if(!isset($_POST["date"])){
    header("Location: ../appt.php");
    exit();
}

$uID = $_SESSION["userID"];
$apptDate = $_POST["date"];
$apptHour = $_POST["time"];

$date = date('Y-m-d', strtotime($apptDate));
$time = date('H:i', strtotime($apptHour));

if(isApptTaken($connection, $date, $time) !== false){
    header("Location: ../appt.php?error=appttaken");
    exit();
}

saveAppt($connection, $uID, $date, $time);