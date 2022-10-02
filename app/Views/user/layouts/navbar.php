<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light navigation">
                    <a class="navbar-brand" href="/">
                        <!-- <img src="images/logo.png" alt=""> -->
                        Grosir Pak Enjang
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto main-nav ">
                            <li class="nav-item <?= ($menu == 'home' ? 'active' : '') ?>">
                                <a class="nav-link" href="/home">Home</a>
                            </li>
                            <li class="nav-item <?= ($menu == 'bandingkan' ? 'active' : '') ?>">
                                <a class="nav-link" href="/compare">Bandingkan</a>
                            </li>
                            <li class="nav-item <?= ($menu == 'keranjang' ? 'active' : '') ?>">
                                <a class="nav-link" href="/cart">Keranjang</a>
                            </li>
                            <li class="nav-item <?= ($menu == 'pesanan' ? 'active' : '') ?>">
                                <a class="nav-link" href="/order">Pesanan</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto mt-10">
                            <?php if (!empty(session()->get('id'))) { ?>
                                <li class="nav-item <?= ($menu == 'home' ? 'active' : '') ?> dropdown dropdown-slide">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <div class="image d-flex justify-content-center">

                                            <span class="d-none d-lg-inline-block"><?= session()->get('email') ?></span>
                                            <?php if (session()->get('profile') != null) { ?>
                                                <img src="images/user/user-xs-01.jpg" class="user-image rounded-circle" />
                                            <?php } else { ?>
                                                <i class="mdi mdi-account-circle-outline"></i>
                                            <?php } ?>

                                        </div>
                                        <span>
                                            <!-- <i class="fa fa-angle-down"></i> -->
                                        </span>
                                    </a>
                                    <!-- Dropdown list -->
                                    <ul class="dropdown-menu">
                                        <!-- <li><a class="dropdown-item" href="/profile"><i class="mdi mdi-account"></i> Lihat Profile</a></li>
                                        <li><a class="dropdown-item" href="/profile/change-password"><i class="mdi mdi-shield-key"></i> Ganti Password</a></li> -->
                                        <li><a class="dropdown-item" href="/logout"><i class="mdi mdi-logout"></i> Logout</a></li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link login-button" href="/login"><i class="mdi mdi-login"></i> Login</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link text-white add-button" href="/register"><i class="fa fa-plus-circle"></i> Register</a>
                                </li> -->
                            <?php } ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>