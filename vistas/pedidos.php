<?php
session_start();
require_once __DIR__ . '/../controladores/PedidosControlador.php';
require_once __DIR__ . '/../controladores/UsuarioControlador.php';
require_once __DIR__ . '/../controladores/ControladorPedido.php';

$pedidoControlador = new PedidosControlador();
$pedidos = $pedidoControlador->mostrarPedidos();
$usuarioControlador = new UsuarioControlador();
$usuarios = $usuarioControlador->cargarTrabajadores();

// Verificar que $pedidos y $usuarios sean arrays
if (!is_array($pedidos)) {
    die('Error: Los pedidos no están en el formato correcto');
}
if (!is_array($usuarios)) {
    die('Error: Los usuarios no están en el formato correcto');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos Pendientes</title>
    <link rel="stylesheet" href="../css/mispedidos.css">
</head>
<body>
    <h1>Pedidos Pendientes</h1>
    
    <?php if (!empty($pedidos) && is_array($pedidos)): ?>
        <form id="asignar-form" action="../controladores/ControladorPedido.php?accion=asignarTrabajador" method="POST">
            <table border="1">
                <tr>
                    <th>Nombre Cliente</th>
                    <th>Apellido Cliente</th>
                    <th>Descripción</th>
                    <th>Fecha Pedido</th>
                    <th>Estado</th>
                    <th>Asignar</th>
                </tr>
                <?php foreach ($pedidos as $pedido): ?>
                    <?php if (is_array($pedido)): ?>
                    <tr>
                        <td><?= htmlspecialchars($pedido['nombre_cliente'] ?? '') ?></td>
                        <td><?= htmlspecialchars($pedido['apellido_cliente'] ?? '') ?></td>
                        <td><?= htmlspecialchars($pedido['descripcion'] ?? '') ?></td>
                        <td><?= htmlspecialchars($pedido['fecha_pedido'] ?? '') ?></td>
                        <td><?= htmlspecialchars($pedido['estado'] ?? '') ?></td>
                        <td>
                            <select name="trabajadores[<?= htmlspecialchars($pedido['id_pedido'] ?? '') ?>]" class="trabajador-select">
                                <option value="">Selecciona un trabajador</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <?php if (is_array($usuario)): ?>
                                    <option value="<?= htmlspecialchars($usuario['id_empleado'] ?? ''); ?>">
                                        <?= htmlspecialchars(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellido'] ?? '')); ?>
                                    </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
            
            <div>
                <button type="submit">Asignar Trabajadores</button>
            </div>
            <div>
                <br>
                <button type="button" onclick="window.location.href='/';">Cancelar</button>
            </div>
        </form>
    <?php else: ?>
        <p>No se encontraron pedidos pendientes.</p>
    <?php endif; ?>

    <script>
        document.getElementById('asignar-form').addEventListener('submit', function (e) {
            const selects = document.querySelectorAll('.trabajador-select');
            let hasSelection = false;

            selects.forEach(select => {
                if (select.value !== '') {
                    hasSelection = true;
                }
            });

            if (!hasSelection) {
                e.preventDefault();
                alert('Por favor, selecciona al menos un trabajador para asignar.');
            }
        });
    </script>
</body>
</html>