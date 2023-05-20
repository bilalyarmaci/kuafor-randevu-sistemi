<?php
include_once './functions-inc.php';

if (!isset($_POST["email"])) {
    header("Location: ../signin.php");
    exit();
}
if (isset($_SESSION["userID"])||isset($_SESSION["adminID"])) {
    header("Location: ../index.php");
    exit();
}
$uEmail = $_POST["email"];
$uPwd = $_POST["password"];

signinUser($connection, $uEmail, $uPwd);