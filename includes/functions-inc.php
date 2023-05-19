<?php
include_once 'dbConnection-inc.php';
// Türkiye saati ayarı
date_default_timezone_set('Turkey');
$currentDateTime = new DateTime();
$TR_Time = $currentDateTime->format('H:i');

// Formdaki girişler boş mu kontrolü
function isEmptyInput($uName, $uEmail, $uPwd, $uPwdRpt)
{
    if (empty($uName) || empty($uEmail) || empty($uPwd) || empty($uPwdRpt)) {
        return true;
    } else {
        return false;
    }
}

// İki şifre de aynı mı kontrolü
function noPwdsMatch($uPwd, $uPwdRpt)
{
    if ($uPwd !== $uPwdRpt) {
        return true;
    }
    return false;
}

// Aynı mail ile kullanıcı var mı kontrolü
function emailExists($connection, $uEmail)
{
    // 'SQL injection' koruması için 'prepared statement' kullanımı
    $sql = "SELECT * FROM `musteriler` WHERE `email` = ?";
    $stmt = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uEmail);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    // Eğer bir bilgi dönmüş ise kullanıcı bilgisidir, dolayısıyla zaten veritabanında vardır
    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        // Müşteri değilse yönetici (admin) giriş yapıyor olabilir.
        // 'yoneticiler' tablosunda da arama yapılır.
        $adminSQL = "SELECT * FROM `yoneticiler` WHERE `email` = ?";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $adminSQL)) {
            header("Location: ../signup.php?error=stmtfail");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $uEmail);
        mysqli_stmt_execute($stmt);
        $resultAdminData = mysqli_stmt_get_result($stmt);
        // Eğer bilgi dönmüş ise yönetici bilgisidir
        if ($rowAdmin = mysqli_fetch_assoc($resultAdminData)) {
            mysqli_stmt_close($stmt);
            return $rowAdmin;
        } else {
            mysqli_stmt_close($stmt);
            return false;
        }
    }
}

// Veritabanı kullanıcı kaydı
function createUser($connection, $uName, $uSurname, $uEmail, $uPwd)
{
    $ad_soyad = $uName . " " . $uSurname;
    // Şifreleme (hash) işlemi
    $hashedPwd = password_hash($uPwd, PASSWORD_DEFAULT);
    // 'SQL injection' koruması için 'prepared statement' kullanımı
    $sql = "INSERT INTO `musteriler` (`ad_soyad`,`email`,`sifre`) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
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
function signinUser($connection, $uEmail, $uPwd)
{
    // Email kontrolü. Email bulunursa ilişkisel olarak geri döndürülür ve değişkene atanır.
    $emailExists = emailExists($connection, $uEmail);

    if ($emailExists === false) {
        header("Location: ../signin.php?error=nosuchuser");
        exit();
    }

    $hashedPwd = $emailExists["sifre"];

    // Şifre kontrolü
    if (password_verify($uPwd, $hashedPwd) === false) {
        header("Location: ../signin.php?error=wrongpassword");
        exit();
    } else if (password_verify($uPwd, $hashedPwd) === true) {
        // Şifre doğruysa oturum (session) başlatılıyor
        if (isset($emailExists["musteriID"])) {   // Giriş yapan müşteriyse
            session_start();
            $_SESSION["userID"] = $emailExists["musteriID"];
            header("Location: ../index.php");
            exit();
        } else if (isset($emailExists["yoneticiID"])) {   // Giriş yapan yöneticiyse
            session_start();
            $_SESSION["adminID"] = $emailExists["yoneticiID"];
            header("Location: ../index.php");
            exit();
        }
    }
}

// Başkasına ait randevu var mı kontrolü. Varsa o randevu döndürülür.
function isApptTaken($connection, $date, $time)
{
    $sql = "SELECT * FROM `randevular` WHERE `tarih` = ? AND `saat` = ?;";
    $stmt = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $date, $time);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

// Veritabanı randevu kaydı
function makeAppt($connection, $uID, $date, $time)
{
    $sql = "INSERT INTO `randevular` (`musteriID`,`tarih`,`saat`) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $uID, $date, $time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../makeAppt.php?error=none");
    exit();
}

// Veritabanı randevu güncellemesi
function updateAppt($connection, $randevuID, $date, $time)
{
    $sql = "UPDATE `randevular` SET `tarih` = ?,`saat` = ?
    WHERE `randevular`.`randevuID` = $randevuID;";
    $stmt = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $date, $time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../makeAppt.php?error=succapptupdt");
    exit();
}

// Müşterinin ID'sine denk gelen randevuların çekilmesi
function getAppt($connection, $uID)
{
    $sql = "SELECT `randevular`.`randevuID`, `randevular`.`tarih`, `randevular`.`saat`, `musteriler`.`ad_soyad`
        FROM `randevular`
        INNER JOIN `musteriler` ON `randevular`.`musteriID` = `musteriler`.`musteriID`
        WHERE `randevular`.`musteriID` = ? AND `randevular`.`tarih` >= ?
        ORDER BY `randevular`.`tarih` ASC, `randevular`.`saat` ASC;";

    $stmt = mysqli_prepare($connection, $sql);
    $currentDate = date('Y-m-d');
    mysqli_stmt_bind_param($stmt, "ss", $uID, $currentDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_close($stmt);
    return $result;
}

// Tüm randevuların çekilmesi
function getAppts($connection, $prevAppts)
{
    // Geçmiş tarihli kayıtların çekilip çekilmeyeceği
    if ($prevAppts == false) {
        $sql = "SELECT `randevular`.`randevuID`, `randevular`.`tarih`, `randevular`.`saat`, `musteriler`.`ad_soyad`
        FROM `randevular`
        INNER JOIN `musteriler` ON `randevular`.`musteriID` = `musteriler`.`musteriID`
        WHERE `randevular`.`tarih` >= ?
        ORDER BY `randevular`.`tarih` ASC, `randevular`.`saat` ASC";
    } else {
        $sql = "SELECT `randevular`.`randevuID`, `randevular`.`tarih`, `randevular`.`saat`, `musteriler`.`ad_soyad`
        FROM `randevular`
        INNER JOIN `musteriler` ON `randevular`.`musteriID` = `musteriler`.`musteriID`
        ORDER BY `randevular`.`tarih` ASC, `randevular`.`saat` ASC";
    }

    $stmt = mysqli_prepare($connection, $sql);

    if ($prevAppts == false) {
        $currentDate = date('Y-m-d');
        mysqli_stmt_bind_param($stmt, "s", $currentDate);
    }

    mysqli_stmt_execute($stmt);
    $response = mysqli_stmt_get_result($stmt);

    if (!$response) {
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_close($stmt);
    return $response;
}


function deleteAppt($connection, $apptID)
{
    $sql = "DELETE FROM `randevular` WHERE `randevular`.`randevuID` = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if (!$stmt) {
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $apptID);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    mysqli_stmt_close($stmt);

    header("Location: ../appts.php?error=sccssfldelete");
    exit();
}
