<?php

namespace App\Modelos;

class Usuario
{
    public function __construct(
        private readonly ?int $id,
        private readonly int $cuentaId,
        private readonly string $claveHash
    ) {}

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getCuentaId(): int 
    { 
        return $this->cuentaId; 
    }

    public function getClaveHash(): string 
    { 
        return $this->claveHash; 
    }
}