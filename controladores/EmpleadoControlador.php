<?php
require_once __DIR__ . '/../config/conexion.php'; // Asegúrate de incluir la conexión a la base de datos
require_once __DIR__ . '/../modelos/ClsEmpleado.php'; // Asegúrate de incluir la clase que contiene el método obtenerIdEmpleadoPorUsuario

class EmpleadoControlador {
    private $conn;
    private $empleado;

    public function __construct($db) {
        $this->conn = $db;
        $this->empleado = new ClsEmpleado($this->conn); // Instancia de ClsEmpleado con la conexión
    }

    // Método para obtener el id_empleado utilizando el id_usuario
    public function obtenerIdEmpleadoPorUsuario($id_usuario) {
        // Llama al método de la clase ClsEmpleado para obtener el id_empleado
        $id_empleado = $this->empleado->obtenerIdEmpleadoPorUsuario($id_usuario);

        // Verifica si se obtuvo un id_empleado
        if ($id_empleado !== null) {
            return $id_empleado;
        } else {
            // Si no se encuentra el id_empleado, puedes manejar el error o retornar un valor predeterminado
            return null;
        }
    }
    
}

// Crear la conexión a la base de datos
$baseDeDatos = new BaseDeDatos();
$conexion = $baseDeDatos->obtenerConexion();

// Control de la acción
if (isset($_GET['accion'])) {
    $controlador = new EmpleadoControlador($conexion); // Pasar la conexión al controlador
    $accion = $_GET['accion'];

    // Verifica qué acción se solicita
    if ($accion === 'obtenerIdEmpleado') {
        if (isset($_GET['id_usuario'])) {
            $id_usuario = $_GET['id_usuario'];
            $id_empleado = $controlador->obtenerIdEmpleadoPorUsuario($id_usuario);
            if ($id_empleado) {
                echo json_encode(['id_empleado' => $id_empleado]);
            } else {
                echo json_encode(['error' => 'Empleado no encontrado.']);
            }
        } else {
            echo json_encode(['error' => 'ID de usuario no proporcionado.']);
        }
        exit; // Asegúrate de terminar el script aquí para evitar la salida de HTML adicional
    }

    // Otros casos de acciones...
}
?>
