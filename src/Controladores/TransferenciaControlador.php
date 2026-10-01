<?php

namespace App\Controladores;

use App\Repositorios\RepositorioTransferencias;

class TransferenciaControlador
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

        require_once __DIR__ . '/../../vistas/transferencias/crear.php';
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

        $numeroDestino = trim($_POST['numero_cuenta'] ?? $_POST['cuenta_destino'] ?? '');
        $monto = (float)($_POST['monto'] ?? 0);
        $cuentaOrigenId = (int)$_SESSION['usuario']['id'];

        if (empty($numeroDestino)) {
            $usuario = $_SESSION['usuario'];
            $error = 'Debe ingresar el número de cuenta de destino.';
            require_once __DIR__ . '/../../vistas/transferencias/crear.php';
            return;
        }

        if ($monto <= 0) {
            $usuario = $_SESSION['usuario'];
            $error = 'El monto a transferir debe ser mayor a cero.';
            require_once __DIR__ . '/../../vistas/transferencias/crear.php';
            return;
        }

        try {
            $repo = new RepositorioTransferencias();
            $repo->crear($cuentaOrigenId, $numeroDestino, $monto);

            // Actualizar saldo de la sesión
            $_SESSION['usuario']['saldo'] -= $monto;

            header('Location: /cuenta');
            exit;
        } catch (\Exception $e) {
            $usuario = $_SESSION['usuario'];
            $error = $e->getMessage();
            require_once __DIR__ . '/../../vistas/transferencias/crear.php';
        }
    }
}