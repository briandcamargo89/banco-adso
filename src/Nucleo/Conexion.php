<?php

namespace App\Nucleo;

use PDO;
use PDOException;

class Conexion
{
    private static ?PDO $instancia = null;

    private function __construct() {}

    public static function obtener(): PDO
    {
        if (self::$instancia === null) {
            $config = require __DIR__ . '/../../config/basedatos.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";

            try {
                self::$instancia = new PDO($dsn, $config['user'], $config['pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                // Cambiamos esta línea para ver el error exacto
                die("Error de MySQL: " . $e->getMessage() . "\n");
            }
        }

        return self::$instancia;
    }
}