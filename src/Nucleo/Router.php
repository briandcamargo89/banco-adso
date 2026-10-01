<?php

namespace App\Nucleo;

class Router
{
    private array $rutas = [];

    public function agregar(string $metodo, string $ruta, array $handler): void
    {
        $this->rutas[strtoupper($metodo)][$ruta] = $handler;
    }

    public function get(string $ruta, array $handler): void
    {
        $this->agregar('GET', $ruta, $handler);
    }

    public function post(string $ruta, array $handler): void
    {
        $this->agregar('POST', $ruta, $handler);
    }

    public function despachar(): void
    {
        $metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Detectar ruta ya sea por query string (?ruta=...) o por URL normal
        if (isset($_GET['ruta'])) {
            $uri = '/' . trim($_GET['ruta'], '/');
        } else {
            $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        }

        if (isset($this->rutas[$metodo][$uri])) {
            [$controlador, $accion] = $this->rutas[$metodo][$uri];
            $instancia = new $controlador();
            $instancia->$accion();
            return;
        }

        http_response_code(404);
        echo "Página no encontrada (404)";
    }
}