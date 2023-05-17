<?php
include_once './header.php'
?>

<section class="vh-100" style="background-color: #9F8772;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="https://images.unsplash.com/photo-1587909209111-5097ee578ec3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1887&q=80" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;"/>
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form action="includes/signin-inc.php" method="post">

                                    <h2 class="fw-bold mb-3 pb-3" style="letter-spacing: 1px;">Giriş Yap</h2>

                                    <div class="form-outline mb-4">
                                        <label class="form-label d-block text-start" for="mail">
                                        <i class="bi bi-envelope-at me-2"></i>
                                            Email</label>
                                        <input type="email" id="mail" class="form-control form-control-lg" placeholder="Email adresinizi girin"/>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label d-block text-start" for="pass">
                                        <i class="bi bi-key me-2"></i>
                                            Şifre</label>
                                        <input type="password" id="pass" class="form-control form-control-lg" placeholder="Şifrenizi girin"/>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" type="submit">Giriş Yap</button>
                                    </div>

                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Hesabınız yok mu? <a href="signup.php" style="color: #393f81;"><b>Buradan kaydolun</b></a></p>

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
include_once './footer.php'
?>