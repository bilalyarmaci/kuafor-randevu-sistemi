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
                                        <thead style="background-color: #654236;">
                                            <tr class="text-white fs-5">
                                                <th class="p-3" scope="col">Müşteri</th>
                                                <th class="p-3" scope="col">Tarih</th>
                                                <th class="p-3" scope="col">Saat</th>
                                                <th class="p-3 text-center" scope="col">Güncelle/Sil</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
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
                                                        '&date='.$data["tarih"].
                                                        '&time='.$data["saat"].'">
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
                                                        '&date='.$data["tarih"].
                                                        '&time='.$data["saat"].'">
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

<?php
include_once './footer.php';
?>