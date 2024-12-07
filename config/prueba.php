<?php
require_once 'conexion.php'; // Ajusta la ruta si es necesario

// Crear una instancia de BaseDeDatos y probar la conexión
$db = new BaseDeDatos();
$conexion = $db->obtenerConexion();

if ($conexion) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar con la base de datos.";
}
?>
