<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Excepciones\SaldoInsuficienteException;
use PDO;
use Exception;

class RepositorioTransferencias
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Conexion::obtener();
    }

    public function crear(int $cuentaOrigenId, string $numeroCuentaDestino, float $monto): bool
    {
        // 1. Verificar cuenta de origen y saldo disponible
        $stmt = $this->db->prepare("SELECT id, numero_cuenta, saldo FROM cuentas WHERE id = :id");
        $stmt->execute(['id' => $cuentaOrigenId]);
        $origen = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$origen || (float)$origen['saldo'] < $monto) {
            throw new SaldoInsuficienteException("Saldo insuficiente para realizar la transferencia.");
        }

        // 2. Verificar existencia de la cuenta destino
        $stmtDest = $this->db->prepare("SELECT id, numero_cuenta FROM cuentas WHERE numero_cuenta = :num");
        $stmtDest->execute(['num' => $numeroCuentaDestino]);
        $destino = $stmtDest->fetch(PDO::FETCH_ASSOC);

        if (!$destino) {
            throw new Exception("La cuenta de destino '{$numeroCuentaDestino}' no existe.");
        }

        if ((int)$destino['id'] === $cuentaOrigenId) {
            throw new Exception("No puede realizar una transferencia a su propia cuenta.");
        }

        $this->db->beginTransaction();

        try {
            // Descontar saldo de la cuenta de origen
            $stmtSub = $this->db->prepare("UPDATE cuentas SET saldo = saldo - :monto WHERE id = :id");
            $stmtSub->execute(['monto' => $monto, 'id' => $cuentaOrigenId]);

            // Sumar saldo a la cuenta de destino
            $stmtAdd = $this->db->prepare("UPDATE cuentas SET saldo = saldo + :monto WHERE id = :id");
            $stmtAdd->execute(['monto' => $monto, 'id' => $destino['id']]);

            // Insertar en la tabla transferencias (maneja nombres de columna 'monto' o 'valor')
            try {
                $stmtInsert = $this->db->prepare(
                    "INSERT INTO transferencias (cuenta_origen_id, cuenta_destino_id, monto, fecha) 
                     VALUES (:origen, :destino, :monto, NOW())"
                );
                $stmtInsert->execute([
                    'origen' => $cuentaOrigenId,
                    'destino' => $destino['id'],
                    'monto' => $monto
                ]);
            } catch (\PDOException $e) {
                $stmtInsert = $this->db->prepare(
                    "INSERT INTO transferencias (cuenta_origen_id, cuenta_destino_id, valor, fecha) 
                     VALUES (:origen, :destino, :monto, NOW())"
                );
                $stmtInsert->execute([
                    'origen' => $cuentaOrigenId,
                    'destino' => $destino['id'],
                    'monto' => $monto
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}