<?php
session_start(); // Inicia la sesión
// Incluye el controlador necesario
require_once __DIR__ . '/../controladores/PedidosControlador.php';

// Inicializa el controlador
$pedidoControlador = new PedidosControlador();

// Verifica que el id_cliente esté presente en la sesión
if (!isset($_SESSION['id_cliente'])) {
    // Si no está logueado, redirige al login
    header('Location: login.php');
    exit;
}

// Obtén el id_cliente de la sesión
$id_cliente = $_SESSION['id_cliente'];

// Llama al método para obtener los pedidos del cliente
$pedidosporcliente = $pedidoControlador->mostrarPedidosporcliente($id_cliente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="../css/mispedidos.css">
    <link rel="stylesheet" href="../css/pagar.css">
    <!-- Incluir Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Mis Pedidos</h1>
    <?php if (count($pedidosporcliente) > 0): ?>
        <table>
            <tr>
                <th>Nombre Cliente</th>
                <th>Apellido Cliente</th>
                <th>Descripción</th>
                <th>Fecha Pedido</th>
                <th>Monto</th>
                <th>Pagado</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($pedidosporcliente as $pedido): ?>
                <tr>
                    <td><?= htmlspecialchars($pedido['nombre_cliente']) ?></td>
                    <td><?= htmlspecialchars($pedido['apellido_cliente']) ?></td>
                    <td><?= htmlspecialchars($pedido['descripcion']) ?></td>
                    <td><?= $pedido['fecha_pedido'] ?></td>
                    <td><?= $pedido['total'] ?></td>
                    <td>
                        <?php if ($pedido['pagado'] == 1): ?>
                            Sí
                        <?php else: ?>
                            <a href="culqi.php?id_pedido=<?= $pedido['id_pedido'] ?>&monto=<?= $pedido['total'] ?>" class="pagar">
                                <div class="container">
                                    <div class="left-side">
                                    <div class="card">
                                    <div class="card-line"></div>
                                    <div class="buttons"></div>
                                    </div>
                                    <div class="post">
                                    <div class="post-line"></div>
                                    <div class="screen">
                                        <div class="dollar">$</div>
                                    </div>
                                    <div class="numbers"></div>
                                    <div class="numbers-line2"></div>
                                    </div>
                                    </div>
                                    <div class="right-side">
                                    <div class="new">Pagar Aqui</div>
                                    
                                    <svg viewBox="0 0 451.846 451.847" height="512" width="512" xmlns="http://www.w3.org/2000/svg" class="arrow"><path fill="#cfcfcf" data-old_color="#000000" class="active-path" data-original="#000000" d="M345.441 248.292L151.154 442.573c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744L278.318 225.92 106.409 54.017c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.287 194.284c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373z"></path></svg>
                                    
                                    </div>
                                </div>
                            </a>



                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="seguimiento.php?accion=seguimientoPedido&id_pedido=<?= $pedido['id_pedido'] ?>" class="seguimiento">
                            <i class="fas fa-shipping-fast"></i> Seguimiento
                        </a>
                        <a href="detalle_pedido.php?accion=verDetallePedido&id_pedido=<?= $pedido['id_pedido'] ?>" class="detalle">
                            <i class="fas fa-info-circle"></i> Detalle Pedido
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <div style="margin-bottom: 20px;">
        <button onclick="location.href='/'" class="btn-volver">
            <i class="fas fa-home"></i> Volver al Inicio
        </button>
    </div>
    <?php else: ?>
        <p>No se encontraron pedidos pendientes.</p>
    <?php endif; ?>
</body>
</html>

