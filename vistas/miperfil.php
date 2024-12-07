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
    <link rel="stylesheet" href="../css/miperfil.css">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <body>
    <div class="container">
    <div class="main-container">
        <!-- Sección izquierda (perfil) -->
        <div class="profile-section">
        <br><br><br><br><br>
            <div class="loader"></div>
            <br><p>Bienvenido Usuario:</p>
            <h3>
                <?php echo htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellido); ?>
            </h3>
        </div>
        
        <!-- Sección derecha (información) -->
        <div class="info-section">
            <h4><i class="fas fa-info-circle icon"></i> Información Personal</h4>
            <div class="info-group">
                <p><span>DNI:</span> <?php echo htmlspecialchars($dni); ?></p>
                <p><span>Celular:</span> <?php echo htmlspecialchars($celular); ?></p>
                <p><span>Dirección:</span> <?php echo htmlspecialchars($direccion); ?></p>
            </div>

            <h4><i class="fas fa-map-marker-alt icon"></i> Ubicación</h4>
            <div class="info-group">
                <p><span>Ubigeo:</span> <?php echo htmlspecialchars($nombreUbigeo); ?></p>
                <p><span>Provincia:</span> <?php echo htmlspecialchars($provincia); ?></p>
                <p><span>Departamento:</span> <?php echo htmlspecialchars($departamento); ?></p>
            </div>

            <div class="buttons">
                <a href="../index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Regresar</a>
                <a href="editar_perfil.php" class="edit-btn"><i class="fas fa-edit"></i> Editar Perfil</a>
            </div>
        </div>
    </div>
    </div>
</body>
</html>