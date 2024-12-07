<?php
require_once __DIR__ . '/../modelos/ClsProveedor.php';
require_once __DIR__ . '/../config/conexion.php';

class ProveedorControlador {
    private $conexion;
    private $proveedor;

    public function __construct() {
        $baseDeDatos = new BaseDeDatos();
        $this->conexion = $baseDeDatos->obtenerConexion();
        $this->proveedor = new ClsProveedor($this->conexion);
    }

    public function cargarProveedores() {
        return $this->proveedor->obtenerProveedores(); // Obtiene la lista de proveedores
    }

    public function registrarProveedor() {
        $mensaje = ""; // Variable para el mensaje

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recibir y validar datos del formulario
            $nombre = trim($_POST['nombre']);
            $ruc = trim($_POST['ruc']);
            $celular = trim($_POST['celular']);
            $email = trim($_POST['email']);
            $direccion = trim($_POST['direccion']);

            // Validación simple
            if (empty($nombre) || empty($ruc) || empty($celular) || empty($email) || empty($direccion)) {
                $mensaje = "Todos los campos son obligatorios.";
            } else {
                // Registrar el proveedor
                if ($this->proveedor->registrarProveedor($nombre, $ruc, $celular, $email, $direccion)) {
                    $mensaje = "Proveedor registrado exitosamente.";
                    header("Location: /vistas/menu_ingreso.php");
                    exit();
                } else {
                    $mensaje = "Error al registrar el proveedor.";
                }

            }
        }
        return $mensaje;
    }
}

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $controlador = new ProveedorControlador();
    
    if ($accion == 'registrarProveedor') {
        $controlador->registrarProveedor();
    } else {
        
    }
}
?>
