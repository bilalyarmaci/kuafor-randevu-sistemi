<?php
require_once './functions-inc.php';

if(!isset($_POST["email"])){
    header("Location: ../signup.php");
    exit();
}

$uName = $_POST["name"];
$uSurname = $_POST["surname"];
$uEmail = $_POST["email"];
$uPwd = $_POST["password"];
$uPwdRpt = $_POST["passwordRepeat"];

if(isEmptyInput($uName, $uEmail, $uPwd, $uPwdRpt) !== false){
    header("Location: ../signup.php?error=emptyinput");
    exit();
}
if(emailExists($connection, $uEmail) !== false){
    header("Location: ../signup.php?error=emailexists");
    exit();
}
if(noPwdsMatch($uPwd, $uPwdRpt) !== false){
    header("Location: ../signup.php?error=nopwdsmatch");
    exit();
}

createUser($connection, $uName, $uSurname, $uEmail, $uPwd);