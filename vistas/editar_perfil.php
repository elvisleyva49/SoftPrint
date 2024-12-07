<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
    exit();
}

require __DIR__ . '/../modelos/ClsCliente.php';
require __DIR__ . '/../config/conexion.php';

$baseDeDatos = new BaseDeDatos();
$db = $baseDeDatos->obtenerConexion(); // Obtener la conexión a la base de datos
$cliente = new ClsCliente($db);

// Obtener el ID del usuario desde la sesión
$idUsuario = $_SESSION['usuario'];

// Obtener los datos del cliente
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Cargar FontAwesome -->
    <style>
        /* Fondo principal */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #383838;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Fondo con colores en el body */
        body {
            background: linear-gradient(
                135deg,
                #121212 25%,
                #1a1a1a 25%,
                #1a1a1a 50%,
                #121212 50%,
                #121212 75%,
                #1a1a1a 75%,
                #1a1a1a
            );
            background-size: 40px 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100vw;
            animation: move 4s linear infinite;
        }

        @keyframes move {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 40px 40px;
            }
        }

        /* Estilos del formulario */
        form {
            background-color: rgba(0, 0, 0, 0.7); 
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: #fff;
            text-align: center;
        }

        form h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #fff;
        }

        form .input-group {
            margin-bottom: 15px;
        }

        form label {
            margin-top:20px;
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #ddd;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form textarea {
            width: 95%;
            padding: 12px;
            border: 2px solid #444;
            border-radius: 8px;
            background-color: #222;
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="password"]:focus,
        form textarea:focus {
            border-color: #041291; 
            background-color: #333;
        }

        form button {
            margin-top: 40px;
            width: 100%;
            padding: 15px;
            background-color: #041291;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }

        form button i {
            margin-right: 10px; 
        }

        form button:hover {
            background-color: #030a67; 
        }

        form .error-message {
            color: #ff4747;
            font-size: 14px;
            margin-bottom: 10px;
        }

        form .success-message {
            color: #4caf50;
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Responsividad para dispositivos móviles */
        @media (max-width: 600px) {
            form {
                width: 90%;
                padding: 20px;
            }

            form h2 {
                font-size: 22px;
            }

            form input[type="text"],
            form input[type="email"],
            form input[type="password"],
            form textarea {
                font-size: 14px;
            }

            form button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<form action="../controladores/ClienteControlador.php?accion=actualizar" method="POST">
    <h2>Actualizacion Datos</h2>
    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($idUsuario); ?>">

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>

    <label for="dni">DNI:</label>
    <input type="text" name="dni" id="dni" value="<?php echo htmlspecialchars($dni); ?>" required>

    <label for="celular">Celular:</label>
    <input type="text" name="celular" id="celular" value="<?php echo htmlspecialchars($celular); ?>" required>

    <label for="direccion">Dirección:</label>
    <input type="text" name="direccion" id="direccion" value="<?php echo htmlspecialchars($direccion); ?>">

    <button type="submit"><i class="fas fa-save"></i>Actualizar</button> 
</form>

</body>
</html>
