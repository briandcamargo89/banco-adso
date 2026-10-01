<?php

namespace App\Servicios;

use App\Nucleo\Conexion;
use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioUsuarios;
use App\Repositorios\RepositorioRetiros;
use App\Repositorios\RepositorioTransferencias;
use App\Excepciones\CredencialesInvalidasException;
use App\Excepciones\SaldoInsuficienteException;
use App\Excepciones\MandoInvalidoException;
use App\Excepciones\CuentaNoEncontradaException;
use App\Excepciones\MismaCuentaException;
use PDO;
use Exception;

class ServicioCuenta
{
    private RepositorioCuentas $repoCuentas;
    private RepositorioUsuarios $repoUsuarios;
    private RepositorioRetiros $repoRetiros;
    private RepositorioTransferencias $repoTransferencias;
    private PDO $pdo;

    public function __construct()
    {
        $this->repoCuentas = new RepositorioCuentas();
        $this->repoUsuarios = new RepositorioUsuarios();
        $this->repoRetiros = new RepositorioRetiros();
        $this->repoTransferencias = new RepositorioTransferencias();
        $this->pdo = Conexion::obtener();
    }

    public function autenticar(string $numeroCuenta, string $clave): int
    {
        $cuenta = $this->repoCuentas->buscarPorNumero($numeroCuenta);
        if (!$cuenta) {
            throw new CredencialesInvalidasException('Datos de acceso incorrectos.');
        }

        $usuario = $this->repoUsuarios->buscarPorCuentaId($cuenta->getId());
        if (!$usuario || !password_verify($clave, $usuario->getClaveHash())) {
            throw new CredencialesInvalidasException('Datos de acceso incorrectos.');
        }

        return $cuenta->getId();
    }

    public function confirmarClave(int $cuentaId, string $clave): void
    {
        $usuario = $this->repoUsuarios->buscarPorCuentaId($cuentaId);
        if (!$usuario || !password_verify($clave, $usuario->getClaveHash())) {
            throw new CredencialesInvalidasException('La contraseña es incorrecta.');
        }
    }

    public function realizarTransferencia(int $origenId, string $destinoNum, float $monto, string $clave): void
    {
        $this->confirmarClave($origenId, $clave);

        if ($monto <= 0) {
            throw new MandoInvalidoException('El monto debe ser superior a cero.');
        }

        $destino = $this->repoCuentas->buscarPorNumero($destinoNum);
        if (!$destino) {
            throw new CuentaNoEncontradaException('La cuenta de destino no existe.');
        }

        if ($destino->getId() === $origenId) {
            throw new MismaCuentaException('No puedes realizar transferencias a tu propia cuenta.');
        }

        $origen = $this->repoCuentas->buscarPorId($origenId);
        if ($origen->getSaldo() < $monto) {
            throw new SaldoInsuficienteException('Saldo insuficiente para completar la operación.');
        }

        $this->pdo->beginTransaction();
        try {
            $this->repoCuentas->actualizarSaldo($origenId, $origen->getSaldo() - $monto);
            $this->repoCuentas->actualizarSaldo($destino->getId(), $destino->getSaldo() + $monto);
            $this->repoTransferencias->registrar($origenId, $destino->getId(), $monto);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    public function realizarRetiro(int $cuentaId, float $monto, string $clave): void
    {
        $this->confirmarClave($cuentaId, $clave);

        if ($monto <= 0) {
            throw new MandoInvalidoException('El valor a retirar debe ser mayor a cero.');
        }

        $cuenta = $this->repoCuentas->buscarPorId($cuentaId);
        if ($cuenta->getSaldo() < $monto) {
            throw new SaldoInsuficienteException('Saldo insuficiente para realizar el retiro.');
        }

        $this->pdo->beginTransaction();
        try {
            $this->repoCuentas->actualizarSaldo($cuentaId, $cuenta->getSaldo() - $monto);
            $this->repoRetiros->registrar($cuentaId, $monto);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}