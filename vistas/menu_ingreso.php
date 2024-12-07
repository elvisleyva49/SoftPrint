<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Ingreso de Insumos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos específicos para este PHP */
        body.menu-ingreso {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1c2331;
            margin: 0;
            padding: 0;
        }

        .menu-ingreso .container-fluid {
            display: flex;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .menu-ingreso .sidebar {
            width: 250px;
            background-color: #1d2124;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px 0;
            left: 0; /* Asegura que se pegue al borde izquierdo */
            margin: 0; /* Elimina cualquier margen adicional */
        }

        .menu-ingreso .sidebar .logo {
            text-align: center;
            margin-bottom: 50px;
            margin-top: 50px;
        }

        .menu-ingreso .sidebar .logo img {
            width: 90%; /* Ajusta el tamaño del logo */
            max-width: 180px; /* Limita el tamaño máximo del logo */
        }

        .menu-ingreso .sidebar .nav-item {
            margin-bottom: 15px; /* Separa más las opciones del menú */
        }

        .menu-ingreso .sidebar .nav-link {
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            transition: background-color 0.3s ease;
        }

        .menu-ingreso .sidebar .nav-link:hover {
            background-color: #2a2f36; /* Color más claro al pasar el mouse */
            color: #0d6efd; /* Color de texto al pasar el mouse */
            border-radius: 5px; /* Agregar bordes redondeados en el hover */
        }

        .menu-ingreso .sidebar .nav-link i {
            margin-right: 10px;
        }

        .menu-ingreso .main-content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }

        .menu-ingreso .card {
            border: 2px solid #0d6efd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: 100vh;
        }

        .menu-ingreso .card-header {
            background-color: #0d6efd;
            color: white;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }

        .menu-ingreso .card-header i {
            margin-right: 10px;
        }

        .menu-ingreso .btn {
            background-color: #0d6efd;
            color: white;
            border: 2px solid #0d6efd;
            padding: 10px 20px;
            font-size: 1rem;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            width: 100%;
        }

        .menu-ingreso .btn:hover {
            background-color: white;
            color: #0d6efd;
        }

        .menu-ingreso .btn i {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .menu-ingreso .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .menu-ingreso .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="menu-ingreso">
<div class="container-fluid">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0);" onclick="loadContent('registrar_ingreso.php')">
                    <i class="fas fa-plus"></i> Registrar Ingresos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);" onclick="loadContent('historial_ingreso.php')">
                    <i class="fas fa-history"></i> Historial de Ingresos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);" onclick="loadContent('nuevo_prov.php')">
                    <i class="fas fa-truck"></i> Registrar Proveedor
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);">
                    <i class="fas fa-chart-bar"></i> Ver Reportes
                </a>
                <ul class="nav flex-column ms-3"> <!-- Sub-opciones debajo de Reportes -->
                    <li class="nav-item">
                        <a class="nav-link" href="/vistas/reportes.php?tipo=ventas_diarias">
                            <i class="fas fa-calendar-day"></i> Ventas Diarias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vistas/reportes.php?tipo=metodos_pago">
                            <i class="fas fa-credit-card"></i> Métodos de Pago
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vistas/reportes.php?tipo=ventas_mensuales">
                            <i class="fas fa-calendar-alt"></i> Ventas Mensuales
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/index.php">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </li>
        </ul>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cogs"></i> Menú de Ingreso de Insumos
            </div>
            <div class="card-body" id="content-area">
                <!-- Aquí irá el contenido dinámico según la opción seleccionada -->
                <h3>Bienvenido a la opción seleccionada</h3>
                <p>Haz clic en el menú de la izquierda para navegar entre las diferentes opciones.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Función para cargar contenido dinámicamente en el área principal
    function loadContent(page) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', page, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('content-area').innerHTML = xhr.responseText;
            } else {
                document.getElementById('content-area').innerHTML = '<p>Error al cargar el contenido.</p>';
            }
        };
        xhr.send();
    }
</script>
</body>
</html>
