<?php

namespace App\Nucleo;

class Vista
{
    public static function render(string $vista, array $datos = []): void
    {
        extract($datos);
        
        $archivo = __DIR__ . "/../../vistas/{$vista}.php";

        if (file_exists($archivo)) {
            require_once $archivo;
        } else {
            echo "Error: La vista '{$vista}' no existe en {$archivo}";
        }
    }
}