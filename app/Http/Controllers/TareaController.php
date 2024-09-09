<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Memento\TareaCaretaker;

class TareaController extends Controller
{
    protected $caretaker;

    public function __construct()
    {
        // Inicializamos el Caretaker que manejará los Mementos
        $this->caretaker = new TareaCaretaker();
    }

    public function index()
    {
        // Obtener todas las tareas de la base de datos
        $tareas = Tarea::all();
        return view('tarea_form', compact('tareas'));
    }

    public function crearTarea(Request $request)
    {
        // Crear una nueva tarea
        $tarea = new Tarea();
        $tarea->nombre = $request->input('nombre');
        $tarea->estado = 'Pendiente'; // Estado inicial de la tarea
        $tarea->save();

        return redirect()->back()->with('message', 'Tarea creada correctamente.');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);

        // Guardar el estado actual de la tarea en un Memento
        $memento = $tarea->saveStateToMemento();
        $this->caretaker->addMemento($id, $memento);

        // Cambiar el estado de la tarea
        $tarea->estado = $request->input('estado');
        $tarea->save();

        return redirect()->back()->with('message', 'Estado de la tarea cambiado a: ' . $tarea->estado);
    }

    public function deshacerCambio($id)
    {
        // Recuperar el Memento de la tarea
        $memento = $this->caretaker->getMemento($id);

        if ($memento) {
            // Restaurar el estado desde el Memento
            $tarea = Tarea::findOrFail($id);
            $tarea->restoreStateFromMemento($memento);

            // Limpiar el Memento después de restaurar el estado
            $this->caretaker->clearMemento($id);

            return redirect()->back()->with('message', 'Estado restaurado a: ' . $tarea->estado);
        }

        return redirect()->back()->with('error', 'No se puede deshacer el cambio.');
    }
}
