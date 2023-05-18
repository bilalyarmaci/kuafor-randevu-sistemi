<?php
include_once './functions-inc.php';
session_start();
if(isset($_SESSION["adminID"])){
    header("Location: ../makeAppt.php?error=noadmappt");
    exit();
}

if(!isset($_POST["date"])){
    header("Location: ../makeAppt.php");
    exit();
}

$uID = $_SESSION["userID"];
$apptDate = $_POST["date"];
$apptHour = $_POST["time"];

$date = date('Y-m-d', strtotime($apptDate));
$time = date('H:i', strtotime($apptHour));

if(isApptTaken($connection, $date, $time) !== false){
    header("Location: ../makeAppt.php?error=appttaken");
    exit();
}

makeAppt($connection, $uID, $date, $time);