<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Cuenta;
use PDO;

class RepositorioCuentas
{
    private PDO $pdo;

    public function __construct()
    {
        $this->db = Conexion::obtener();
    }

    public function buscarPorId(int $id): ?Cuenta
    {
        $stmt = $this->pdo->prepare('SELECT * FROM cuentas WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? new Cuenta((int)$row['id'], $row['numero_cuenta'], (float)$row['saldo'], (int)$row['cliente_id']) : null;
    }

    public function buscarPorNumero(string $numero): ?Cuenta
    {
        $stmt = $this->pdo->prepare('SELECT * FROM cuentas WHERE numero_cuenta = ?');
        $stmt->execute([$numero]);
        $row = $stmt->fetch();

        return $row ? new Cuenta((int)$row['id'], $row['numero_cuenta'], (float)$row['saldo'], (int)$row['cliente_id']) : null;
    }

    public function actualizarSaldo(int $cuentaId, float $nuevoSaldo): bool
    {
        $stmt = $this->pdo->prepare('UPDATE cuentas SET saldo = ? WHERE id = ?');
        return $stmt->execute([$nuevoSaldo, $cuentaId]);
    }
}