<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Excepciones\CredencialesInvalidasException;
use PDO;

class RepositorioUsuarios
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Conexion::obtener();
    }

    public function autenticar(string $numeroCuenta, string $clave)
    {
        $stmt = $this->db->prepare("SELECT * FROM cuentas WHERE numero_cuenta = :numero_cuenta LIMIT 1");
        $stmt->execute(['numero_cuenta' => $numeroCuenta]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            throw new CredencialesInvalidasException("Número de cuenta no encontrado.");
        }

        // Obtener el campo de contraseña detectando si se llama 'clave' o 'password' en la base de datos
        $hashGuardado = $usuario['clave'] ?? $usuario['password'] ?? '';

        // 1. Validar si coincide con el hash (password_hash)
        if (!empty($hashGuardado) && password_verify($clave, $hashGuardado)) {
            return $usuario;
        }

        // 2. Validar si está almacenada en texto plano (como '123456')
        if (!empty($hashGuardado) && $hashGuardado === $clave) {
            return $usuario;
        }

        throw new CredencialesInvalidasException("Contraseña incorrecta.");
    }
}