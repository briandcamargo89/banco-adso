<?php

namespace App\Controladores;

use App\Nucleo\Vista;
use App\Repositorios\RepositorioCuentas;

class CuentaControlador
{
    public function panel(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no hay sesión activa, redirige al login
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $usuario = $_SESSION['usuario'];

        Vista::render('cuenta/panel', [
            'usuario' => $usuario
        ]);
    }
}