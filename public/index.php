<?php
require_once '../config/config.php';
require_once '../config/Database.php';
require_once '../core/Router.php';
require_once '../core/Controller.php';
require_once '../controllers/AuthController.php';

session_start();

$router = new Router();

// Debug: Print the current URL
error_log("Current URL: " . $_SERVER['REQUEST_URI']);

// Define routes with leading slashes
$router->addRoute('GET', '/', 'AuthController@showLogin');
$router->addRoute('GET', '/auth/register', 'AuthController@showRegister');
$router->addRoute('POST', '/auth/register', 'AuthController@register');

// Routes d'authentification
$router->addRoute('GET', '/auth/login', 'AuthController@showLogin');
$router->addRoute('POST', '/auth/login', 'AuthController@login');

// Routes du dashboard
$router->addRoute('GET', '/dashboard', 'DashboardController@index');
$router->addRoute('GET', '/dashboard/admin', 'DashboardController@admin');
$router->addRoute('GET', '/dashboard/electeur', 'DashboardController@electeur');
$router->addRoute('GET', '/dashboard/observateur', 'DashboardController@observateur');

// Routes des élections
$router->addRoute('GET', '/elections', 'ElectionController@index');
$router->addRoute('GET', '/elections/create', 'ElectionController@create');
$router->addRoute('POST', '/elections/store', 'ElectionController@store');

$router->dispatch();