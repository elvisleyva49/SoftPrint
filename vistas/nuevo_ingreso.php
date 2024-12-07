<?php
require_once '../controladores/InsumoControlador.php';

if (!isset($_POST['id_proveedor']) || !isset($_POST['id_insumo'])) {
    header('Location: ingreso.php');
    exit();
}

$id_proveedor = $_POST['id_proveedor'];
$id_insumo = $_POST['id_insumo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Ingreso</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos personalizados para la página */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            color: #002c5f;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            width: 100%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #003f7f;
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        .button-group button, .button-group a {
            background-color: #0044cc;
            color: white;
            border: none;
            padding: 14px 25px;
            font-size: 18px;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            text-decoration: none;
        }

        .button-group button:hover, .button-group a:hover {
            background-color: #0036a3;
        }

        .button-group button i, .button-group a i {
            font-size: 20px;
        }

        .button-group a {
            background-color: #6c757d;
        }

        .button-group a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Ingreso</h1>

        <form action="../controladores/InsumoControlador.php?accion=registrarIngreso" method="POST">
            <input type="hidden" name="action" value="registrarIngreso">
            <input type="hidden" name="id_insumo" value="<?= htmlspecialchars($id_insumo); ?>">
            <input type="hidden" name="id_proveedor" value="<?= htmlspecialchars($id_proveedor); ?>">

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" required>

            <label for="costo_unitario">Costo Unitario:</label>
            <input type="number" step="0.01" name="costo_unitario" required>

            <label for="observaciones">Observaciones:</label>
            <textarea name="observaciones"></textarea>

            <div class="button-group">
                <button type="submit">
                    <i class="fas fa-check"></i> Registrar Ingreso
                </button>
                <a href="/vistas/menu_ingreso.php" class="button">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Incluir Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
