<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --------------- ROTAS PÚBLICAS
$routes->get('/', 'HomeController::index', ['as' => 'home']);
$routes->get('/login', 'AuthController::index', ['as' => 'login']);
$routes->post('/login', 'AuthController::login', ['as' => 'auth']);
$routes->get('/logout', 'AuthController::logout', ['as' => 'logout']);

$routes->get('/forgot/password', 'AuthController::forgotPassword', ['as' => 'forgot']);
$routes->post('/forgot', 'AuthController::sendResetLink', ['as' => 'forgot.send']);
$routes->get('/reset/(:alphanum)', 'AuthController::resetPassword/$1', ['as' => 'forgot.reset']);
$routes->post('/forgot/update/(:alphanum)', 'AuthController::updatePassword/$1', ['as' => 'forgot.update']);

$routes->get('/register', 'UserController::create', ['as' => 'register']);
$routes->post('/register', 'UserController::store', ['as' => 'user.register']);

// --------------- ROTAS PROTEGIDAS
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index', ['as' => 'dashboard']);

    // ---- USERS
    $routes->get('/me', 'UserController::index', ['as' => 'me']);
    $routes->post('/me', 'UserController::update', ['as' => 'me.update']);
    $routes->post('/me/password', 'UserController::updatePassword', ['as' => 'me.password']);
    $routes->post('/me/delete', 'UserController::delete', ['as' => 'me.delete']);

    // ---- SPECIES
    $routes->get('/species', 'SpecieController::index', ['as' => 'species']);
    $routes->get('/species/create', 'SpecieController::create', ['as' => 'species.create']);
    $routes->post('/species/store', 'SpecieController::store', ['as' => 'species.store']);
    $routes->get('/species/edit/(:num)', 'SpecieController::edit/$1', ['as' => 'species.edit']);
    $routes->post('/species/edit/(:num)', 'SpecieController::update/$1', ['as' => 'species.update']);
    $routes->delete('/species/delete/(:num)', 'SpecieController::delete/$1', ['as' => 'species.delete']);

    // ---- BREEDS
    $routes->get('/breeds', 'BreedController::index', ['as' => 'breeds']);
    $routes->get('/breeds/create', 'BreedController::create', ['as' => 'breeds.create']);
    $routes->get('/breeds/specie/(:num)', 'BreedController::getBySpecie/$1');
    $routes->post('/breeds/store', 'BreedController::store', ['as' => 'breeds.store']);
    $routes->get('/breeds/edit/(:num)', 'BreedController::edit/$1', ['as' => 'breeds.edit']);
    $routes->post('/breeds/update/(:num)', 'BreedController::update/$1', ['as' => 'breeds.update']);
    $routes->delete('/breeds/delete/(:num)', 'BreedController::delete/$1', ['as' => 'breeds.delete']);

    // ---- PETS
    $routes->get('/pets', 'PetController::index', ['as' => 'pets']);
    $routes->get('/pets/create', 'PetController::create', ['as' => 'pets.create']);
    $routes->post('/pets/store', 'PetController::store', ['as' => 'pets.store']);
    $routes->get('/pets/edit/(:num)', 'PetController::edit/$1', ['as' => 'pets.edit']);
    $routes->post('/pets/update/(:num)', 'PetController::update/$1', ['as' => 'pets.update']);
    $routes->delete('/pets/delete/(:num)', 'PetController::delete/$1', ['as' => 'pets.delete']);

    // ---- APPOINTMENTS
    $routes->get('/appointments', 'AppointmentController::index', ['as' => 'appointments']);
    $routes->get('/appointments/create', 'AppointmentController::create', ['as' => 'appointments.create']);
    $routes->post('/appointments/store', 'AppointmentController::store', ['as' => 'appointments.store']);
    $routes->get('/appointments/edit/(:num)', 'AppointmentController::edit/$1', ['as' => 'appointments.edit']);
    $routes->post('/appointments/update/(:num)', 'AppointmentController::update/$1', ['as' => 'appointments.update']);
    $routes->delete('/appointments/delete/(:num)', 'AppointmentController::delete/$1', ['as' => 'appointments.delete']);
    $routes->get('/appointments/export/(:num)', 'AppointmentController::export/$1', ['as' => 'appointments.export']);

});
