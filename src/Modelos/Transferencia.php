<?php

namespace App\Modelos;

class Transferencia
{
    public function __construct(
        private readonly ?int $id,
        private readonly int $cuentaOrigenId,
        private readonly int $cuentaDestinoId,
        private readonly float $valor,
        private readonly ?string $fecha = null
    ) {}

    public function getId(): ?int { return $this->id; }
    public function getCuentaOrigenId(): int { return $this->cuentaOrigenId; }
    public function getCuentaDestinoId(): int { return $this->cuentaDestinoId; }
    public function getValor(): float { return $this->valor; }
    public function getFecha(): ?string { return $this->fecha; }
}