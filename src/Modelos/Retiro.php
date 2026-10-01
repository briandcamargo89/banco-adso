<?php

namespace App\Modelos;

class Retiro
{
    public function __construct(
        private readonly ?int $id,
        private readonly int $cuentaId,
        private readonly float $valor,
        private readonly ?string $fecha = null
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getCuentaId(): int { return $this->cuentaId; }
    public function getValor(): float { return $this->valor; }
    public function getFecha(): ?string { return $this->fecha; }
}