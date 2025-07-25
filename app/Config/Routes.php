<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// $routes->get('login', 'FaqRedirectController::login');
// $routes->post('login', 'FaqRedirectController::login');
// $routes->get('logout', 'FaqRedirectController::logout');




$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');

});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index'); // Rute ini digunakan untuk menampilkan isi keranjang belanja
    $routes->post('', 'TransaksiController::cart_add'); // Rute ini digunakan untuk menambah produk ke keranjang belanja
    $routes->post('edit', 'TransaksiController::cart_edit'); // Rute ini digunakan untuk mengubah jumlah produk pada keranjang belanja
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1'); // Rute ini digunakan untuk menghapus produk dari keranjang belanja
    $routes->get('clear', 'TransaksiController::cart_clear'); // Rute ini digunakan untuk mengosongkan keranjang belanja
});

$routes->group('productcategory', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProductCategoryController::index');
    $routes->post('', 'ProductCategoryController::create');
    $routes->post('edit/(:any)', 'ProductCategoryController::edit/$1');
    $routes->get('delete/(:any)', 'ProductCategoryController::delete/$1');
});

// Roter Diskon
// app/Config/Routes.php

// Anda sudah punya ini, ini sudah benar!
$routes->group('diskon', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DiskonController::index');
    $routes->post('store', 'DiskonController::store');
    $routes->get('edit/(:num)', 'DiskonController::edit/$1'); // Digunakan untuk AJAX
    $routes->post('update/(:num)', 'DiskonController::update/$1');
    $routes->get('delete/(:num)', 'DiskonController::delete/$1');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']); // Route Checkout
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']); // Route buy

// Akses dua endpoint yang sudah dicoba pada postman
$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);
$routes->get('profile', 'Home::profile', ['filter' => 'auth']); // Router Profile

$routes->get('/auth', 'AuthController::index');
$routes->get('/faq', 'FaqController::index');
$routes->get('/profile', 'ProfileController::index');
$routes->get('/contact', 'ContactController::index');

$routes->resource('api', ['controller' => 'apiController']); // Router API