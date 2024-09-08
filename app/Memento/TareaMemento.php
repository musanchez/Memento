<?php

namespace App\Memento;

class TareaMemento
{
    protected $estado;

    public function __construct($estado)
    {
        $this->estado = $estado;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}
