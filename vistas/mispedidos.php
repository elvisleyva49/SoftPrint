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
    <!-- Culqi Checkout v4 -->
    <script src="https://checkout.culqi.com/js/v4"></script>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Mis Pedidos</h1>
            <button onclick="location.href='../index.php'" class="btn-volver">
                <i class="fas fa-home"></i> Volver al Inicio
            </button>
        </div>

        <?php if (count($pedidosporcliente) > 0): ?>
            <div class="table-card">
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
                            <td>S/ <?= number_format($pedido['total'], 2) ?></td>
                            <td>
                                <?php if ($pedido['pagado'] == 1): ?>
                                    <span class="pago-si"><i class="fas fa-check-circle"></i> Sí</span>
                                <?php else: ?>
                                    <div class="pagar" onclick="pagarPedido(<?= $pedido['id_pedido'] ?>, <?= $pedido['total'] ?>)" style="cursor:pointer;">
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
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="seguimiento.php?accion=seguimientoPedido&id_pedido=<?= $pedido['id_pedido'] ?>" class="detalle" style="background-color: #f8fafc; color: #0f172a;">
                                        <i class="fas fa-shipping-fast"></i> Seguimiento
                                    </a>
                                    <a href="detalle_pedido.php?accion=verDetallePedido&id_pedido=<?= $pedido['id_pedido'] ?>" class="detalle">
                                        <i class="fas fa-info-circle"></i> Detalle
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p>No se encontraron pedidos pendientes.</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Configuración de Culqi
        Culqi.publicKey = "pk_test_4c5dd8fec33a467e";

        let currentPedidoId = null;
        let currentAmount = 0;

        function pagarPedido(id_pedido, monto) {
            currentPedidoId = id_pedido;
            // Culqi espera el monto en céntimos (ej: 25.00 -> 2500)
            currentAmount = Math.round(monto * 100); 
            
            Culqi.settings({
                title: 'Pago de Pedido',
                currency: 'PEN',
                description: 'Pago del pedido #' + id_pedido,
                amount: currentAmount,
                paymentMethods: ['card', 'yape', 'bank_transfer', 'boleto']
            });
            Culqi.open();
        }

        // Función que Culqi llama automáticamente al obtener el token
        function culqi() {
            if (Culqi.token) {
                var token = Culqi.token.id;
                var email = Culqi.token.email;

                // Crear formulario dinámicamente para enviar a ProcesoCulqi.php
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "../controladores/ProcesoCulqi.php";

                var tokenField = document.createElement("input");
                tokenField.type = "hidden";
                tokenField.name = "token";
                tokenField.value = token;

                var amountField = document.createElement("input");
                amountField.type = "hidden";
                amountField.name = "amount";
                amountField.value = currentAmount;

                var emailField = document.createElement("input");
                emailField.type = "hidden";
                emailField.name = "email";
                emailField.value = email;

                var pedidoField = document.createElement("input");
                pedidoField.type = "hidden";
                pedidoField.name = "id_pedido";
                pedidoField.value = currentPedidoId;

                form.appendChild(tokenField);
                form.appendChild(amountField);
                form.appendChild(emailField);
                form.appendChild(pedidoField);
                
                document.body.appendChild(form);
                form.submit();
            } else {
                console.error("No se obtuvo el token de Culqi");
                alert("Error: " + Culqi.error.user_message);
            }
        }
    </script>
</body>
</html>

