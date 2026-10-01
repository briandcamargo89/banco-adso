<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Nucleo\Conexion;

try {
    $pdo = Conexion::obtener();

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE transferencias; TRUNCATE TABLE retiros; TRUNCATE TABLE usuarios; TRUNCATE TABLE cuentas; TRUNCATE TABLE clientes;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    $passwordComun = password_hash('123456', PASSWORD_BCRYPT);

    for ($i = 1; $i <= 5; $i++) {
        $stmtC = $pdo->prepare("INSERT INTO clientes (nombre) VALUES (?)");
        $stmtC->execute(["Cliente $i"]);
        $clienteId = $pdo->lastInsertId();

        $numeroCuenta = "100" . $i;
        $stmtAcc = $pdo->prepare("INSERT INTO cuentas (numero_cuenta, saldo, cliente_id) VALUES (?, ?, ?)");
        $stmtAcc->execute([$numeroCuenta, 1000.00 * $i, $clienteId]);
        $cuentaId = $pdo->lastInsertId();

        $stmtU = $pdo->prepare("INSERT INTO usuarios (cuenta_id, clave_hash) VALUES (?, ?)");
        $stmtU->execute([$cuentaId, $passwordComun]);
    }

    echo "Base de datos sembrada con éxito. Cuentas: 1001 a 1005 (Clave: 123456).\n";

} catch (Exception $e) {
    echo "Error al sembrar la base de datos: " . $e->getMessage() . "\n";
}