<?php
include_once './header.php';
if (isset($_SESSION["userID"]) || isset($_SESSION["adminID"])) {
    header("Location: ./index.php");
    exit();
}
?>

<section class="vh-100" style="background-color: <?php if (isset($_GET["error"])) {
                                                        if ($_GET["error"] == "none") {
                                                            echo '#198754;';
                                                        } else {
                                                            echo '#9F8772;';
                                                        }
                                                    } else {
                                                        echo '#9F8772;';
                                                    } ?>">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="https://images.unsplash.com/photo-1587909209111-5097ee578ec3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1887&q=80" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form action="includes/signin-inc.php" method="post">

                                    <?php
                                    if (isset($_GET["error"])) {
                                        if ($_GET["error"] == "none") {
                                            echo '<h2 class="text-success fs-1 fw-bold">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Kayıt başarılı!</h2>';
                                        }
                                    }
                                    ?>

                                    <h2 class="fw-bold mb-3 pb-3" style="letter-spacing: 1px;">Giriş Yap</h2>

                                    <div class="form-outline mb-4">
                                        <label class="form-label d-block text-start" for="mail">
                                            <i class="bi bi-envelope-at me-2"></i>
                                            Email</label>
                                        <input type="email" id="mail" class="form-control form-control-lg" placeholder="Email adresinizi girin" name="email" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label d-block text-start" for="pass">
                                            <i class="bi bi-key me-2"></i>
                                            Şifre</label>
                                        <input type="password" id="pass" class="form-control form-control-lg" placeholder="Şifrenizi girin" name="password" required />
                                    </div>

                                    <div class="container d-grid gap-3 pt-1 mb-4 d-md-block">
                                        <button class="btn btn-outline-dark btn-lg order-last me-md-3" onclick="window.location.href='./index.php'">Geri</button>
                                        <button class="btn btn-dark btn-lg" type="submit" name="submit">Giriş Yap</button>
                                    </div>

                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Hesabınız yok mu? <a href="signup.php" style="color: #393f81;"><b>Buradan kaydolun</b></a></p>
                                    <?php
                                    if (isset($_GET["error"])) {
                                        if ($_GET["error"] == "nosuchuser") {
                                            echo '<h5 class="text-danger m-0 fw-bold">Böyle bir kullanıcı yok.</h5>';
                                        } else if ($_GET["error"] == "wrongpassword") {
                                            echo '<h5 class="text-danger m-0 fw-bold">Şifrenizin doğru olduğundan emin olun.</h5>';
                                        }
                                    }
                                    ?>
                                </form>

                            </div>
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