<?php 
include_once './functions-inc.php';
// Kontroller
session_start();
if (!(isset($_SESSION["userID"]) || isset($_SESSION["adminID"]))) {
    header("Location: ../signin.php?");
    exit();
}
if(!isset($_GET["deleteID"])){
    header("Location: ../index.php");
    exit();
}
if(!intval($_GET["deleteID"])){
    header("Location: ../index.php");
    exit();
}

deleteAppt($connection, $_GET["deleteID"]);