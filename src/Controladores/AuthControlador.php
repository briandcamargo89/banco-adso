<?php

namespace App\Controladores;

use App\Nucleo\ControladorBase;
use App\Nucleo\Vista;
use App\Servicios\ServicioCuenta;
use Exception;

class AuthControlador extends ControladorBase
{
    private ServicioCuenta $servicio;

    public function __construct()
    {
        $this->servicio = new ServicioCuenta();
    }

    public function loginAccion(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['cuenta_id'])) $this->redirigir('cuenta/panel');

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $cuentaId = $this->servicio->autenticar($_POST['numero_cuenta'] ?? '', $_POST['clave'] ?? '');
                $_SESSION['cuenta_id'] = $cuentaId;
                $this->redirigir('cuenta/panel');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        Vista::render('auth/login', ['error' => $error]);
    }

    public function logoutAccion(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        $this->redirigir('auth/login');
    }
}