<?php
require_once __DIR__ . '/../controladores/PedidosControlador.php';

// Validar el parámetro de entrada
$id_pedido = $_GET['id_pedido'] ?? null;
if (!$id_pedido || !is_numeric($id_pedido)) {
    die('ID de pedido no especificado o inválido.');
}

$controlador = new PedidosControlador();
$pedido = $controlador->seguimientoPedido($id_pedido);

// Verificar si ocurrió un error al obtener los datos del pedido
if (isset($pedido['error'])) {
    die($pedido['error']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Pedido</title>
    <link rel="stylesheet" href="../css/seguimiento.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Seguimiento de Pedido</h1>
            <p>Número de pedido: <strong>#IMP<?= htmlspecialchars($id_pedido) ?></strong></p>
        </div>
        <div class="timeline">
            <div class="step <?= $pedido['estado'] === 'pendiente' ? 'active' : '' ?>">
                <div class="icon">1</div>
                <p>Pendiente</p>
            </div>
            <div class="line"></div>
            <div class="step <?= $pedido['estado'] === 'asignado' ? 'active' : '' ?>">
                <div class="icon">2</div>
                <p>Asignado</p>
            </div>
            <div class="line"></div>
            <div class="step <?= $pedido['estado'] === 'procesando' ? 'active' : '' ?>">
                <div class="icon">3</div>
                <p>Procesando</p>
            </div>
            <div class="line"></div>
            <div class="step <?= $pedido['estado'] === 'completado' ? 'active' : '' ?>">
                <div class="icon">4</div>
                <p>Completado</p>
            </div>
        </div>
        <div class="messages">
            <?php if ($pedido['estado'] === 'pendiente'): ?>
                <div class="message">
                    <h3>Pendiente</h3>
                    <p>Su pedido está pendiente a la revisión, por favor espere algunos minutos.</p>
                </div>
            <?php elseif ($pedido['estado'] === 'asignado'): ?>
                <div class="message">
                    <h3>Asignado</h3>
                    <p>Su pedido fue asignado al Diseñador 
                        <?= htmlspecialchars($pedido['nombre_disenador'] . ' ' . $pedido['apellido_disenador']) ?>. 
                        Para más información, comuníquese al número 
                        <?= htmlspecialchars($pedido['celular']) ?>.
                    </p>
                </div>
            <?php elseif ($pedido['estado'] === 'procesando'): ?>
                <div class="message">
                    <h3>Procesando</h3>
                    <p>Su pedido está siendo procesado por nuestro equipo. Estará listo para envío próximamente.</p>
                </div>
            <?php elseif ($pedido['estado'] === 'completado'): ?>
                <div class="message">
                    <h3>Completado</h3>
                    <p>¡Su pedido ha sido entregado satisfactoriamente! Agradecemos su preferencia. Si tiene alguna consulta o necesita asistencia adicional, no dude en contactarnos.</p>
                </div>
            <?php endif; ?>
        </div>

        <button class="btn-volver" onclick="window.location.href='mispedidos.php';">
            <i class="fas fa-arrow-left"></i> Volver a Mis Pedidos
        </button>
    </div>
</body>
</html>
