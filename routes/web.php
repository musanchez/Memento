<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [TareaController::class, 'index']); // Ruta principal
Route::post('/tarea/crear', [TareaController::class, 'crearTarea']); // Ruta para crear una tarea
Route::post('/tarea/{id}/cambiar-estado', [TareaController::class, 'cambiarEstado']); // Ruta para cambiar el estado de una tarea
Route::post('/tarea/{id}/deshacer', [TareaController::class, 'deshacerCambio']); // Ruta para deshacer el último cambio en una tarea específica
