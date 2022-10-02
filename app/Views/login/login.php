<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Login | Grosir Pak Enjang</title>

        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
        <link href="/assets/template/admin/plugins/material/css/materialdesignicons.min.css" rel="stylesheet" />
        <link href="/assets/template/admin/plugins/simplebar/simplebar.css" rel="stylesheet" />
        <link href="/assets/template/admin/plugins/toaster/toastr.min.css" rel="stylesheet" />

        <!-- PLUGINS CSS STYLE -->
        <link href="/assets/template/admin/plugins/nprogress/nprogress.css" rel="stylesheet" />

        <!-- MONO CSS -->
        <link id="main-css-href" rel="stylesheet" href="/assets/template/admin/css/style.css" />

        <!-- FAVICON -->
        <link href="images/favicon.png" rel="shortcut icon" />
        <script src="/assets/template/admin/plugins/nprogress/nprogress.js"></script>
    </head>

    <style>
        .link-onclick:hover {
            cursor: pointer;
        }

        .a-disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>

</head>

<body class="bg-light-gray" id="body">
    <div class="container d-flex align-items-center justify-content-center">
        <div class="d-flex flex-column justify-content-between">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card card-default mb-0" style="width: 400px;margin-top: 60px;">
                        <div class="card-header pb-0">
                            <div class="app-brand w-100 d-flex justify-content-center border-bottom-0">
                                <a class="w-auto pl-0" href="/">
                                    Grosir Pak Enjang
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5 pt-0">

                            <div id="div-login">
                                <h4 class="text-dark mb-6 text-center">Login</h4>

                                <form id="form-login" method="post">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <input type="email" class="form-control input-lg" name="email" id="email" aria-describedby="emailHelp" placeholder="email">
                                            <div class="invalid-feedback" id="if-email-login"></div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <input type="password" class="form-control input-lg" name="password" id="password" placeholder="Password">
                                            <div class="invalid-feedback" id="if-password-login"></div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <div class="custom-control custom-checkbox mr-3 mb-3">
                                                <input type="checkbox" class="custom-control-input" id="checkShowPasswordLogin">
                                                <label class="custom-control-label" for="checkShowPasswordLogin" id="label-show-password" onclick="show_password('login')">Show Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <div class="d-flex justify-content-between mb-3">
                                                <a class="text-color link-onclick" onclick="show_div('aktivasi')"> Aktivasi Akun? </a>

                                                <a class="text-color link-onclick" onclick="show_div('lupa-password')"> Lupa password? </a>
                                            </div>

                                            <a class="btn btn-primary btn-pill mb-4" id="btn-login" onclick="cek_login()">Login</a>

                                            <p>Belum punya akun?
                                                <a class="text-blue link-onclick" onclick="show_div('register')" id="btn-register">Register</a>
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="div-register">
                                <h4 class="text-dark text-center mb-5">Register</h4>
                                <form id="form-register" method="post">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <input type="text" class="form-control input-lg" name="reg_nama" id="reg_nama" aria-describedby="nameHelp" placeholder="Name">
                                            <div class="invalid-feedback">Nama tidak boleh kosong</div>
                                        </div>
                                        <div class="form-group col-md-12 mb-4">
                                            <input type="email" class="form-control input-lg" name="reg_email" id="reg_email" aria-describedby="emailHelp" placeholder="Email">
                                            <div class="invalid-feedback" id="if-reg-email"></div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <input type="password" class="form-control input-lg" name="reg_password" id="reg_password" placeholder="Password">
                                            <div class="invalid-feedback" id="if-reg-password"></div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <input type="password" class="form-control input-lg" name="reg_cpassword" id="reg_cpassword" placeholder="Confirm Password">
                                            <div class="invalid-feedback" id="if-reg-cpassword"></div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <div class="custom-control custom-checkbox mr-3 mb-3">
                                                <input type="checkbox" class="custom-control-input" id="checkShowPassword">
                                                <label class="custom-control-label" for="checkShowPassword" id="label-show-password" onclick="show_password('register')">Show Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <a class="text-color link-onclick" onclick="show_div('aktivasi')"> Aktivasi Akun? </a>

                                            </div>

                                            <a class="btn btn-primary btn-pill mb-4" id="btn-register-akun" onclick="cek_register()">Register</a>

                                            <p>Sudah punya akun?
                                                <a class="text-blue link-onclick" onclick="show_div('login')">Login</a>
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="div-lupa-password">
                                <h4 class="text-dark mb-5">Lupa Password</h4>
                                <form id="form-lupa-password">
                                    <?= csrf_field() ?>
                                    <div id="div-kirim-kode-aktivasi-lp">
                                        <label>Masukan email yang didaftarkan, lalu kami akan mengirim kode aktivasi ke email tersebut!</label>
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-4">
                                                <input type="email" class="form-control input-lg" name="forgot_email" id="forgot_email" placeholder="Enter Email">
                                            </div>
                                            <div class="col-md-12">
                                                <a type="submit" class="btn btn-primary btn-pill mb-4" id="btn-kirim-kode-lp" onclick="kirim_kode_aktivasi('lupa_password')">Kirim Kode</a>

                                                <p>Sudah punya akun?
                                                    <a class="text-blue link-onclick" onclick="show_div('login')">Login</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div-kirim-aktivasi-lp">
                                        <label>Periksa Email anda! Kode aktivasi akun anda telah terkirim. Segera lakukan aktivasi!</label>
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-4">
                                                <input type="number" class="form-control input-lg" name="forgot_kode_aktivasi" id="forgot_kode_aktivasi" placeholder="Enter Activation Code">
                                            </div>
                                            <div class="col-md-12">
                                                <a type="submit" class="btn btn-primary btn-pill mb-4" id="btn-aktivasi-lp" onclick="cek_aktivasi('lupa_password')">Aktivasi</a>

                                                <p>Sudah punya akun?
                                                    <a class="text-blue link-onclick" onclick="show_div('login')">Login</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div-set-new-password">
                                        <label>Buat Password Baru.</label>
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-4">
                                                <input type="password" class="form-control input-lg" name="new_pass" id="new_pass" placeholder="Enter New Pass">
                                                <div class="invalid-feedback" id="if-new-pass"></div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4">
                                                <input type="password" class="form-control input-lg" name="new_cpass" id="new_cpass" placeholder="Confirm New Pass">
                                                <div class="invalid-feedback" id="if-new-cpass"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <a type="submit" class="btn btn-primary btn-pill mb-4" id="btn-new-pass" onclick="cek_new_pass()">Simpan Password</a>

                                                <p>Sudah punya akun?
                                                    <a class="text-blue link-onclick" onclick="show_div('login')">Login</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="div-aktivasi">
                                <h4 class="text-dark mb-5">Aktivasi Akun</h4>
                                <form id="form-aktivasi">
                                    <?= csrf_field() ?>
                                    <div id="div-kirim-aktivasi-email">
                                        <label>Masukan email yang didaftarkan, lalu kami akan mengirim kode aktivasi ke email tersebut!</label>
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-4">
                                                <input type="email" class="form-control input-lg" name="email_aktivasi" id="email_aktivasi" placeholder="Enter Email">
                                            </div>
                                            <div class="col-md-12">
                                                <a type="submit" class="btn btn-primary btn-pill mb-4" id="btn-kirim-kode" onclick="kirim_kode_aktivasi('aktivasi')">Kirim Kode</a>

                                                <p>Sudah punya akun?
                                                    <a class="text-blue link-onclick" onclick="show_div('login')">Login</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div-kirim-kode-aktivasi">
                                        <label>Periksa Email anda! Kode aktivasi akun anda telah terkirim. Segera lakukan aktivasi!</label>
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-4">
                                                <input type="number" class="form-control input-lg" name="kode_aktivasi" id="kode_aktivasi" placeholder="Enter Activation Code">
                                            </div>
                                            <div class="col-md-12">
                                                <a type="submit" class="btn btn-primary btn-pill mb-4" id="btn-aktivasi" onclick="cek_aktivasi('aktivasi')">Aktivasi</a>

                                                <p>Sudah punya akun?
                                                    <a class="text-blue link-onclick" onclick="show_div('login')">Login</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/template/admin/plugins/jquery/jquery.min.js"></script>

    <script src="/assets/template/admin/plugins/toaster/toastr.min.js"></script>

    <?= view('login/content_foot/cf_login') ?>
    <?= view('universal_foot/cf_email') ?>
    <?= view('universal_foot/cf_toastr') ?>

</body>

</html>