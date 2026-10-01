<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/ayudantes.php';

use App\Nucleo\Router;
use App\Controladores\AutenticacionControlador;
use App\Controladores\CuentaControlador;
use App\Controladores\RetiroControlador;
use App\Controladores\TransferenciaControlador;

$router = new Router();

// Autenticación
$router->get('/', [AutenticacionControlador::class, 'mostrarLogin']);
$router->get('/login', [AutenticacionControlador::class, 'mostrarLogin']);
$router->post('/login', [AutenticacionControlador::class, 'login']);
$router->get('/logout', [AutenticacionControlador::class, 'logout']);

// Cuenta
$router->get('/cuenta', [CuentaControlador::class, 'panel']);

// Retiros (Acepta tanto 'retiro/crear' como 'retiros/crear')
$router->get('/retiros/crear', [RetiroControlador::class, 'crear']);
$router->get('/retiro/crear', [RetiroControlador::class, 'crear']);
$router->post('/retiros/crear', [RetiroControlador::class, 'guardar']);
$router->post('/retiro/crear', [RetiroControlador::class, 'guardar']);

// Transferencias (Acepta tanto 'transferencia/crear' como 'transferencias/crear')
$router->get('/transferencias/crear', [TransferenciaControlador::class, 'crear']);
$router->get('/transferencia/crear', [TransferenciaControlador::class, 'crear']);
$router->post('/transferencias/crear', [TransferenciaControlador::class, 'guardar']);
$router->post('/transferencia/crear', [TransferenciaControlador::class, 'guardar']);

$router->despachar();