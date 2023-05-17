<?php
include_once './header.php'
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
    <div class="row g-0 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            ">
                <div class="card-body p-5 shadow-5 text-center">
                    <h2 class="fw-bold mb-5">Kayıt Ol</h2>
                    <form action="includes/signup-inc.php" method="post">
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label d-block text-start" for="ad">
                                        <i class="bi bi-person-badge-fill me-2"></i>Ad</label>
                                    <input type="text" id="ad" class="form-control" placeholder="Adınız" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label d-block text-start" for="soyad">
                                        <i class="bi bi-person-badge me-2"></i>Soyad</label>
                                    <input type="text" id="soyad" class="form-control" placeholder="Soyadınız" />
                                </div>
                            </div>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-block text-start" for="mail">
                                <i class="bi bi-envelope-at me-2"></i>Email</label>
                            <input type="email" id="mail" class="form-control" placeholder="Email adresiniz" />

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-block text-start" for="pass">
                                <i class="bi bi-key-fill me-2"></i>Şifre</label>
                            <input type="password" id="pass" class="form-control" placeholder="Şifreniz" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label d-block text-start" for="pass">
                                <i class="bi bi-key me-2"></i>Şifre Tekrar</label>
                            <input type="password" id="pass" class="form-control" placeholder="Tekrar şifreniz" />
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-lg btn-dark btn-block mb-4">
                            Kayıt ol
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
            <img src="https://images.unsplash.com/photo-1635273051427-7c2a35ce50ce?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&q=80" class="w-100 rounded-4 shadow-4 barber-img" alt="" />
        </div>
    </div>
</div>
<!-- Jumbotron -->

<?php
include_once './footer.php'
?>