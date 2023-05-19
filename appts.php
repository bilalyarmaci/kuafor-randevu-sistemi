<?php
include_once './header.php';
include_once './includes/functions-inc.php';

if (!(isset($_SESSION["userID"]) || isset($_SESSION["adminID"]))) {
    header("Location: ./signin.php");
    exit();
}
?>

<section class="intro">
    <div class="bg-image vh-100" style="background-color: #f5f7fa;">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-6">
                        <div class="card rounded-3">
                            <div class="card-body p-0">
                                <div class="table-responsive table-scroll text-start rounded-3" data-mdb-perfect-scrollbar="true" style="position: relative; height: 70vh">
                                    <table class="table table-striped mb-0">
                                        <thead style="background-color: #654236">
                                            <tr class="text-white fs-5">
                                                <th class="p-3" scope="col">Müşteri</th>
                                                <th class="p-3" scope="col">Tarih</th>
                                                <th class="p-3" scope="col">Saat</th>
                                                <th class="p-3 text-center" scope="col">Güncelle/Sil</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Tarih güncellemesi için hata kontrolleri
                                            if (isset($_GET["error"])) {
                                                // Başka birinin randevusu olma durumu
                                                // Bu durumda tekrar tekrar bulmaca oynamaması için kullanıcıya tüm randevuların tarihleri
                                                // için ayrıca bir buton sunulur.
                                                if ($_GET["error"] == "appttaken") { 
                                                    echo '<div class="bg-danger text-center fw-bold p-3">
                                                    <p class="fs-2 mb-1 text-light"><i class="bi bi-x-circle-fill"></i> Bu tarihte başka randevu bulunmakta. </p>
                                                    <button class="btn btn-light btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Dolu Randevuları Göster</button><br>
                                                    </div>';
                                                } // Geçmiş tarih seçme durumu 
                                                else if ($_GET["error"] == "pastdate") {
                                                    echo '<div class="bg-warning text-center fw-bold p-3">
                                                    <p class="fs-2 mb-1 text-light"><i class="bi bi-exclamation-circle-fill"></i> Geçmiş zaman seçilemez. </p>
                                                    </div>';
                                                }
                                            }
                                            // Görüntüleyen kullanıcıysa sadece kendi randevularını görebilmekte
                                            if (isset($_SESSION["userID"])) {
                                                $response = getAppt($connection, $_SESSION["userID"]);
                                                $data = mysqli_fetch_assoc($response);
                                                // Herhangi bir randevu yoksa
                                                if (!$data) {
                                                    echo '<tr><td class="p-3 text-dark fw-bold fs-4" colspan="4">Herhangi bir randevunuz bulunmamakta.</td></tr>';
                                                } else {
                                                    while ($data) {
                                                        echo '<tr>
                                                        <td class="p-3">' . $data["ad_soyad"] . '</td>
                                                        <td class="p-3">' . $data["tarih"] . '</td>
                                                        <td class="p-3">' . $data["saat"] . '</td>';
                                                        // Güncelleme/silme
                                                        echo '<td class="text-center fs-3"><a href="./makeAppt.php?updateID=' . $data["randevuID"] .
                                                            '&date=' . $data["tarih"] .
                                                            '&time=' . $data["saat"] . '">
                                                        <i title="GÜNCELLE" class="m-1 bi bi-arrow-up-circle-fill text-success"></i></a> 
                                                        <a href="./includes/deleteAppt.php?deleteID=' . $data["randevuID"] . '">
                                                        <i title="SİL" class="m-1 bi bi-x-circle-fill text-danger"></i></a></td>';
                                                        $data = mysqli_fetch_assoc($response);
                                                    }
                                                }
                                            }
                                            // Görüntüleyen yönetici ise tüm randevular yazdırılır
                                            else if (isset($_SESSION["adminID"])) {
                                                $response = getAppts($connection);
                                                $data = mysqli_fetch_assoc($response);
                                                if (!$data) {
                                                    echo '<tr><td class="p-3 text-dark fw-bold fs-4" colspan="4">Herhangi bir veri bulunmamakta.</td></tr>';
                                                } else {
                                                    while ($data) {
                                                        echo '<tr>
                                                        <td class="p-3">' . $data["ad_soyad"] . '</td>
                                                        <td class="p-3">' . $data["tarih"] . '</td>
                                                        <td class="p-3">' . $data["saat"] . '</td>';
                                                        // Güncelleme/silme
                                                        echo '<td class="text-center fs-3"><a href="./makeAppt.php?updateID=' . $data["randevuID"] .
                                                            '&date=' . $data["tarih"] .
                                                            '&time=' . $data["saat"] . '">
                                                        <i title="GÜNCELLE" class="m-1 bi bi-arrow-up-circle-fill text-success"></i></a> 
                                                        <a href="./includes/deleteAppt.php?deleteID=' . $data["randevuID"] . '">
                                                        <i title="SİL" class="m-1 bi bi-x-circle-fill text-danger"></i></a></td>';
                                                        $data = mysqli_fetch_assoc($response);
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid col-6 mx-auto">
                            <button class="btn btn-dark btn-lg mt-3" onclick="window.location.href='./index.php'" type="button">Geri</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tüm randevuların tarihlerini gösteren modal -->
<div class="modal modal-sm fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Rezerve Edilenler</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped mb-0">
                        <!-- Tablo -->
                        <?php
                        $response = getAppts($connection);
                        $data = mysqli_fetch_assoc($response);
                        if (!$data) {
                            echo '<tr><td class="p-3 text-dark fw-bold fs-4" colspan="4">Herhangi bir veri bulunmamakta.</td></tr>';
                        } else {
                            while ($data) {
                                // Geçmiş tarihler görüntülenmez
                                if($data["tarih"] >= date('Y-m-d')&&$data["saat"] > $TR_Time ){
                                    echo '<tr>
                                    <td class="p-3">' . $data["tarih"] . '</td>
                                    <td class="p-3">' . $data["saat"] . '</td>';
                                }
                                $data = mysqli_fetch_assoc($response);
                            }
                        }
                        ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mx-auto btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once './footer.php';
?>