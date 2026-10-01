<?php

namespace App\Controladores;

use App\Nucleo\Vista;
use App\Repositorios\RepositorioUsuarios;
use App\Excepciones\CredencialesInvalidasException;

class AutenticacionControlador
{
    public function mostrarLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario'])) {
            header('Location: /cuenta');
            exit;
        }

        Vista::render('autenticacion/login');
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $numeroCuenta = trim($_POST['numero_cuenta'] ?? '');
        $clave = trim($_POST['clave'] ?? '');

        if (empty($numeroCuenta) || empty($clave)) {
            Vista::render('autenticacion/login', [
                'error' => 'Por favor complete todos los campos.'
            ]);
            return;
        }

        try {
            $repoUsuarios = new RepositorioUsuarios();
            $usuario = $repoUsuarios->autenticar($numeroCuenta, $clave);

            $_SESSION['usuario'] = $usuario;
            header('Location: /cuenta');
            exit;

        } catch (CredencialesInvalidasException $e) {
            Vista::render('autenticacion/login', [
                'error' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            Vista::render('autenticacion/login', [
                'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
            ]);
        }
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_destroy();
        header('Location: /');
        exit;
    }
}