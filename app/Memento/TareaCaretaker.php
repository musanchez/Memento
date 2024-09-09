<?php

namespace App\Memento;

class TareaCaretaker
{
    // Agregar un Memento a la sesión, identificando por ID de la tarea
    public function addMemento($tareaId, TareaMemento $memento)
    {
        // Guardar el estado en la sesión
        session(['tarea_memento_' . $tareaId => $memento->getEstado()]);
    }

    // Obtener el Memento desde la sesión por ID de la tarea
    public function getMemento($tareaId)
    {
        $estado = session('tarea_memento_' . $tareaId);
        if ($estado) {
            return new TareaMemento($estado); // Retornar un Memento con el estado guardado
        }

        return null;
    }

    // Limpiar el Memento de la sesión
    public function clearMemento($tareaId)
    {
        session()->forget('tarea_memento_' . $tareaId);
    }
}
