<?php

$llave_privada = "sk_test_766697c164a13c6c";

// Establecer la zona horaria a Lima, Perú
date_default_timezone_set('America/Lima');

function obtenerDatosCulqi($endpoint) {
    global $llave_privada;

    $ch = curl_init("https://api.culqi.com/v2/" . $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $llave_privada,
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

$tipo_reporte = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$datos = [];

if ($tipo_reporte) {
    $charges = obtenerDatosCulqi('charges?limit=100');
    $datos = $charges['data'] ?? [];
}

$ventas_por_dia = [];
$ventas_por_mes = [];
$fechas = [];

// Filtrar las ventas del último mes y agruparlas por día
foreach ($datos as $dato) {
    $timestamp = isset($dato['creation_date']) ? ($dato['creation_date'] / 1000) : time();
    $fecha = date('Y-m-d', $timestamp);
    $mes = date('Y-m', $timestamp);
    
    // Ventas diarias
    if (!isset($ventas_por_dia[$fecha])) {
        $ventas_por_dia[$fecha] = 0;
        $fechas[] = $fecha; // Guardar fechas para el eje x
    }
    
    if (isset($dato['outcome']['type']) && $dato['outcome']['type'] === 'venta_exitosa') {
        $ventas_por_dia[$fecha] += ($dato['amount'] ?? 0) / 100; // Convertir a PEN
    }

    // Ventas mensuales
    if (!isset($ventas_por_mes[$mes])) {
        $ventas_por_mes[$mes] = 0;
    }
    if (isset($dato['outcome']['type']) && $dato['outcome']['type'] === 'venta_exitosa') {
        $ventas_por_mes[$mes] += ($dato['amount'] ?? 0) / 100; // Convertir a PEN
    }
}

// Agrupar por métodos de pago
$metodos_pago = [];
foreach ($datos as $dato) {
    if (isset($dato['source']['iin']['card_brand'])) {
        $metodo = $dato['source']['iin']['card_brand'];
    } else {
        $metodo = 'Yape';
    }

    if (!isset($metodos_pago[$metodo])) {
        $metodos_pago[$metodo] = 0;
    }

    if (isset($dato['outcome']['type']) && $dato['outcome']['type'] === 'venta_exitosa') {
        $metodos_pago[$metodo] += 1; // Contar la transacción exitosa
    }
}

$metodos_labels = array_keys($metodos_pago);
$metodos_values = array_values($metodos_pago);

// Obtener las últimas 30 fechas
$hoy = new DateTime();
$hace_un_mes = (clone $hoy)->modify('-30 days');

$fechas_finales = [];
$ventas_finales = [];

for ($i = 0; $i < 30; $i++) {
    $fecha_actual = $hace_un_mes->modify('+1 day')->format('Y-m-d');
    $fechas_finales[] = $fecha_actual;
    $ventas_finales[] = $ventas_por_dia[$fecha_actual] ?? 0; // Sumar ventas o 0 si no hay ventas
}

// Obtener las últimas 12 fechas para ventas mensuales
$hace_un_ano = (clone $hoy)->modify('-1 year');
$fechas_mensuales = [];
$ventas_mensuales = [];

for ($i = 0; $i < 12; $i++) {
    $fecha_actual = $hace_un_ano->modify('+1 month')->format('Y-m');
    $fechas_mensuales[] = $fecha_actual;
    $ventas_mensuales[] = $ventas_por_mes[$fecha_actual] ?? 0; // Sumar ventas o 0 si no hay ventas
}

// Asegúrate de que las fechas estén en orden
$fechas_finales = array_reverse($fechas_finales);
$ventas_finales = array_reverse($ventas_finales);

$fechas_mensuales = array_reverse($fechas_mensuales);
$ventas_mensuales = array_reverse($ventas_mensuales);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes Financieros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Reportes Financieros</h2>
        <!--<div class="row mb-4">
            <div class="col-md-4">
                <a href="reportes.php?tipo=ventas_diarias" class="btn btn-primary btn-block">Ventas Diarias</a>
            </div>
            <div class="col-md-4">
                <a href="?tipo=metodos_pago" class="btn btn-success btn-block">Métodos de Pago</a>
            </div>
            <div class="col-md-4">
                <a href="?tipo=ventas_mensuales" class="btn btn-info btn-block">Ventas Mensuales</a>
            </div>
        </div>-->

        <?php if ($tipo_reporte): ?>
            <div class="card">
                <div class="card-body">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>

            <div class="mt-4">
                <h4>Datos Detallados</h4>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Método de Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datos as $dato): ?>
                            <tr>
                                <td><?php 
                                    $timestamp = isset($dato['creation_date']) ? ($dato['creation_date'] / 1000) : time();
                                    echo date('d/m/Y H:i:s', $timestamp);
                                ?></td>
                                <td><?php echo ($dato['amount'] ?? 0)/100; ?> <?php echo $dato['currency_code'] ?? 'PEN'; ?></td>
                                <td><?php 
                                    if (isset($dato['outcome']['type'])) {
                                        echo $dato['outcome']['type'] === 'venta_exitosa' ? 'Exitoso' : $dato['outcome']['type'];
                                    } else {
                                        echo 'Fallido';
                                    }
                                ?></td>
                                <td><?php 
                                    if (isset($dato['source']['iin']['card_brand'])) {
                                        echo $dato['source']['iin']['card_brand'] . ' - ' . 
                                             ($dato['source']['iin']['card_type'] ?? 'No especificado');
                                    } elseif (isset($dato['source']['type'])) {
                                        echo $dato['source']['type'];
                                    } else {
                                        echo 'Yape';
                                    }
                                ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12 text-center">
                <a href="/vistas/menu_ingreso.php" class="btn btn-secondary">Regresar</a>
            </div>
        </div>

    </div>

    <script>
        <?php if ($tipo_reporte == 'ventas_diarias'): ?>
        const ctx = document.getElementById('reportChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($fechas_finales); ?>,
                datasets: [{
                    label: 'Ventas Diarias (PEN)',
                    data: <?php echo json_encode($ventas_finales); ?>,
                    backgroundColor: 'rgb(75, 192, 192)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        <?php elseif ($tipo_reporte == 'metodos_pago'): ?>
        const ctx3 = document.getElementById('reportChart').getContext('2d');
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($metodos_labels); ?>,
                datasets: [{
                    label: 'Métodos de Pago',
                    data: <?php echo json_encode($metodos_values); ?>,
                    backgroundColor: ['#FF9999', '#66B2FF', '#99FF99', '#FFCC99'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
            }
        });
        
        <?php elseif ($tipo_reporte == 'ventas_mensuales'): ?>
        const ctx2 = document.getElementById('reportChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($fechas_mensuales); ?>,
                datasets: [{
                    label: 'Ventas Mensuales (PEN)',
                    data: <?php echo json_encode($ventas_mensuales); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>
