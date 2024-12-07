<?php
require_once '../controladores/ControladorCita.php';
require_once '../config/conexion.php';
// Crear la conexión a la base de datos
$baseDeDatos = new BaseDeDatos();
$conexion = $baseDeDatos->obtenerConexion();
$controladorcita = new ControladorCita($conexion);
// Establecer la zona horaria
date_default_timezone_set('America/Lima');
$fechaac = date('Y-m-d');

// Obtener el historial de citas para la fecha actual
$historialcitas = $controladorcita->obtenerCitas($fechaac);

// Recoger los horarios ocupados para la fecha actual
$horariosOcupados = array_column($historialcitas, 'horario'); // Extraer solo los horarios ocupados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cita</title>
    <link rel="stylesheet" href="../css/estilocita2.css"> 
    <!-- <script src="../js/r_cita.js" defer></script> Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <h1>Citas Programadas</h1>
    <table>
        <thead>
            <tr>
                <th>IDCITA</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Estado</th>
                <th>Descripción</th>
               <!-- <th>Fecha y Hora de Creación</th>-->
                <th>Cliente</th>  
                <th class="td-operaciones">Operaciones</th>             

            </tr>
        </thead>
        <tbody id="citasTableBody">
        <?php foreach ($historialcitas as $cita): ?>
            <script>
                console.log(<?php echo json_encode($historialcitas); ?>);
            </script>
            <tr>
                <td><?= htmlspecialchars($cita['id_cita']); ?></td>
                <td><?= htmlspecialchars($cita['fecha']); ?></td>
                <td><?= htmlspecialchars($cita['horario']); ?></td>               
                <td class="td-estado">
                    <?php $estado=$cita['estado']?>
                    <select>
                    <option value="programada" <?= $estado == 'programada' ? 'selected' : ''; ?>>programada</option>
                    <option value="realizada" <?= $estado == 'realizada' ? 'selected' : ''; ?>>realizada</option>
                    <option value="cancelada" <?= $estado == 'cancelada' ? 'selected' : ''; ?>>cancelada</option>
                    </select>
                </td>
                <td><?= htmlspecialchars($cita['descripcion']); ?></td>
                <!-- <td><?= htmlspecialchars($cita['f_creacion']); ?></td> -->
                <td><?= htmlspecialchars($cita['cliente']); ?></td> 
                <td>
                    <button onclick="obtenerEstadoSeleccionado(this.closest('tr')) "data-id_cita="<?= $cita['id_cita']; ?>">Modificar</button>
                   <!-- <button class="btn-eliminar">Eliminar</button></td> -->
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        function obtenerEstadoSeleccionado(fila) {
            // Obtiene el valor del select en la fila especificada
            var estadoSeleccionado = fila.querySelector('select').value;
            var idCita = fila.querySelector('button').getAttribute('data-id_cita');
            window.location.href ='../controladores/ControladorCita.php?accion=modificarEstado&estado='+estadoSeleccionado+ '&id_cita=' + idCita;
            //alert("El estado seleccionado en esta fila es: " + estadoSeleccionado);            
        }
    </script>
     <div style="margin-bottom: 20px;text-align: center;">
        <button onclick="location.href='/'" class="btn-volver">
            <i class="fas fa-home"></i> Volver al Inicio
        </button>
    </div>
</body>
</html>
