<?php
include_once './header.php';
include_once './includes/functions-inc.php';

if (!(isset($_SESSION["userID"]) || isset($_SESSION["adminID"]))) {
    header("Location: ./signin.php");
    exit();
}
?>

<style>
    .bg-blur {
        background: rgba(1, 1, 1, .1);
        backdrop-filter: blur(25px);
        border: 2px solid rgba(255, 255, 255, 0.05);
        background-clip: padding-box;
        box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
    }
</style>

<section class="vh-100" style="background: url(https://images.unsplash.com/photo-1621605815971-fbc98d665033?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=3270&q=80)">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="bg-blur col col-10 col-lg-6 text-center card p-5 rounded-5">
                <?php
                if (isset($_GET["updateID"]) && isset($_GET["date"]) && isset($_GET["time"])) {
                    // Geçmiş tarih güncellenemez.
                    if ($_GET["date"] <= date('Y-m-d') && $_GET["time"] <= $TR_Time || $_GET["date"] < date('Y-m-d')) {
                        header("Location: ./appts.php?error=pastdate");
                        exit();
                    }
                    echo '<div class="bg-light mb-3 rounded p-3"><span class="fs-4 fw-bold text-warning">
                    ' . $_GET["date"] . ' ' . $_GET["time"] . '
                    tarihi yerine seçim yapın </span></div>';
                } else {
                    echo '<h2 class="fw-bold mb-4 fs-1 text-white">Randevu Oluştur</h2>';
                }
                ?>
                <form action="./includes/makeAppt-inc.php" method="POST">
                    <div class="card fs-2 px-5 rounded-3">
                        <label for="date">Tarih:</label>
                        <input type="date" id="date" name="date" required><br>
                    </div>
                    <br>
                    <div class="card fs-2 px-5 rounded-3">
                        <label for="appt">Saat:</label>
                        <input type="time" id="appt" name="time" min="08:00" max="20:00" step="1800" list="time_list" required><br>
                    </div>
                    <div class="container d-grid gap-3 pt-1 mt-4 d-md-block">
                        <button class="btn btn-outline-light btn-lg order-last me-md-3" onclick="window.location.href='./index.php'">Geri</button>
                        <?php
                        if (isset($_GET["updateID"]) && isset($_GET["date"]) && isset($_GET["time"])) {
                            echo '<input type="hidden" name="type" value="update">';
                            echo '<input type="hidden" name="updateID" value="' . $_GET["updateID"] . '">';
                            echo '<button class="btn btn-warning btn-lg fw-bold" type="submit" name="submit">Güncelle</button>';
                        } else {
                            echo '<button class="btn btn-light btn-lg" type="submit" name="submit">Randevu Al</button>';
                        }
                        ?>
                    </div>
                    <!-- Hata kontrolleri -->
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] === 'appttaken') {
                            header("Location: ./appts.php?error=appttaken");
                            exit();
                        } else if ($_GET["error"] === 'none') {
                            echo '<div class="bg-light mt-3 rounded p-3"><span class="fs-4 text-success"><i class="bi bi-check-circle-fill"></i> Randevu başarıyla oluşturuldu.</span></div>';
                        } else if ($_GET["error"] === 'succapptupdt') {
                            echo '<div class="bg-light mt-3 rounded p-3"><span class="fs-4 text-success"><i class="bi bi-check-circle-fill"></i> Randevu başarıyla güncellendi.</span></div>';
                        } else if ($_GET["error"] === 'pastdate') {
                            echo '<div class="bg-light mt-3 rounded p-3"><span class="fs-4 text-warning"><i class="bi bi-exclamation-circle-fill"></i> Geçmiş zaman seçilemez.</span></div>';
                        } else if ($_GET["error"] === 'noadmappt') {
                            echo '<div class="bg-light mt-3 rounded p-3"><span class="fs-4 text-warning"><i class="bi bi-exclamation-circle-fill"></i> Yönetici hesapla randevu oluşturulamaz.</span></div>';
                        }
                    }
                    ?>

                </form>

                <datalist id="time_list">
                    <option value="08:00">
                    <option value="08:30">
                    <option value="09:00">
                    <option value="09:30">
                    <option value="10:00">
                    <option value="10:30">
                    <option value="11:00">
                    <option value="11:30">
                    <option value="13:00">
                    <option value="13:30">
                    <option value="14:00">
                    <option value="14:30">
                    <option value="15:00">
                    <option value="15:30">
                    <option value="16:00">
                    <option value="16:30">
                    <option value="17:00">
                    <option value="17:30">
                    <option value="18:00">
                    <option value="18:30">
                    <option value="19:00">
                    <option value="19:30">
                </datalist>
            </div>
        </div>
    </div>
</section>

<script>
    // Sadece bu günden itibaren 30 gün seçilebilir
    const options = {
        timeZone: 'Europe/Istanbul'
    };
    const formatter = new Intl.DateTimeFormat(undefined, options);

    // Türkiye tarihi
    const TR_DATE = new Date();

    const date = new Date();
    let currentDate = TR_DATE.toJSON();
    let todaysDate = currentDate.slice(0, 10);
    let maxDate = new Date(new Date().setDate(new Date().getDate() + 30)).toJSON();
    let latterDate = maxDate.slice(0, 10);
    document.querySelector('#date').setAttribute("min", `${todaysDate}`);
    document.querySelector('#date').setAttribute("max", `${latterDate}`);
</script>

<?php
include_once './footer.php';
?>