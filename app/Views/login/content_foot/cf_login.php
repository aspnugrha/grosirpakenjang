<script>
    var base_url = '<?= base_url() ?>';
    $(document).ready(function() {
        clear_form('login');
        clear_form('register');
        clear_form('lupa-password');
        show_div('login');

        // register
        var reg_nama = document.getElementById("reg_nama");
        reg_nama.addEventListener("keydown", function(e) {
            if (e.code === "Enter") {
                cek_register();
            }
        });
        var reg_email = document.getElementById("reg_email");
        reg_email.addEventListener("keydown", function(e) {
            if (e.code === "Enter") {
                cek_register();
            }
        });
        var reg_password = document.getElementById("reg_password");
        reg_password.addEventListener("keydown", function(e) {
            if (e.code === "Enter") {
                cek_register();
            }
        });
        var reg_cpassword = document.getElementById("reg_cpassword");
        reg_cpassword.addEventListener("keydown", function(e) {
            if (e.code === "Enter") {
                cek_register();
            }
        });

        // login
        var email = document.getElementById("email");
        email.addEventListener("keydown", function(e) {
            if (e.code === "Enter") {
                cek_login();
            }
        });
        var password = document.getElementById("password");
        password.addEventListener("keydown", function(e) {
            if (e.code === "Enter") {
                cek_login();
            }
        });
    });

    function show_div(kondisi) {
        if (kondisi == 'login') {
            $('#div-login').show();
            $('#div-register').hide();
            $('#div-lupa-password').hide();
            $('#div-aktivasi').hide();
        } else if (kondisi == 'register') {
            $('#div-login').hide();
            $('#div-register').show();
            $('#div-lupa-password').hide();
            $('#div-aktivasi').hide();
        } else if (kondisi == 'lupa-password') {
            $('#div-login').hide();
            $('#div-register').hide();
            $('#div-lupa-password').show();
            $('#div-aktivasi').hide();
            show_lupa_password('kirim_email_lp');
        } else if (kondisi == 'aktivasi') {
            $('#div-login').hide();
            $('#div-register').hide();
            $('#div-lupa-password').hide();
            $('#div-aktivasi').show();
            show_aktivasi('kirim_email_aktivasi');
        }
    }

    function clear_form(kondisi) {
        if (kondisi == 'login') {
            $('#email').val('');
            $('#password').val('');
            document.getElementById('email').classList.remove('is-invalid');
            document.getElementById('password').classList.remove('is-invalid');
        } else if (kondisi == 'register') {
            $('#reg_nama').val('');
            $('#reg_email').val('');
            $('#reg_password').val('');
            $('#reg_cpassword').val('');
            document.getElementById('reg_nama').classList.remove('is-invalid');
            document.getElementById('reg_email').classList.remove('is-invalid');
            document.getElementById('reg_password').classList.remove('is-invalid');
            document.getElementById('reg_cpassword').classList.remove('is-invalid');
        } else if (kondisi == 'lupa-password') {

        } else {

        }
    }

    function show_password(kondisi) {
        if (kondisi == 'login') {
            var pass = document.getElementById("password");

            if (pass.type === "password") {
                pass.type = "text";
            } else {
                pass.type = "password";
            }
        } else if (kondisi == 'register') {
            var reg_password = document.getElementById("reg_password");
            var reg_cpassword = document.getElementById("reg_cpassword");

            if (reg_password.type === "password") {
                reg_password.type = "text";
            } else {
                reg_password.type = "password";
            }
            if (reg_cpassword.type === "password") {
                reg_cpassword.type = "text";
            } else {
                reg_cpassword.type = "password";
            }
        }
    }

    function show_aktivasi(kondisi) {
        if (kondisi == 'kirim_email_aktivasi') {
            $('#div-kirim-aktivasi-email').show();
            $('#div-kirim-kode-aktivasi').hide();
        } else {
            $('#div-kirim-aktivasi-email').hide();
            $('#div-kirim-kode-aktivasi').show();
        }
    }

    function show_lupa_password(kondisi) {
        if (kondisi == 'kirim_email_lp') {
            $('#div-kirim-kode-aktivasi-lp').show();
            $('#div-kirim-aktivasi-lp').hide();
            $('#div-set-new-password').hide();
        } else if (kondisi == 'kirim_aktivasi_lp') {
            $('#div-kirim-kode-aktivasi-lp').hide();
            $('#div-kirim-aktivasi-lp').show();
            $('#div-set-new-password').hide();
        } else if (kondisi == 'create_new_password') {
            $('#div-kirim-kode-aktivasi-lp').hide();
            $('#div-kirim-aktivasi-lp').hide();
            $('#div-set-new-password').show();
        }
    }


    // login
    function cek_login() {
        var email = $('#email').val();
        var password = $('#password').val();

        if (email != '' && password != '') {
            if (check_email_format(email)) {
                $('#if-email-login').html('');
                document.getElementById('email').classList.remove('is-invalid');
                document.getElementById('password').classList.remove('is-invalid');
                login();
            } else {
                $('#if-email-login').html('Format Email tidak sesuai');
                document.getElementById('email').classList.add('is-invalid');
            }
        } else {
            if (email == '') {
                document.getElementById('email').classList.add('is-invalid');
            } else {
                document.getElementById('email').classList.remove('is-invalid');
            }
            if (password == '') {
                document.getElementById('password').classList.add('is-invalid');
            } else {
                document.getElementById('password').classList.remove('is-invalid');
            }
        }
    }

    function login() {
        $.ajax({
            type: "POST",
            url: base_url + '/login',
            data: $('#form-login').serialize(),
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                document.getElementById('btn-login').classList.add('a-disabled');
                $('#btn-login').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function(res) {
                console.log(res);
                if (res.status == "success") {
                    $('#if-email-login').html('');
                    $('#if-password-login').html('');
                    document.getElementById('email').classList.remove('is-invalid');
                    document.getElementById('password').classList.remove('is-invalid');

                    clear_form('login');
                    show_toastr('Login berhasil!', 'success', 'top-center');
                    if (res.role == 'superadmin') {
                        setTimeout(() => {
                            window.location = base_url + '/a/dashboard';
                        }, 500);
                    } else if (res.role == 'admin') {
                        setTimeout(() => {
                            window.location = base_url + '/a/dashboard';
                        }, 500);
                    } else {
                        setTimeout(() => {
                            window.location = base_url + '/';
                        }, 500);
                    }
                } else if (res.status == 'email_belum_terdaftar') {
                    $('#if-email-login').html('Email belum terdaftar! Silahkan Registrasi terlebih dahulu!');
                    $('#if-password-login').html('');
                    document.getElementById('email').classList.add('is-invalid');
                    document.getElementById('password').classList.add('is-invalid');

                    $('#password').val('');
                    show_toastr('Email tersebut belum terdaftar!', 'error', 'top-center');
                } else if (res.status == 'gagal') {
                    $('#if-email-login').html('');
                    $('#if-password-login').html('');
                    document.getElementById('email').classList.add('is-invalid');
                    document.getElementById('password').classList.add('is-invalid');
                    $('#password').val('');
                    show_toastr('Email dan password salah!', 'error', 'top-center');
                } else if (res.status == 'belum_aktivasi') {
                    $('#if-email-login').html('');
                    $('#if-password-login').html('');
                    document.getElementById('email').classList.add('is-invalid');
                    document.getElementById('password').classList.add('is-invalid');
                    $('#password').val('');
                    show_toastr('Akun tersebut belum diaktivasi!', 'error', 'top-center');
                }
            },
            complete: function() {
                document.getElementById('btn-login').classList.remove('a-disabled');
                $('#btn-login').html('Login');
            }
        });
    }


    // register
    function cek_register() {
        var reg_nama = $('#reg_nama').val();
        var reg_email = $('#reg_email').val();
        var reg_password = $('#reg_password').val();
        var reg_cpassword = $('#reg_cpassword').val();

        if (reg_nama != '' && reg_email != '' && reg_password != '' && reg_cpassword != '') {
            document.getElementById('reg_nama').classList.remove('is-invalid');
            document.getElementById('reg_email').classList.remove('is-invalid');
            document.getElementById('reg_password').classList.remove('is-invalid');
            document.getElementById('reg_cpassword').classList.remove('is-invalid');

            if (check_email_format(reg_email) === true) {

                if (reg_password == reg_cpassword) {
                    if (reg_password.length > 4 && reg_cpassword.length > 4) {
                        document.getElementById('reg_password').classList.remove('is-invalid');
                        document.getElementById('reg_cpassword').classList.remove('is-invalid');
                        register();
                    } else {
                        if (reg_password.length > 4) {
                            document.getElementById('reg_password').classList.remove('is-invalid');
                        } else {
                            $('#if-reg-password').html('Password setidaknya terdiri dari 5 karakter');
                            document.getElementById('reg_password').classList.add('is-invalid');
                        }
                        if (reg_password.length > 4) {
                            document.getElementById('reg_cpassword').classList.remove('is-invalid');
                        } else {
                            $('#if-reg-cpassword').html('Confirm Password setidaknya terdiri dari 5 karakter');
                            document.getElementById('reg_cpassword').classList.add('is-invalid');
                        }
                    }
                } else {
                    document.getElementById('reg_password').classList.add('is-invalid');
                    document.getElementById('reg_cpassword').classList.add('is-invalid');
                    $('#if-reg-cpassword').html('Password dan Confirm Password tidak sama');
                }
            } else {
                $('#if-reg-email').html('Format Email tidak sesuai');
                document.getElementById('reg_email').classList.add('is-invalid');
            }
        } else {
            if (reg_nama == '') {
                document.getElementById('reg_nama').classList.add('is-invalid');
            } else {
                document.getElementById('reg_nama').classList.remove('is-invalid');
            }
            if (reg_email == '') {
                $('#if-reg-email').html('Email tidak boleh kosong');
                document.getElementById('reg_email').classList.add('is-invalid');
            } else {
                document.getElementById('reg_email').classList.remove('is-invalid');
            }
            if (reg_password == '') {
                $('#if-reg-password').html('Password tidak boleh kosong');
                document.getElementById('reg_password').classList.add('is-invalid');
            } else {
                document.getElementById('reg_password').classList.remove('is-invalid');
            }
            if (reg_cpassword == '') {
                $('#if-reg-cpassword').html('Confirm Password tidak boleh kosong');
                document.getElementById('reg_cpassword').classList.add('is-invalid');
            } else {
                document.getElementById('reg_cpassword').classList.remove('is-invalid');
            }
        }
    }

    function register() {
        var reg_nama = $('#reg_nama').val();
        var reg_email = $('#reg_email').val();
        var reg_password = $('#reg_password').val();
        var reg_cpassword = $('#reg_cpassword').val();

        $.ajax({
            type: "POST",
            url: base_url + '/register',
            data: $('#form-register').serialize(),
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                document.getElementById('btn-register-akun').classList.add('a-disabled');
                $('#btn-register-akun').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function(res) {
                if (res == "success") {
                    show_div('login');
                    clear_form('register');
                    clear_form('login');
                    show_toastr('Akun berhasil dibuat!', 'success', 'top-center');
                } else {
                    show_toastr('Email tersebut sudah dipakai!', 'error', 'top-center');
                }
            },
            complete: function() {
                document.getElementById('btn-register-akun').classList.remove('a-disabled');
                $('#btn-register-akun').html('Register');
            }
        });
    }

    // aktivasi
    function kirim_kode_aktivasi(kondisi) {
        if (kondisi == 'aktivasi') {
            var email = $('#email_aktivasi').val();
        } else if (kondisi == 'lupa_password') {
            var email = $('#forgot_email').val();
        }
        $.ajax({
            type: "POST",
            url: base_url + '/aktivasi/kirim_kode',
            data: {
                email: email,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                if (kondisi == 'aktivasi') {
                    document.getElementById('btn-kirim-kode').classList.add('a-disabled');
                    $('#btn-kirim-kode').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
                } else if (kondisi == 'lupa_password') {
                    document.getElementById('btn-kirim-kode-lp').classList.add('a-disabled');
                    $('#btn-kirim-kode-lp').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
                }
            },
            success: function(res) {
                if (res == 'success') {
                    show_toastr('Kode aktivasi berhasil dikirim!', 'success', 'top-center');

                    if (kondisi == 'aktivasi') {
                        show_aktivasi('kirim_kode_aktivasi');
                    } else if (kondisi == 'lupa_password') {
                        show_lupa_password('kirim_aktivasi_lp');
                    }
                } else if (res == 'email_tidak_ditemukan') {
                    show_toastr('Email tidak ditemukan!', 'error', 'top-center');
                } else {
                    show_toastr('Gagal mengirim kode aktivasi! Periksa koneksi internet anda.', 'error', 'top-center');
                }
            },
            complete: function() {
                if (kondisi == 'aktivasi') {
                    document.getElementById('btn-kirim-kode').classList.remove('a-disabled');
                    $('#btn-kirim-kode').html('Kirim Kode');
                } else if (kondisi == 'lupa_password') {
                    document.getElementById('btn-kirim-kode-lp').classList.remove('a-disabled');
                    $('#btn-kirim-kode-lp').html('Kirim Kode');
                }
            }
        });
    }

    function cek_aktivasi(kondisi) {
        if (kondisi == 'aktivasi') {
            var kode = $('#kode_aktivasi').val();
        } else if (kondisi == 'lupa_password') {
            var kode = $('#forgot_kode_aktivasi').val();
        }

        if (kode.length == 6) {
            aktivasi(kondisi);
        } else {
            show_toastr('Kode aktivasi hanya 6 digit!', 'error', 'top-center');
        }
    }

    function aktivasi(kondisi) {
        if (kondisi == 'aktivasi') {
            var email = $('#email_aktivasi').val();
            var kode = $('#kode_aktivasi').val();
        } else if (kondisi == 'lupa_password') {
            var email = $('#forgot_email').val();
            var kode = $('#forgot_kode_aktivasi').val();
        }

        $.ajax({
            type: "POST",
            url: base_url + '/aktivasi/aktivasi',
            data: {
                email: email,
                kode: kode,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                if (kondisi == 'aktivasi') {
                    document.getElementById('btn-aktivasi').classList.add('a-disabled');
                    $('#btn-aktivasi').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
                } else if (kondisi == 'Lupa_password') {
                    document.getElementById('btn-aktivasi-lp').classList.add('a-disabled');
                    $('#btn-aktivasi-lp').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
                }
            },
            success: function(res) {
                if (res == 'success') {
                    show_toastr('Akun berhasil diaktivasi!', 'success', 'top-center');

                    if (kondisi == 'aktivasi') {
                        show_div('login');
                    } else if (kondisi == 'lupa_password') {
                        show_lupa_password('create_new_password');
                    }
                } else {
                    show_toastr('Kode Aktivasi salah!', 'error', 'top-center');
                }
            },
            complete: function() {
                if (kondisi == 'aktivasi') {
                    document.getElementById('btn-aktivasi').classList.remove('a-disabled');
                    $('#btn-aktivasi').html('Aktivasi');
                } else if (kondisi == 'lupa_password') {
                    document.getElementById('btn-aktivasi-lp').classList.remove('a-disabled');
                    $('#btn-aktivasi-lp').html('Aktivasi');
                }
            }
        });
    }

    // new pass
    function cek_new_pass() {
        var new_pass = $('#new_pass').val();
        var new_cpass = $('#new_cpass').val();

        if (new_pass != '' && new_cpass != '') {
            if (new_pass == new_cpass) {
                if (new_pass.length > 4 && new_cpass.length > 4) {
                    $('#if-new-pass').html("");
                    $('#if-new-cpass').html("");
                    document.getElementById('new_pass').classList.remove('is-invalid');
                    document.getElementById('new_cpass').classList.remove('is-invalid');
                    create_new_pass();
                } else {
                    $('#if-new-pass').html("New password setidaknya terdiri dari 5 karakter.");
                    $('#if-new-cpass').html("Confirm password setidaknya terdiri dari 5 karakter.");
                    document.getElementById('new_pass').classList.add('is-invalid');
                    document.getElementById('new_cpass').classList.add('is-invalid');
                }
            } else {
                $('#if-new-cpass').html('Password dan Confirm Password tidak sama');
                document.getElementById('new_cpass').classList.add('is-invalid');
            }
        } else {
            if (new_pass == '') {
                $('#if-new-pass').html("New password can't be null.");
                document.getElementById('new_pass').classList.add('is-invalid');
            } else {
                $('#if-new-pass').html("");
                document.getElementById('new_pass').classList.remove('is-invalid');
            }
            if (new_cpass == '') {
                $('#if-new-cpass').html("Confirm password can't be null.");
                document.getElementById('new_cpass').classList.add('is-invalid');
            } else {
                $('#if-new-cpass').html("");
                document.getElementById('new_cpass').classList.remove('is-invalid');
            }
        }
    }

    function create_new_pass() {
        var email = $('#forgot_email').val();
        var new_pass = $('#new_pass').val();

        $.ajax({
            type: "POST",
            url: base_url + '/lupa_password/create_new_pass',
            data: {
                email: email,
                pass: new_pass,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                document.getElementById('btn-new-pass').classList.add('a-disabled');
                $('#btn-new-pass').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function(res) {
                if (res == 'success') {
                    show_toastr('Akun berhasil diaktivasi!', 'success', 'top-center');
                    show_div('login');
                }
            },
            complete: function() {
                document.getElementById('btn-new-pass').classList.remove('a-disabled');
                $('#btn-new-pass').html('Simpan Password');
            }
        });
    }
</script>