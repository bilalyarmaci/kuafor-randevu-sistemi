<?php
include_once './header.php';
?>

<h1 class="fw-bold mt-5 p-3 fs-1">Kuaför Randevu Sistemi</h1>
<ul class="navigation mx-auto shadow-lg border rounded-4">
    <?php
    if (!(isset($_SESSION["userID"]) || isset($_SESSION["adminID"]))) {
        echo '<li class="rounded p-3"><a href="signin.php">Giriş Yap/Kaydol</a></li>';
    }
    ?>
    <li class="rounded p-3"><a href="#">Randevular</a></li>
    <li class="rounded p-3"><a href="./appt.php">Randevu Oluştur</a></li>
    <li class="rounded p-3"><a href="#">Randevu Güncelle</a></li>
    <li class="rounded p-3"><a href="#">Randevu Sil</a></li>
    <?php
    if (isset($_SESSION["userID"]) || isset($_SESSION["adminID"])) {
        echo '<li class="rounded p-3"><a href="./includes/signout-inc.php">Çıkış</a></li>';
    }
    ?>
</ul>


<button onclick="window.location.href='https://github.com/bilalyarmaci/kuafor-randevu-sistemi'" type="button" class="btn btn-lg btn-outline-dark position-absolute bottom-0 translate-middle">
    <i class="bi bi-github"></i> Github Kaynak Kodu
</button>

<?php
include_once './footer.php';
?>