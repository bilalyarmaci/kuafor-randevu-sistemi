<?php
require_once './dbConnection-inc.php';

function isEmptyInput($uName, $uEmail, $uPwd, $uPwdRpt){
    if(empty($uName) || empty($uEmail) || empty($uPwd) || empty($uPwdRpt)){
        return true;
    } else {
        return false;
    }
}

function noPwdsMatch($uPwd, $uPwdRpt){
    if($uPwd !== $uPwdRpt){
        return true;
    }
    return false;
}

function emailExists($connection, $uEmail){
    // SQL injection koruması için 'prepared statement' kullanımı
    $sql = "SELECT * FROM `musteriler` WHERE `email` = ?";
    $stmt = mysqli_stmt_init($connection);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../signup.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uEmail);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else{
        return false;
    }

    mysqli_stmt_close($stmt);
}

function createUser($connection, $uName, $uSurname, $uEmail, $uPwd){
    $ad_soyad = $uName . " " . $uSurname;
    // Şifreleme (hash) işlemi
    $hashedPwd = password_hash($uPwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `musteriler` (`ad_soyad`,`email`,`sifre`) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($connection);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../signup.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $ad_soyad, $uEmail, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../signin.php?error=none");
    exit();
}