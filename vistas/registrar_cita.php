<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
    exit();
}

require __DIR__ . '/../modelos/ClsUsuario.php';
require __DIR__ . '/../modelos/ClsCliente.php';
require __DIR__ . '/../config/conexion.php';

$baseDeDatos = new BaseDeDatos();
$db = $baseDeDatos->obtenerConexion(); // Obtener la conexión a la base de datos
$usuario = new ClsUsuario($db);
$cliente = new ClsCliente($db);
?>

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
    <link rel="stylesheet" href="../css/barranavegacion.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
            background-color: #f8fafc;
            min-height: 100vh;
        }

        #registrar-cita-page {
            max-width: 1200px;
            margin: 100px auto 40px auto;
            padding: 0 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 30px;
        }

        @media (max-width: 992px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }

        .card-panel {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid #f1f5f9;
            padding: 30px;
            height: fit-content;
        }

        .card-panel h2 {
            font-size: 18px;
            font-weight: 600;
            color: #041291;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 12px;
        }

        .form-label {
            font-weight: 500;
            color: #475569;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 12px;
            font-size: 14px;
            transition: all 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-primary {
            background-color: #041291;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s ease;
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        .btn-primary:hover {
            background-color: #030b6b;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(4, 18, 145, 0.1);
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-custom th, .table-custom td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 12px;
        }

        .table-custom tr:hover {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-ocupado {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .btn-volver {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-volver:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            transform: translateY(-1px);
        }
    </style>
    <script>
        window.horariosOcupados = <?php echo json_encode($horariosOcupados); ?>;
    </script>
    <script src="../js/r_cita.js" defer></script>
</head>
<body>

    <?php include('../vistas/barranavegacion2.php'); ?> <!-- Barra de navegación arriba -->

    <div id="registrar-cita-page">
        <div class="dashboard-header">
            <h1>Gestión de Citas</h1>
            <button onclick="location.href='../index.php'" class="btn-volver">
                <i class="fas fa-home"></i> Volver al Inicio
            </button>
        </div>

        <div class="main-content">
            <!-- Columna Izquierda: Formulario -->
            <div class="card-panel">
                <h2>Reservar Cita</h2>
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
                        <label for="descripcion" class="form-label">Descripción o Motivo:</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ej: Consulta sobre diseño" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Cita</button>
                </form>
            </div>

            <!-- Columna Derecha: Horarios Ocupados -->
            <div class="card-panel">
                <h2>Horarios Ocupados para Hoy</h2>
                <div class="table-responsive">
                    <table class="table-custom">
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
                                        <td>
                                            <span class="status-badge status-ocupado">Ocupado</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No hay horarios ocupados para hoy.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include('../vistas/piepagina.php'); ?> <!-- Pie de página abajo -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/r_cita.js" defer></script>
</body>

</html>