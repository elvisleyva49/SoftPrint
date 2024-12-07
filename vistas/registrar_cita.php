<?php
require_once '../controladores/ControladorCita.php';
require_once '../config/conexion.php';

// Crear la conexión a la base de datos
$baseDeDatos = new BaseDeDatos();
$conexion = $baseDeDatos->obtenerConexion();

// Pasar la conexión a ControladorCita
$controladorcita = new ControladorCita($conexion);

// Establecer la zona horaria
date_default_timezone_set('America/Lima');
$fechaac = date('Y-m-d');

// Obtener el historial de citas para la fecha actual
$historialcitas = $controladorcita->obtenerHistorialCitas($fechaac) ?? [];

// Recoger los horarios ocupados para la fecha actual
$horariosOcupados = array_column($historialcitas, 'horario'); // Extraer solo los horarios ocupados
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #d0e7ff, #ffffff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #002c5f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 700px;
            width: 100%;
            text-align: center;
        }

        h1, h2 {
            color: #003f7f;
        }

        .btn-primary {
            background-color: #0044cc;
            border-color: #0036a3;
            border-radius: 50px;
        }

        .btn-primary:hover {
            background-color: #0036a3;
        }

        .table th {
            background-color: #0044cc;
            color: white;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f3f7fc;
        }

        .form-label {
            color: #003f7f;
            font-weight: bold;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-secondary {
            background-color: #002c5f;
            color: white;
            border-radius: 50px;
        }

        .btn-secondary:hover {
            background-color: #001a40;
        }
    </style>
    <script>
        window.horariosOcupados = <?php echo json_encode($horariosOcupados); ?>;
    </script>
    <script src="../js/r_cita.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Registrar Cita</h1>
        <form id="citaForm" method="POST" action="../controladores/ControladorCita.php?accion=registrarcita">
            <div class="mb-3">
                <label for="fecha" class="form-label">Selecciona una fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="horario" class="form-label">Seleccionar horario:</label>
                <select id="horario" name="horario" class="form-select" required>
                    <option value="09:00">9 AM</option>
                    <option value="10:00">10 AM</option>
                    <option value="12:10">3 PM</option>
                    <option value="12:20">4 PM</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar Cita</button>
        </form>

        <h2 class="mt-5">Horarios Ocupados</h2>
        <table id="citasTableBody"class="table table-hover table-bordered text-center">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historialcitas)): ?>
                    <?php foreach ($historialcitas as $cita): ?>
                        <tr>
                            <td><?= htmlspecialchars($cita['fecha']); ?></td>
                            <td><?= htmlspecialchars($cita['horario']); ?></td>
                            <td><?= htmlspecialchars($cita['estado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay horarios ocupados disponibles para hoy.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <button onclick="location.href='/'" class="btn btn-secondary">
                <i class="fas fa-home"></i> Volver al Inicio
            </button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/r_cita.js" defer></script>
</body>
</html>
