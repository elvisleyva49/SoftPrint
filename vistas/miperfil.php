<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
    exit();
}

require __DIR__ . '/../modelos/ClsUsuario.php';
require __DIR__ . '/../modelos/ClsCliente.php';
require __DIR__ . '/../config/conexion.php';

$baseDeDatos = new BaseDeDatos();
$db = $baseDeDatos->obtenerConexion(); // Obtener la conexión a la base de datos
$usuario = new ClsUsuario($db);
$cliente = new ClsCliente($db);

// Obtener los datos del cliente
$idUsuario = $_SESSION['usuario'];
$datosCliente = $cliente->obtenerDatosCliente($idUsuario); // Método para obtener los datos del cliente

if (!$datosCliente) {
    echo "No se encontraron datos para el cliente.";
    exit();
}

// Extraer datos del cliente
$nombre = $datosCliente['nombre'];
$apellido = $datosCliente['apellido'];
$dni = $datosCliente['dni'];
$celular = $datosCliente['celular'];
$direccion = $datosCliente['direccion'];
$nombreUbigeo = $datosCliente['DESCRIPCION']; // Descripción del ubigeo
$provincia = $datosCliente['PROVINCIA']; // Provincia
$departamento = $datosCliente['DEPARTAMENTO']; // Departamento
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    
    <!-- Estilos y fuentes -->
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="../css/barranavegacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilo específico para la página de perfil */
        #perfil-page {
            background-color: hsl(0, 0%, 75%);
        }

        /* Contenedor principal */
        #perfil-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Tarjetas */
        #perfil-container .card {
            background-color: #fff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        /* Imagen del perfil centrada */
        #perfil-container .card img {
            border-radius: 50%;
            width: 250px;
            height: 250px;
            object-fit: cover;
            display: block;
            margin: 0 auto; /* Centra la imagen */
        }

        /* Texto centrado */
        #perfil-container .card h3,
        #perfil-container .card p {
            text-align: center;
            color: #333;
            margin: 10px 0;
        }

        /* Información personal y ubicación */
        #perfil-container .info-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Sección de información */
        #perfil-container .info-group {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            text-align: center; /* Centra el contenido */
        }

        #perfil-container .info-group h4 {
            font-size: 22px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        #perfil-container .info-group p {
            font-size: 18px;
            color: #555;
        }

        /* Botones */
        #perfil-container .text-center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        #perfil-container .btn {
            font-size: 18px;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        #perfil-container .btn i {
            margin-right: 8px;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            #perfil-container {
                padding: 20px;
            }

            #perfil-container .card {
                width: 100%;
            }
        }
    </style>
</head>
<body id="perfil-page">
    <?php include('../vistas/barranavegacion2.php'); ?>

    <div id="perfil-container">
        <br>
        <!-- Tarjeta de perfil -->
        <div class="card text-center">
            <img src="../img/perfil.png" alt="Perfil">
            <p class="lead">Bienvenido Usuario:</p>
            <h3 class="font-weight-bold">
                <?php echo htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellido); ?>
            </h3>
        </div>

        <!-- Tarjeta de información -->
        <div class="card info-section">
            <div class="info-group">
                <h4><i class="fas fa-info-circle"></i> Información Personal</h4>
                <p><strong>DNI:</strong> <?php echo htmlspecialchars($dni); ?></p>
                <p><strong>Celular:</strong> <?php echo htmlspecialchars($celular); ?></p>
                <p><strong>Dirección:</strong> <?php echo htmlspecialchars($direccion); ?></p>
            </div>
            <div class="info-group">
                <h4><i class="fas fa-map-marker-alt"></i> Ubicación</h4>
                <p><strong>Ubigeo:</strong> <?php echo htmlspecialchars($nombreUbigeo); ?></p>
                <p><strong>Provincia:</strong> <?php echo htmlspecialchars($provincia); ?></p>
                <p><strong>Departamento:</strong> <?php echo htmlspecialchars($departamento); ?></p>
            </div>
        </div>

        <!-- Botón de acción -->
        <div class="text-center">
            <a href="editar_perfil.php" class="btn">
                <i class="fas fa-edit"></i> Editar Perfil
            </a>
        </div>
    </div>


    <!-- Script animación de scroll-->
    <script>
        const nav = document.querySelector('.nav');
        window.addEventListener('scroll', function(){
            nav.classList.toggle('active', window.scrollY > 0);
        });
    </script>
    <script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>

    <script type="text/javascript">
    (function(d, t) {
        var v = d.createElement(t), s = d.getElementsByTagName(t)[0];
        v.onload = function() {
            window.voiceflow.chat.load({
            verify: { projectID: '672ae3e41891ba0bf93f64a6' },
            url: 'https://general-runtime.voiceflow.com',
            versionID: 'production'
            });
        }
        v.src = "https://cdn.voiceflow.com/widget/bundle.mjs"; v.type = "text/javascript"; s.parentNode.insertBefore(v, s);
    })(document, 'script');
    </script>

</body>
</html>
<?php include('../vistas/piepagina.php'); ?>
