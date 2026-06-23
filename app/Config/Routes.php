<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --------------- ROTAS PÚBLICAS
$routes->get('/', 'HomeController::index', ['as' => 'home']);
$routes->get('/login', 'AuthController::index', ['as' => 'login']);
$routes->post('/login', 'AuthController::login', ['as' => 'auth']);
$routes->get('/logout', 'AuthController::logout', ['as' => 'logout']);

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
});
