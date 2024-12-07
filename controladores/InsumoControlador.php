<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/ClsInsumo.php';

class InsumoControlador {
    private $conexion;
    private $insumo;

    public function __construct() {
        $baseDeDatos = new BaseDeDatos();
        $this->conexion = $baseDeDatos->obtenerConexion();
        $this->insumo = new ClsInsumo($this->conexion);
    }

    public function registrarInsumo() {
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $descripcion = trim($_POST['descripcion']);
            $precio_compra = (float)$_POST['precio_compra'];
            $stock = 0;

            if ($this->insumo->insertarInsumo($descripcion, $stock, $precio_compra)) {
                $mensaje = "Registro exitoso.";
                header("Location: ../vistas/menu_ingreso.php");
                exit();
            } else {
                $mensaje = "Error al registrar insumo e ingreso.";
            }
        }

        return $mensaje;
    }

    public function registrarIngreso() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_insumo = $_POST['id_insumo'];
            $id_proveedor = $_POST['id_proveedor'];
            $cantidad = $_POST['cantidad'];
            $costo_unitario = $_POST['costo_unitario'];
            $observaciones = $_POST['observaciones'] ?? NULL; // Puede ser nulo
    
            // Insertar el ingreso en la base de datos
            $this->insumo->insertarIngreso($id_insumo, $id_proveedor, $cantidad, $costo_unitario, $observaciones);
            
            // Redirigir después de la inserción
            header("Location: ../vistas/menu_ingreso.php");
            exit();
        }
    }

    public function listarInsumos() {
        return $this->insumo->obtenerInsumos();
    }

    public function obtenerHistorialIngresos() {
        return $this->insumo->obtenerHistorialIngresos();
    }

}

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $controlador = new InsumoControlador();
    
    if ($accion == 'registrarIngreso') {
        $controlador->registrarIngreso();
    } elseif ($accion == 'registrarInsumo') {
        $controlador->registrarInsumo();
    } elseif ($accion == 'listarInsumos') {
        $controlador->listarInsumos();
    } elseif ($accion == 'obtenerHistorialIngresos') {
        $controlador->obtenerHistorialIngresos();
    } else {
        echo "Acción no válida.";
    }
}
?>
