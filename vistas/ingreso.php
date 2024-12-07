<?php
require_once '../controladores/ProveedorControlador.php';

$proveedorControlador = new ProveedorControlador();
$proveedores = $proveedorControlador->cargarProveedores();
$id_insumo = $_GET['id_insumo'] ?? null;

if (!$id_insumo) {
    header('Location: registrar_ingreso.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Proveedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Establecer la fuente para todo el contenido de la página */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            color: #002c5f;
            margin: 0;
            padding: 0;
            height: 100vh; /* Aseguramos que ocupe toda la altura de la ventana */
            display: flex;
            justify-content: center; /* Centrado horizontal */
            align-items: center; /* Centrado vertical */
        }

        /* Estilos específicos para esta página */
        .container {
            background: white;
            padding: 40px; /* Aumentar el padding para hacerlo más grande */
            width: 100%;
            max-width: 800px; /* Aumentamos el tamaño máximo */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #003f7f;
            margin-bottom: 30px;
        }

        label {
            font-size: 18px; /* Aumentamos el tamaño de la fuente */
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        select {
            width: 100%;
            padding: 12px; /* Aumentamos el padding */
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px; /* Aumentamos el tamaño de la fuente */
            color: #333;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        .button-group button {
            background-color: #0044cc;
            color: white;
            border: none;
            padding: 14px 25px; /* Aumentamos el tamaño del botón */
            font-size: 18px; /* Aumentamos el tamaño de la fuente */
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
        }

        .button-group button:hover {
            background-color: #0036a3;
        }

        .button-group button i {
            font-size: 20px; /* Aumentamos el tamaño del icono */
        }

        .button-group button[type="button"] {
            background-color: #6c757d;
        }

        .button-group button[type="button"]:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body class="ingreso-page">
    <div class="container">
        <h1>Seleccionar Proveedor</h1>
        <form action="nuevo_ingreso.php" method="POST">
            <label for="id_proveedor">Selecciona un proveedor:</label>
            <select name="id_proveedor" id="id_proveedor" required>
                <option value="">Seleccione un proveedor</option>
                <?php foreach ($proveedores as $proveedor): ?>
                    <option value="<?= htmlspecialchars($proveedor['id_proveedor']); ?>">
                        <?= htmlspecialchars($proveedor['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="id_insumo" value="<?= htmlspecialchars($id_insumo); ?>">
            <div class="button-group">
                <button type="submit"><i class="fas fa-check-circle"></i> Siguiente</button>
                <button type="button" onclick="window.location.href='/vistas/menu_ingreso.php'"><i class="fas fa-undo"></i> Regresar</button>
            </div>
        </form>
    </div>
</body>
</html>
