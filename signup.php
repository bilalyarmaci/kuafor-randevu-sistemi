<?php
include_once './header.php';
if(isset($_SESSION["userID"])||isset($_SESSION["adminID"])){
    header("Location: ./index.php");
    exit();
}
?>
<!-- Section: Design Block -->
<style>
    .cascading-right {
        margin-right: -50px;
    }

    @media (max-width: 991.98px) {
        .cascading-right {
            margin-right: 0;
        }

        .barber-img {
            display: none;
        }
    }
</style>

<!-- Jumbotron -->
<div class="container py-4">
    <div class="row g-0 mt-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            ">
                <div class="card-body p-5 shadow-5 text-center">
                    <h2 class="fw-bold mb-5">Kaydol</h2>
                    <form action="./includes/signup-inc.php" method="post">
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label d-block text-start" for="ad">
                                        <i class="bi bi-person-badge-fill me-2"></i>Ad</label>
                                    <input type="text" id="ad" class="form-control" placeholder="Adınız" name="name" required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label d-block text-start" for="soyad">
                                        <i class="bi bi-person-badge me-2"></i>Soyad</label>
                                    <input type="text" id="soyad" class="form-control" placeholder="Soyadınız" name="surname" />
                                </div>
                            </div>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-block text-start" for="mail">
                                <i class="bi bi-envelope-at me-2"></i>Email</label>
                            <input type="email" id="mail" class="form-control" placeholder="Email adresiniz" name="email" required />

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-block text-start" for="pass">
                                <i class="bi bi-key-fill me-2"></i>Şifre</label>
                            <input type="password" id="pass" class="form-control" placeholder="Şifreniz" name="password" required />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label d-block text-start" for="passRepeat">
                                <i class="bi bi-key me-2"></i>Şifre Tekrar</label>
                            <input type="password" id="passRepeat" class="form-control" placeholder="Tekrar şifreniz" name="passwordRepeat" required />
                        </div>

                        <!-- Submit button -->
                        <div class="container d-grid gap-3 pt-1 mb-4 d-md-block">
                            <!-- <button class="btn btn-outline-dark btn-lg order-last me-md-3" onclick="window.location.href='./index.php'">Geri</button> -->
                            <a class="btn btn-outline-dark btn-lg order-last me-md-3" href="./index.php">Geri</a>
                            <button class="btn btn-dark btn-lg" type="submit" name="submit">Kaydol</button>
                        </div>

                    </form>
                    <!-- Hata oluşması halinde gerekli mesaj kullanıcıya iletilmekte -->
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo '<h4 class="text-danger fw-bold">Lütfen zorunlu alanları doldurunuz!</h4>';
                        } else if ($_GET["error"] == "emailexists") {
                            echo '<h4 class="text-danger fw-bold">Bu email ile zaten kayıt mevcut!</h4>';
                        } else if ($_GET["error"] == "nopwdsmatch") {
                            echo '<h4 class="text-warning fw-bold">Şifrelerin uyuştuğundan emin olun.</h4>';
                        } else if ($_GET["error"] == "stmtfail") {
                            echo '<h4 class="text-warning fw-bold">Bir hata oluştu!</h4>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
            <img src="./imgs/barber-signup.webp" class="w-100 rounded-4 shadow-4 barber-img" alt="" />
        </div>
    </div>
</div>
<!-- Jumbotron -->

<?php
include_once './footer.php';
?>