<?php
include_once './header.php';
?>

<h1 class="fw-bold mt-5 p-3 pt-5 fs-1">Kuaför Randevu Sistemi</h1>
<ul class="navigation mx-auto shadow-lg border rounded-4">
    <a href="./appts.php">
        <li class="rounded p-3">Randevular</li>
    </a>
    <a href="./makeAppt.php">
        <li class="rounded p-3">Randevu Oluştur</li>
    </a>
    <?php
    if (!(isset($_SESSION["userID"]) || isset($_SESSION["adminID"]))) {
        echo '<a href="signin.php"><li class="rounded p-3">Giriş Yap/Kaydol</li></a>';
    } else {
        echo '<a href="./includes/signout-inc.php"><li class="rounded p-3">Çıkış</li></a>';
    }
    ?>
</ul>

<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] === 'stmtfail') {
        echo '<div class="m-5"><span class="p-4 bg-danger card fs-1 d-inline text-dark fw-bold">Failed to ceonnect to the database!</span></div>';
    }
}
?>


<button onclick="window.location.href='https://github.com/bilalyarmaci/kuafor-randevu-sistemi'" type="button" class="btn btn-lg btn-outline-dark position-absolute bottom-0 translate-middle">
    <i class="bi bi-github"></i> Github Kaynak Kodu
</button>

<?php
include_once './footer.php';
?>