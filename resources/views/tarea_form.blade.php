<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Estado de Tareas</h1>

        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario para crear una nueva tarea -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Crear Nueva Tarea</h4>
                <form method="POST" action="/tarea/crear">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Tarea:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Tarea</button>
                </form>
            </div>
        </div>

        <!-- Mostrar las tareas si hay alguna -->
        @if($tareas->isEmpty())
            <p class="text-center">No hay tareas disponibles. ¡Crea una nueva tarea!</p>
        @else
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Cambiar Estado de la Tarea</h4>
                    <ul class="list-group mb-3">
                        @foreach($tareas as $tarea)
                            <li class="list-group-item">
                                {{ $tarea->nombre }} - Estado: {{ $tarea->estado }}
                                <form method="POST" action="/tarea/{{ $tarea->id }}/cambiar-estado" class="d-inline-block">
                                    @csrf
                                    <select name="estado" class="form-select form-select-sm d-inline w-auto">
                                        <option value="Pendiente" {{ $tarea->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="En Progreso" {{ $tarea->estado == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                                        <option value="Completada" {{ $tarea->estado == 'Completada' ? 'selected' : '' }}>Completada</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Guardar Estado</button>
                                </form>

                                <!-- Botón de deshacer solo si existe un estado anterior para esta tarea -->
                                @if(session('undo_estado_' . $tarea->id))
                                    <form method="POST" action="/tarea/{{ $tarea->id }}/deshacer" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Deshacer</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
