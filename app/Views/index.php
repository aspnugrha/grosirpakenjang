<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Dashboard | Grosir Pak Enjang</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
    <link href="/assets/template/admin/plugins/material/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="/assets/template/admin/plugins/simplebar/simplebar.css" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="/assets/template/admin/plugins/nprogress/nprogress.css" rel="stylesheet" />

    <link href="/assets/template/admin/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" />

    <link href="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />

    <link href="/assets/template/admin/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <link href="/assets/template/admin/plugins/toaster/toastr.min.css" rel="stylesheet" />

    <!-- MONO CSS -->
    <link id="main-css-href" rel="stylesheet" href="/assets/template/admin/css/style.css" />

    <!-- FAVICON -->
    <link href="/assets/template/admin/images/favicon.png" rel="shortcut icon" />

    <script src="/assets/template/admin/plugins/nprogress/nprogress.js"></script>
</head>


<body class="navbar-fixed sidebar-fixed" id="body">
    <!-- <script>
        NProgress.configure({
            showSpinner: false
        });
        NProgress.start();
    </script> -->


    <div id="toaster"></div>


    <!-- ====================================
    ——— WRAPPER
    ===================================== -->
    <div class="wrapper">


        <!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->
        <aside class="left-sidebar sidebar-dark" id="left-sidebar">
            <div id="sidebar" class="sidebar sidebar-with-footer">
                <!-- Aplication Brand -->
                <div class="app-brand">
                    <a href="/index.html">
                        Grosir Pak Enjang
                    </a>
                </div>
                <!-- begin sidebar scrollbar -->
                <div class="sidebar-left" data-simplebar style="height: 100%;">
                    <!-- sidebar menu -->
                    <ul class="nav sidebar-inner" id="sidebar-menu">
                        <li class="active">
                            <a class="sidenav-item-link" href="index.html">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="section-title">
                            Master
                        </li>
                        <li class="has-sub">
                            <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#email" aria-expanded="false" aria-controls="email">
                                <i class="mdi mdi-email"></i>
                                <span class="nav-text">Data Master</span> <b class="caret"></b>
                            </a>
                            <ul class="collapse" id="email" data-parent="#sidebar-menu">
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="email-inbox.html">
                                            <span class="nav-text">User</span>

                                        </a>
                                    </li>
                                    <li>
                                        <a class="sidenav-item-link" href="email-details.html">
                                            <span class="nav-text">Barang</span>

                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                        <li class="section-title">
                            Pembandingan
                        </li>
                        <li class="active">
                            <a class="sidenav-item-link" href="index.html">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Bandingkan</span>
                            </a>
                        </li>
                        <li class="section-title">
                            Laporan
                        </li>
                        <li class="active">
                            <a class="sidenav-item-link" href="index.html">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Laporan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>



        <!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
        <div class="page-wrapper">

            <!-- Header -->
            <header class="main-header" id="header">
                <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
                    <!-- Sidebar toggle button -->
                    <button id="sidebar-toggler" class="sidebar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                    </button>

                    <span class="page-title">dashboard</span>

                    <div class="navbar-right ">
                        <ul class="nav navbar-nav">
                            <!-- User Account -->
                            <li class="dropdown user-menu">
                                <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <img src="images/user/user-xs-01.jpg" class="user-image rounded-circle" alt="User Image" />
                                    <span class="d-none d-lg-inline-block"><?= session()->get('email') ?></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-link-item" href="user-profile.html">
                                            <i class="mdi mdi-account-outline"></i>
                                            <span class="nav-text">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-link-item" href="user-account-settings.html">
                                            <i class="mdi mdi-settings"></i>
                                            <span class="nav-text">Account Setting</span>
                                        </a>
                                    </li>

                                    <li class="dropdown-footer">
                                        <a class="dropdown-link-item" href="sign-in.html"> <i class="mdi mdi-logout"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>


            </header>

            <!-- ====================================
        ——— CONTENT WRAPPER
        ===================================== -->
            <div class="content-wrapper">
                <div class="content">

                </div>
            </div>

            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="copyright bg-white">
                    <p>
                        &copy; <span id="copy-year"></span> Copyright Mono Dashboard Bootstrap Template by <a class="text-primary" href="http://www.iamabdus.com/" target="_blank">Abdus</a>.
                    </p>
                </div>
                <script>
                    var d = new Date();
                    var year = d.getFullYear();
                    document.getElementById("copy-year").innerHTML = year;
                </script>
            </footer>

        </div>
    </div>

    <!-- Card Offcanvas -->
    <div class="card card-offcanvas" id="contact-off">
        <div class="card-header">
            <h2>Contacts</h2>
            <a href="#" class="btn btn-primary btn-pill px-4">Add New</a>
        </div>
        <div class="card-body">

            <div class="mb-4">
                <input type="text" class="form-control form-control-lg form-control-secondary rounded-0" placeholder="Search contacts...">
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="images/user/user-sm-01.jpg" alt="User Image">
                        <span class="active bg-primary"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Selena Wagner</span>
                        <span class="discribe">Designer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="images/user/user-sm-02.jpg" alt="User Image">
                        <span class="active bg-primary"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Walter Reuter</span>
                        <span>Developer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="images/user/user-sm-03.jpg" alt="User Image">
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Larissa Gebhardt</span>
                        <span>Cyber Punk</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="images/user/user-sm-04.jpg" alt="User Image">
                    </a>

                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Albrecht Straub</span>
                        <span>Photographer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="images/user/user-sm-05.jpg" alt="User Image">
                        <span class="active bg-danger"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Leopold Ebert</span>
                        <span>Fashion Designer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="images/user/user-sm-06.jpg" alt="User Image">
                        <span class="active bg-primary"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Selena Wagner</span>
                        <span>Photographer</span>
                    </a>
                </div>
            </div>

        </div>
    </div>




    <script src="/assets/template/admin/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/template/admin/plugins/simplebar/simplebar.min.js"></script>
    <script src="/assets/template/admin/https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>



    <script src="/assets/template/admin/plugins/apexcharts/apexcharts.js"></script>



    <script src="/assets/template/admin/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>



    <script src="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
    <script src="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-us-aea.js"></script>



    <script src="/assets/template/admin/plugins/daterangepicker/moment.min.js"></script>
    <script src="/assets/template/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('input[name="dateRange"]').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    cancelLabel: 'Clear'
                }
            });
            jQuery('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
            });
            jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function(ev, picker) {
                jQuery(this).val('');
            });
        });
    </script>



    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script src="/assets/template/admin/plugins/toaster/toastr.min.js"></script>

    <script src="/assets/template/admin/js/mono.js"></script>
    <script src="/assets/template/admin/js/chart.js"></script>
    <script src="/assets/template/admin/js/map.js"></script>
    <script src="/assets/template/admin/js/custom.js"></script>

</body>

</html>