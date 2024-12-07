<?php
require_once __DIR__ . '/../controladores/PedidosControlador.php';

// Validar el parámetro de entrada
$id_pedido = $_GET['id_pedido'] ?? null;
if (!$id_pedido || !is_numeric($id_pedido)) {
    die('ID de pedido no especificado o inválido.');
}

$controlador = new PedidosControlador();
$datos = $controlador->verDetallePedido($id_pedido);
$mostrarAltura = false;
$mostrarAncho = false;

foreach ($datos as $fila) {
    if (isset($fila['altura']) && $fila['altura'] !== '' && $fila['altura'] != 0) {
        $mostrarAltura = true;
    }
    if (isset($fila['ancho']) && $fila['ancho'] !== '' && $fila['ancho'] != 0) {
        $mostrarAncho = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido</title>
    <!-- Enlace a Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/detalle_pedido.css"> 
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalle del Pedido</h1>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <?php if ($mostrarAltura): ?>
                        <th>Altura</th>
                    <?php endif; ?>
                    <?php if ($mostrarAncho): ?>
                        <th>Ancho</th>
                    <?php endif; ?>
                    <th>Cantidad</th>
                    <th>Insumo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos as $fila1): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila1['nombre_producto']) ?></td>
                        <td><?= htmlspecialchars($fila1['descripcion']) ?></td>
                        <?php if ($mostrarAltura): ?>
                            <td><?= htmlspecialchars($fila1['altura']) ?></td>
                        <?php endif; ?>
                        <?php if ($mostrarAncho): ?>
                            <td><?= htmlspecialchars($fila1['ancho']) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($fila1['cantidad']) ?></td>
                        <td><?= htmlspecialchars($fila1['insumo']) ?></td>
                        <td>
                        <button onclick="mostrarImagen('<?= htmlspecialchars($fila1['url_img']) ?>')">
                            <i class="fas fa-image"></i> Ver Prediseño
                        </button>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button class="btn-volver" onclick="window.location.href='mispedidos.php';">
            <i class="fas fa-arrow-left"></i> Volver a Mis Pedidos
        </button>
 

        <!-- Ventana Modal para ver la imagen -->
        <div id="modal">
            <span onclick="cerrarModal()">X</span>
            <img id="imagenModal" src="" alt="Prediseño">
        </div>
    </div>

    <script>
        // Función para mostrar la imagen en el modal
        function mostrarImagen(ruta) {
            const modal = document.getElementById('modal');
            const imagen = document.getElementById('imagenModal');
            imagen.src = ruta;
            modal.classList.add('show'); // Se muestra el modal con la imagen
        }

        // Función para cerrar el modal
        function cerrarModal() {
            const modal = document.getElementById('modal');
            modal.classList.remove('show'); // Se oculta el modal
        }
    </script>
</body>
</html>