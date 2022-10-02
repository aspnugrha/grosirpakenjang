<div class="wrapper">

    <aside class="left-sidebar sidebar-dark" id="left-sidebar">
        <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Aplication Brand -->
            <div class="app-brand">
                <a href="/a/dashboard">
                    Grosir Pak Enjang
                </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-left" data-simplebar style="height: 100%;">
                <!-- sidebar menu -->
                <ul class="nav sidebar-inner" id="sidebar-menu">
                    <li class="<?= ($menu == 'dashboard' ? 'active' : 'has-sub') ?>">
                        <a class="sidenav-item-link" href="/a/dashboard">
                            <i class="mdi mdi-briefcase-account-outline"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="section-title">
                        Master
                    </li>
                    <li class="<?= ($menu == 'data_master' ? 'has-sub active expand' : 'has-sub') ?>">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#data-master" aria-expanded="false" aria-controls="email">
                            <i class="mdi mdi-email"></i>
                            <span class="nav-text">Data Master</span> <b class="caret"></b>
                        </a>
                        <ul class="collapse <?= ($menu == 'data_master' ? 'show' : '') ?>" id="data-master" data-parent="#sidebar-menu">
                            <div class="sub-menu">
                                <?php if (session()->get('role') == 'superadmin') { ?>
                                    <li class="<?= ($submenu == 'user' ? 'active' : '') ?>">
                                        <a class="sidenav-item-link" href="/a/data_master/user">
                                            <span class="nav-text">User</span>

                                        </a>
                                    </li>
                                <?php } ?>
                                <li class="<?= ($submenu == 'jenis_barang' ? 'active' : '') ?>">
                                    <a class="sidenav-item-link" href="/a/data_master/jenis_barang">
                                        <span class="nav-text">Jenis Barang</span>

                                    </a>
                                </li>
                                <li class="<?= ($submenu == 'barang' ? 'active' : '') ?>">
                                    <a class="sidenav-item-link" href="/a/data_master/barang">
                                        <span class="nav-text">Barang</span>

                                    </a>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <li class="section-title">
                        Pembandingan
                    </li>
                    <li class="<?= ($menu == 'bandingkan' ? 'active' : 'has-sub') ?>">
                        <a class="sidenav-item-link" href="/a/bandingkan">
                            <i class="mdi mdi-briefcase-account-outline"></i>
                            <span class="nav-text">Bandingkan</span>
                        </a>
                    </li>
                    <li class="section-title">
                        Penjualan & Transaksi
                    </li>
                    <li class="<?= ($menu == 'penjualan' ? 'has-sub active expand' : 'has-sub') ?>">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#penjualan" aria-expanded="false" aria-controls="email">
                            <i class="mdi mdi-email"></i>
                            <span class="nav-text">Penjualan</span> <b class="caret"></b>
                        </a>
                        <ul class="collapse <?= ($menu == 'penjualan' ? 'show' : '') ?>" id="penjualan" data-parent="#sidebar-menu">
                            <div class="sub-menu">
                                <li class="<?= ($submenu == 'cek_pesanan' ? 'active' : '') ?>">
                                    <a class="sidenav-item-link" href="/a/penjualan/cek_pesanan">
                                        <span class="nav-text">Cek Pesanan</span>

                                    </a>
                                </li>
                                <li class="<?= ($submenu == 'pesanan' ? 'active' : '') ?>">
                                    <a class="sidenav-item-link" href="/a/penjualan/pesanan">
                                        <span class="nav-text">Pesanan</span>

                                    </a>
                                </li>
                                <li class="<?= ($submenu == 'pengambilan' ? 'active' : '') ?>">
                                    <a class="sidenav-item-link" href="/a/penjualan/pengambilan">
                                        <span class="nav-text">Pengambilan</span>

                                    </a>
                                </li>
                                <li class="<?= ($submenu == 'selesai' ? 'active' : '') ?>">
                                    <a class="sidenav-item-link" href="/a/penjualan/selesai">
                                        <span class="nav-text">Selesai</span>

                                    </a>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <!-- <li class="section-title">
                        Laporan
                    </li>
                    <li class="<?= ($menu == 'laporan' ? 'active' : 'has-sub') ?>">
                        <a class="sidenav-item-link" href="/a/laporan">
                            <i class="mdi mdi-briefcase-account-outline"></i>
                            <span class="nav-text">Laporan</span>
                        </a>
                    </li> -->
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

                <span class="page-title"><?= $title ?></span>

                <div class="navbar-right ">
                    <ul class="nav navbar-nav">
                        <!-- User Account -->
                        <li class="dropdown user-menu">
                            <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <span class="d-none d-lg-inline-block"><?= session()->get('email') ?></span>
                                <?php if (session()->get('profile') != null) { ?>
                                    <img src="images/user/user-xs-01.jpg" class="user-image rounded-circle" />
                                <?php } else { ?>
                                    <i class="mdi mdi-account-circle-outline"></i>
                                <?php } ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <!-- <li>
                                    <a class="dropdown-link-item" href="/a/account/profile">
                                        <i class="mdi mdi-account-outline"></i>
                                        <span class="nav-text">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-link-item" href="/a/account/settings">
                                        <i class="mdi mdi-settings"></i>
                                        <span class="nav-text">Account Setting</span>
                                    </a>
                                </li> -->

                                <li class="dropdown-footer">
                                    <a class="dropdown-link-item" href="/logout"><i class="mdi mdi-logout"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>


        </header>