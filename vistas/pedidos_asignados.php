<?php
session_start(); // Inicia la sesión

// Incluye los controladores necesarios
require_once __DIR__ . '/../controladores/PedidosControlador.php';
require_once __DIR__ . '/../controladores/EmpleadoControlador.php'; // Incluir el nuevo controlador
require_once __DIR__ . '/../config/conexion.php'; // Asegúrate de incluir la conexión a la base de datos

// Crear la conexión a la base de datos
$baseDeDatos = new BaseDeDatos();
$conn = $baseDeDatos->obtenerConexion();

// Inicializa el controlador de pedidos y el controlador de empleados
$pedidoControlador = new PedidosControlador();
$empleadoControlador = new EmpleadoControlador($conn); // Usar el controlador de empleado con la conexión

// Verifica que el id_usuario esté presente en la sesión
if (!isset($_SESSION['usuario'])) {
    // Si no está logueado, redirige al login
    header('Location: login.php');
    exit;
}

// Obtén el id_usuario de la sesión
$id_usuario = $_SESSION['usuario'];

if (isset($id_usuario)) {
    // Obtener el id_empleado usando el id_usuario
    $id_empleado = $empleadoControlador->obtenerIdEmpleadoPorUsuario($id_usuario);

    if ($id_empleado !== null) {
        // Si se obtiene un id_empleado, mostrar los pedidos por diseñador
        $pedidosporDesigner = $pedidoControlador->mostrarPedidosporDesigner($id_empleado);
    } else {
        // Si no se encuentra el id_empleado, redirige a una página de error o muestra un mensaje
        echo "No se encontró el empleado asociado con este usuario.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos Pendientes</title>
    <link rel="stylesheet" href="../css/mispedidos.css">
    <link rel="stylesheet" href="../css/pagar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Pedidos Asignados</h1>

    <!-- Mostrar pedidos asignados al diseñador -->
    <?php if (isset($pedidosporDesigner) && count($pedidosporDesigner) > 0): ?>
        <table>
            <tr>
                <th>Nombre Cliente</th>
                <th>Apellido Cliente</th>
                <th>Descripción</th>
                <th>Fecha Pedido</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($pedidosporDesigner as $pedido): ?>
                <tr>
                    <td><?= htmlspecialchars($pedido['nombre_cliente']) ?></td>
                    <td><?= htmlspecialchars($pedido['apellido_cliente']) ?></td>
                    <td><?= htmlspecialchars($pedido['descripcion']) ?></td>
                    <td><?= $pedido['fecha_pedido'] ?></td>         
                    <td class="td-estado">
                    <?php $estado=$pedido['estado']?>
                    <select>
                    <option value="asignado" <?= $estado == 'asignado' ? 'selected' : ''; ?>>En espera</option>
                    <option value="procesando" <?= $estado == 'procesando' ? 'selected' : ''; ?>>Procesando</option>
                    <option value="completado" <?= $estado == 'completado' ? 'selected' : ''; ?>>Completado</option>
                    </select>
                </td>
                    <td>
                    <button class="detalle" onclick="obtenerEstadoSeleccionado(this.closest('tr'))" data-id_pedido="<?= $pedido['id_pedido']; ?>">
                    <i class="fas fa-info-circle"></i> Actualizar Estado
                    </button>

                        <a href="detal_pedido.php?accion=verDetallePedido&id_pedido=<?= $pedido['id_pedido'] ?>" class="detalle">
                            <i class="fas fa-info-circle"></i> Detalle Pedido
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    <!-- Mensaje si no hay pedidos asignados al diseñador -->
    <?php else: ?>
        <p>No se encontraron pedidos asignados a su cuenta.</p>
    <?php endif; ?>

    <div style="margin-bottom: 20px;">
        <button onclick="location.href='/'" class="btn-volver">
            <i class="fas fa-home"></i> Volver al Inicio
        </button>
    </div>


    <script>
        function obtenerEstadoSeleccionado(fila) {
            // Obtiene el valor del select en la fila especificada
            var estadoSeleccionado = fila.querySelector('select').value;
            var idPedido = fila.querySelector('button').getAttribute('data-id_pedido');
            window.location.href ='../controladores/PedidosControlador.php?accion=modificarEstado&estado='+estadoSeleccionado+ '&id_pedido=' + idPedido;
            //alert("El estado seleccionado en esta fila es: " + estadoSeleccionado);            
        }
    </script>
</body>
</html>
