<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = ['nombre', 'estado'];

    // Crear un Memento con el estado actual de la tarea
    public function saveStateToMemento()
    {
        return new \App\Memento\TareaMemento($this->estado);
    }

    // Restaurar el estado de un Memento
    public function restoreStateFromMemento(\App\Memento\TareaMemento $memento)
    {
        $this->estado = $memento->getEstado();
        $this->save();
    }
}
