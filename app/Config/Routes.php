<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// $routes->get('/', 'Home::index');
// service('auth')->routes($routes);

$routes->get('test-server', '\App\Controllers\Home::index');

$routes->group('auth', ['namespace' => '\App\Controllers\Auth'] ,function ($routes) {
    $routes->post('login', 'LoginController::jwtLogin');
    $routes->post('register', 'RegisterController::jwtRegister');
});

$routes->group('event', ['namespace' => '\App\Controllers\Event', 'filter' => 'jwt'], function ($routes) {
    $routes->get('/', 'EventController::index');
    $routes->post('/', 'EventController::create');
    $routes->put('(:num)', 'EventController::update');
    $routes->delete('(:num)', 'EventController::delete');
    $routes->get('(:num)', 'EventController::find');
    $routes->get('search', 'EventController::search');
    $routes->get('(:num)/panitia', 'EventController::panitia');
    $routes->get('(:num)/peserta', 'EventController::peserta');
    $routes->get('(:num)/mitra', 'EventController::mitra');
    $routes->get('(:num)/sertifikat', 'EventController::sertifikat');
});

$routes->group('peserta', ['namespace' => '\App\Controllers\Peserta'], function ($routes) {
    $routes->get('/', 'PesertaController::index');
    $routes->get('(:num)', 'PesertaController::find/$id');
    $routes->put('(:num)', 'PesertaController::update/$id');
    $routes->get('(:num)/event', 'PesertaController::event/$id');
    $routes->get('(:num)/sertifikat', 'PesertaController::sertifikat/$id');
});

$routes->group('panitia', ['namespace' => '\App\Controllers\Panitia'], function ($routes) {
    $routes->get('/', 'PanitiaController::index');
    $routes->get('(:num)', 'PanitiaController::find/$id');
    $routes->put('(:num)', 'PanitiaController::update/$id');
    $routes->get('(:num)/event', 'PanitiaController::event/$id');
});

$routes->group('sertifikat', ['namespace' => '\App\Controllers\Sertifikat'], function ($routes) {
    $routes->get('/', 'SertifikatController::index');
    $routes->post('/', 'SertifikatController::create');
    $routes->put('(:num)', 'SertifikatController::update/$id');
    $routes->delete('(:num)', 'SertifikatController::delete/$id');
    $routes->get('(:num)', 'SertifikatController::find/$id');
    $routes->get('(:num)/event', 'SertifikatController::event/$id');
    $routes->get('(:num)/peserta', 'SertifikatController::peserta/$id');
});

$routes->group('mitra', ['namespace' => '\App\Controllers\Mitra'], function ($routes) {
    $routes->get('/', 'MitraController::index');
    $routes->post('/', 'MitraController::create');
    $routes->put('(:num)', 'MitraController::update/$id');
    $routes->delete('(:num)', 'MitraController::delete/$id');
    $routes->get('(:num)', 'MitraController::find/$id');
    $routes->get('(:num)/event', 'MitraController::event/$id');
});


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
