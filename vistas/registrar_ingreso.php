<?php
require_once '../controladores/InsumoControlador.php';

// Crear instancia del controlador
$insumoControlador = new InsumoControlador();
$insumos = $insumoControlador->listarInsumos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .productos-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #002c5f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .productos-container .container {
            background: white;
            padding: 30px;
            width: 100%;
        }

        .productos-container h1 {
            color: #003f7f;
            text-align: center;
            margin-bottom: 30px;
        }

        .productos-container .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .productos-container .table th, 
        .productos-container .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .productos-container .table th {
            background-color: #0044cc;
            color: white;
        }

        .productos-container .table tbody tr:nth-child(odd) {
            background-color: #f3f7fc;
        }

        .productos-container .action-link {
            color: #0044cc;
            font-weight: bold;
        }

        .productos-container .action-link:hover {
            text-decoration: underline;
        }

        .productos-container .buttons-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .productos-container .button {
            background-color: #0044cc;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            text-align: center;
        }

        .productos-container .button:hover {
            background-color: #0036a3;
            color: white;
        }
    </style>
</head>
<body>
    <div class="productos-container">
        <div class="container">
            <h1>Lista de Productos</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Insumo</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Precio de Compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($insumos): ?>
                        <?php foreach ($insumos as $insumo): ?>
                            <tr>
                                <td><?= htmlspecialchars($insumo['id_insumo']); ?></td>
                                <td><?= htmlspecialchars($insumo['descripcion']); ?></td>
                                <td><?= htmlspecialchars($insumo['stock']); ?></td>
                                <td><?= htmlspecialchars($insumo['precio_compra']); ?></td>
                                <td>
                                    <a href="ingreso.php?id_insumo=<?= htmlspecialchars($insumo['id_insumo']); ?>" class="action-link">
                                        <i class="fas fa-plus-circle"></i> Añadir Ingreso
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No hay insumos disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="buttons-container">
                <a href="/vistas/nuevo_insumo.php" class="button">
                    <i class="fas fa-plus-circle"></i> Registrar Nuevo Insumo
                </a>
            </div>
        </div>
    </div>
</body>
</html>
