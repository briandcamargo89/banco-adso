<?php

namespace App\Modelos;

class Cuenta
{
    public function __construct(
        private readonly ?int $id,
        private readonly string $numeroCuenta,
        private float $saldo,
        private readonly int $clienteId
    ) {}

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getNumeroCuenta(): string 
    { 
        return $this->numeroCuenta; 
    }

    public function getSaldo(): float 
    { 
        return $this->saldo; 
    }

    public function getClienteId(): int 
    { 
        return $this->clienteId; 
    }
}