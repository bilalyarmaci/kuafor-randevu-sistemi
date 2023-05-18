<?php
include_once './functions-inc.php';

if (!isset($_POST["submit"])) {
    header("Location: ../signin.php");
    exit();
}

$uEmail = $_POST["email"];
$uPwd = $_POST["password"];

signinUser($connection, $uEmail, $uPwd);