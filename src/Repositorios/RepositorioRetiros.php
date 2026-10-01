<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Excepciones\SaldoInsuficienteException;
use PDO;

class RepositorioRetiros
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Conexion::obtener();
    }

    public function crear(int $cuentaId, float $monto): bool
    {
        // 1. Verificar saldo disponible
        $stmt = $this->db->prepare("SELECT saldo FROM cuentas WHERE id = :id");
        $stmt->execute(['id' => $cuentaId]);
        $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cuenta || (float)$cuenta['saldo'] < $monto) {
            throw new SaldoInsuficienteException("Saldo insuficiente para realizar el retiro.");
        }

        $this->db->beginTransaction();

        try {
            // 2. Descontar saldo de la cuenta
            $stmtUpdate = $this->db->prepare("UPDATE cuentas SET saldo = saldo - :monto WHERE id = :id");
            $stmtUpdate->execute(['monto' => $monto, 'id' => $cuentaId]);

            // 3. Registrar retiro (probando 'valor' o 'monto' según la estructura de tu tabla)
            try {
                $stmtInsert = $this->db->prepare("INSERT INTO retiros (cuenta_id, valor, fecha) VALUES (:cuenta_id, :monto, NOW())");
                $stmtInsert->execute(['cuenta_id' => $cuentaId, 'monto' => $monto]);
            } catch (\PDOException $e) {
                // Fallback si la columna realmente se llama 'monto'
                $stmtInsert = $this->db->prepare("INSERT INTO retiros (cuenta_id, monto, fecha) VALUES (:cuenta_id, :monto, NOW())");
                $stmtInsert->execute(['cuenta_id' => $cuentaId, 'monto' => $monto]);
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}