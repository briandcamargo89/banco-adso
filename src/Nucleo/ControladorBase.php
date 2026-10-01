<?php

namespace App\Nucleo;

abstract class ControladorBase
{
    protected function requerirSesion(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cuenta_id'])) {
            header('Location: ?ruta=auth/login');
            exit;
        }
    }

    protected function obtenerCuentaIdSesion(): int
    {
        $this->requerirSesion();
        return (int)$_SESSION['cuenta_id'];
    }

    protected function redirigir(string $ruta): void
    {
        header("Location: ?ruta={$ruta}");
        exit;
    }
}