<?php
include_once './functions-inc.php';

// Güncelleme isteğinin kontrolü
if (isset($_POST["type"])) {
    if ($_POST["type"] === "update") {
        // Randevu başkası tarafından alınmıştır
        if (isApptTaken($connection, $_POST["date"], $_POST["time"]) !== false) {
            header("Location: ../appts.php?error=appttaken");
            exit();
        } // Geçmiş tarih seçilemez
        else if ($_POST["date"] <= date('Y-m-d') && $_POST["time"] <= $TR_Time) {
            header("Location: ../appts.php?error=pastdate");
            exit();
        }
        updateAppt($connection, $_POST["updateID"], $_POST["date"], $_POST["time"]);
    }
}

session_start();
if (isset($_SESSION["adminID"])) {
    header("Location: ../makeAppt.php?error=noadmappt");
    exit();
}

if (!isset($_POST["date"])) {
    header("Location: ../makeAppt.php");
    exit();
}

$uID = $_SESSION["userID"];
$apptDate = $_POST["date"];
$apptHour = $_POST["time"];

$date = date('Y-m-d', strtotime($apptDate));
$time = date('H:i', strtotime($apptHour));

if (isApptTaken($connection, $date, $time) !== false) {
    header("Location: ../makeAppt.php?error=appttaken");
    exit();
}

if($_POST["date"] <= date('Y-m-d')&& $_POST["time"] <= $TR_Time){
    header("Location: ../makeAppt.php?error=pastdate");
    exit();
}

makeAppt($connection, $uID, $date, $time);