<?php
include_once './dbConnection-inc.php';

// Formdaki girişler boş mu kontrolü
function isEmptyInput($uName, $uEmail, $uPwd, $uPwdRpt){
    if(empty($uName) || empty($uEmail) || empty($uPwd) || empty($uPwdRpt)){
        return true;
    } else {
        return false;
    }
}

// İki şifre de aynı mı kontrolü
function noPwdsMatch($uPwd, $uPwdRpt){
    if($uPwd !== $uPwdRpt){
        return true;
    }
    return false;
}

// Aynı mail ile kullanıcı var mı kontrolü
function emailExists($connection, $uEmail){
    // 'SQL injection' koruması için 'prepared statement' kullanımı
    $sql = "SELECT * FROM `musteriler` WHERE `email` = ?";
    $stmt = mysqli_stmt_init($connection);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../signup.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uEmail);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    
    // Eğer bir bilgi dönmüş ise kullanıcı bilgisidir, dolayısıyla zaten veritabanında vardır
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else {
        // Müşteri değilse yönetici (admin) giriş yapıyor olabilir.
        // 'yoneticiler' tablosunda da arama yapılır.
        $adminSQL = "SELECT * FROM `yoneticiler` WHERE `email` = ?";
        $stmt = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($stmt,$adminSQL)){
            header("Location: ../signup.php?error=stmtfail");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "s", $uEmail);
        mysqli_stmt_execute($stmt);
        $resultAdminData = mysqli_stmt_get_result($stmt);
        // Eğer bilgi dönmüş ise yönetici bilgisidir
        if($rowAdmin = mysqli_fetch_assoc($resultAdminData)){
            return $rowAdmin;
        } else {
            return false;
        }
    }

    mysqli_stmt_close($stmt);
}

// Veritabanı kullanıcı kaydı
function createUser($connection, $uName, $uSurname, $uEmail, $uPwd){
    $ad_soyad = $uName . " " . $uSurname;
    // Şifreleme (hash) işlemi
    $hashedPwd = password_hash($uPwd, PASSWORD_DEFAULT);
    // 'SQL injection' koruması için 'prepared statement' kullanımı
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

// Kullanıcı girişi
function signinUser($connection, $uEmail, $uPwd){
    // Email kontrolü. Email bulunursa ilişkisel olarak geri döndürülür ve değişkene atanır.
    $emailExists = emailExists($connection, $uEmail);

    if($emailExists === false){
        header("Location: ../signin.php?error=nosuchuser");
        exit();
    }

    $hashedPwd = $emailExists["sifre"];
    
    // Şifre kontrolü
    if(password_verify($uPwd, $hashedPwd) === false){
        header("Location: ../signin.php?error=wrongpassword");
        exit();
    } else if(password_verify($uPwd, $hashedPwd) === true){
        // Şifre doğruysa oturum (session) başlatılıyor
        if(isset($emailExists["musteriID"])){   // Giriş yapan müşteriyse
            session_start();
            $_SESSION["userID"] = $emailExists["musteriID"];
            header("Location: ../main.php");
            exit();
        } else if(isset($emailExists["yoneticiID"])){   // Giriş yapan yöneticiyse
            session_start();
            $_SESSION["adminID"] = $emailExists["yoneticiID"];
            header("Location: ../main.php");
            exit();
        }
        
    }
}

// Başkasına ait randevu var mı kontrolü
function isApptTaken($connection, $date, $time){
    // 'SQL injection' koruması için 'prepared statement' kullanımı
    $sql = "SELECT * FROM `randevular` WHERE `tarih` = ? AND `saat` = ?";
    $stmt = mysqli_stmt_init($connection);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../main.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $date, $time);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

// Veritabanı randevu kaydı
function saveAppt($connection, $uID, $date, $time){
    // 'SQL injection' koruması için 'prepared statement' kullanımı
    $sql = "INSERT INTO `randevular` (`musteriID`,`tarih`,`saat`) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($connection);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../main.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $uID, $date, $time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../appt.php?error=none");
    exit();
}