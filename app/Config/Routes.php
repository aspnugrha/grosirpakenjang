<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'User\Home::index');
$routes->get('/home', 'User\Home::index');

// login
$routes->get('/login', 'Login::index');
$routes->post('/login', 'Login::login');
$routes->get('/logout', 'Login::logout');
$routes->post('/register', 'Login::register');

// aktivasi
$routes->group('/aktivasi', static function ($routes) {
    $routes->post('kirim_kode', 'Login::aktivasi_kirim_kode');
    $routes->post('aktivasi', 'Login::aktivasi');
});


// lupa password
$routes->group('/lupa_password', static function ($routes) {
    $routes->post('create_new_pass', 'Login::create_new_pass');
});


// admin
$routes->group('/a', static function ($routes) {
    // dash
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // data_master
    // user
    $routes->get('data_master/user', 'Admin\Data_master_user::index');
    // ajax
    $routes->post('data_master/ajax/load_user', 'Admin\Data_master_user::load_user');
    $routes->post('data_master/ajax/ubah_role', 'Admin\Data_master_user::ubah_role');
    $routes->get('data_master/ajax/ubah_aktif/(:num)', 'Admin\Data_master_user::ubah_aktif/$1');


    // jenis barang
    $routes->get('data_master/jenis_barang', 'Admin\Data_master_jenis_barang::index');
    // ajax
    $routes->post('data_master/ajax/load_jenis_barang', 'Admin\Data_master_jenis_barang::load_jenis_barang');


    // barang
    $routes->get('data_master/barang', 'Admin\Data_master_barang::index');
    // ajax
    $routes->post('data_master/ajax/load_barang', 'Admin\Data_master_barang::load_barang');


    // PENJUALAN
    $routes->get('penjualan/cek_pesanan', 'Admin\Pesanan::cek_pesanan');
    // ajax
    $routes->post('data_master/ajax/load_barang', 'Admin\Data_master_barang::load_barang');


    // Pesanan
    $routes->get('penjualan/pesanan', 'Admin\Pesanan::pesanan');

    // Pengambilan
    $routes->get('penjualan/pengambilan', 'Admin\Pengambilan::index');

    // Selesai
    $routes->get('penjualan/selesai', 'Admin\Selesai::index');


    // Bandingkan
    $routes->get('bandingkan', 'Admin\Bandingkan::index');
});



// USER
$routes->group('/', static function ($routes) {
    // dash
    $routes->get('home', 'User\Home::index');
    $routes->get('cart', 'User\Keranjang::index');
    $routes->get('order', 'User\Pesanan::index');
    $routes->get('last_order', 'User\Selesai::index');
    $routes->get('compare', 'User\Bandingkan::index');
});

$routes->match(['get', 'post'], 'AjaxLoadMore/loadMoreUsers', 'User\Home::loadMoreUsers');
$routes->match(['get', 'post'], 'AjaxLoadMore/fetchData', 'User\Home::fetchData');

$routes->resource('API_barang');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
