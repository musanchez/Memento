<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;

class TareaController extends Controller
{
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

        // Guardar el estado actual en la sesión, usando el ID de la tarea
        session(['undo_estado_' . $tarea->id => $tarea->estado]);

        // Cambiar el estado de la tarea
        $tarea->estado = $request->input('estado');
        $tarea->save();

        return redirect()->back()->with('message', 'Estado de la tarea cambiado a: ' . $tarea->estado);
    }

    public function deshacerCambio($id)
    {
        // Recuperar el estado anterior de la tarea desde la sesión
        $estadoAnterior = session('undo_estado_' . $id);

        if ($estadoAnterior) {
            // Restaurar el estado de la tarea
            $tarea = Tarea::findOrFail($id);
            $tarea->estado = $estadoAnterior;
            $tarea->save();

            // Limpiar la sesión después de restaurar el estado
            session()->forget('undo_estado_' . $id);

            return redirect()->back()->with('message', 'Estado restaurado a: ' . $estadoAnterior);
        }

        return redirect()->back()->with('error', 'No se puede deshacer el cambio.');
    }
}
