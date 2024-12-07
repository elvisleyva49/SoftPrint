<?php
require_once '../controladores/InsumoControlador.php';

$insumoControlador = new InsumoControlador();
$historialIngresos = $insumoControlador->obtenerHistorialIngresos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ingresos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .historial-ingresos-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #002c5f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .historial-ingresos-container .container {
            background: white;
            padding: 30px;
            width: 100%;
        }

        .historial-ingresos-container h1 {
            color: #003f7f;
            text-align: center;
            margin-bottom: 30px;
        }

        .historial-ingresos-container .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .historial-ingresos-container .table th,
        .historial-ingresos-container .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .historial-ingresos-container .table th {
            background-color: #0044cc;
            color: white;
        }

        .historial-ingresos-container .table tbody tr:nth-child(odd) {
            background-color: #f3f7fc;
        }

        .historial-ingresos-container .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }

        .historial-ingresos-container .buttons-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .historial-ingresos-container .button {
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

        .historial-ingresos-container .button:hover {
            background-color: #0036a3;
            color: white;
        }
    </style>
</head>
<body>
    <div class="historial-ingresos-container">
        <div class="container">
            <h1>Historial de Ingresos</h1>
            <?php if (!empty($historialIngresos)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Ingreso</th>
                            <th>Insumo</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Costo Total</th>
                            <th>Observaciones</th>
                            <th>Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historialIngresos as $ingreso): ?>
                            <tr>
                                <td><?= htmlspecialchars($ingreso['id_ingreso']); ?></td>
                                <td><?= htmlspecialchars($ingreso['insumo']); ?></td>
                                <td><?= htmlspecialchars($ingreso['fecha']); ?></td>
                                <td><?= htmlspecialchars($ingreso['cantidad']); ?></td>
                                <td><?= htmlspecialchars($ingreso['costo_unitario']); ?></td>
                                <td><?= htmlspecialchars($ingreso['costo_total']); ?></td>
                                <td><?= htmlspecialchars($ingreso['observaciones']); ?></td>
                                <td><?= htmlspecialchars($ingreso['proveedor']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    No hay registros de ingresos disponibles.
                </div>
            <?php endif; ?>

            <div class="buttons-container">
                <a href="/vistas/menu_ingreso.php" class="button">
                    <i class="fas fa-arrow-left"></i> Regresar al Menú
                </a>
            </div>
        </div>
    </div>
</body>
</html>
