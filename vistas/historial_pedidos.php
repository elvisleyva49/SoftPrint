<?php
require_once '../controladores/ControladorPedido.php';
require_once '../config/conexion.php';
$baseDeDatos = new BaseDeDatos();
$conexion = $baseDeDatos->obtenerConexion();
$controladorpedido = new ControladorPedido($conexion);
session_start();
$id_cliente = $_SESSION['id_cliente']; 
$historialpedidos = $controladorpedido->obtenerHistorialPedidos($id_cliente);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Historial de Pedidos</h1>
    </header>
    <main>
        <section>
            <h2>Lista de Pedidos</h2>
            <table border="1">
        <thead>
            <tr>
                <th>id_pedido</th>
                <th>Fecha_Pedido</th>
                <th>Estado</th>   
                <th>Total</th>
                <th>Detalle_Pedido</th>             
            </tr>
        </thead>
        <tbody id="pedidosTableBody">
        <?php foreach ($historialpedidos as $pedido): ?>
            <tr>
                <td><?= htmlspecialchars($pedido['id_pedido']); ?></td>
                <td><?= htmlspecialchars($pedido['fecha_pedido']); ?></td>
                <td><?= htmlspecialchars($pedido['estado']); ?></td>    
                <td><?= htmlspecialchars($pedido['total']); ?></td> 
                <td>
                <button onclick="obteneridpedidoSeleccionado(this.closest('tr')) "data-id_pedido="<?= $pedido['id_pedido']; ?>">Ver detalle</button>                      
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
        </section>
    
        <script>
        function obteneridpedidoSeleccionado(fila) {
            var idPedido = fila.querySelector('button').getAttribute('data-id_pedido');
            alert("El id_pedido seleccionado en esta fila es: " + idPedido);
        }
         /*   // Obtiene el valor del select en la fila especificada
            var idpedidoSeleccionado = fila.querySelector('select').value;
            var idCita = fila.querySelector('button').getAttribute('data-id_cita');
            window.location.href ='../controladores/ControladorCita.php?accion=modificarEstado&estado='+estadoSeleccionado+ '&id_cita=' + idCita;
            //alert("El estado seleccionado en esta fila es: " + estadoSeleccionado);            
        }*/
    </script>
    </main>
    
    <footer>
        <p>&copy; 2023 Softprint. Todos los derechos reservados.</p>
    </footer>
</body>
</html>