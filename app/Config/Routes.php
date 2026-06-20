<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --------------- ROTAS PÚBLICAS
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('/login', 'AuthController::index', ['as' => 'login']);
$routes->post('/login', 'AuthController::login', ['as' => 'auth']);

// --------------- ROTAS PROTEGIDAS
$routes->get('/logout', 'AuthController::logout', ['as' => 'logout']);
