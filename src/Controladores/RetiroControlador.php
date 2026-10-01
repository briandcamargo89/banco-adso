<?php

namespace App\Controladores;

use App\Repositorios\RepositorioRetiros;

class RetiroControlador
{
    public function crear(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $usuario = $_SESSION['usuario'];
        $error = null;
        
        require_once __DIR__ . '/../../vistas/retiros/crear.php';
    }

    public function guardar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $monto = (float)($_POST['monto'] ?? 0);
        $cuentaId = (int)$_SESSION['usuario']['id'];

        if ($monto <= 0) {
            $usuario = $_SESSION['usuario'];
            $error = 'El monto del retiro debe ser mayor a cero.';
            require_once __DIR__ . '/../../vistas/retiros/crear.php';
            return;
        }

        try {
            $repoRetiros = new RepositorioRetiros();
            $repoRetiros->crear($cuentaId, $monto);

            // Actualizar el saldo en la sesión del usuario
            $_SESSION['usuario']['saldo'] -= $monto;

            header('Location: /cuenta');
            exit;
        } catch (\Exception $e) {
            $usuario = $_SESSION['usuario'];
            $error = $e->getMessage();
            require_once __DIR__ . '/../../vistas/retiros/crear.php';
        }
    }
}