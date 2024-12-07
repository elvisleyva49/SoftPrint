<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/ClsPedido.php';

class ControladorPedido {
    private $pedido;

    public function __construct() {
        // Crear una instancia de la clase BaseDeDatos
        $baseDeDatos = new BaseDeDatos();
        $db = $baseDeDatos->obtenerConexion(); // Obtener la conexión a la base de datos
        $this->pedido = new ClsPedido($db);
      //  $controladorCliente = new ControladorCliente();
    }

   /* public function registrarPedido() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fecha_pedido = $_POST['fecha_pedido'] ?? null;
            $estado = 'pendiente';
            $total = $_POST['total'] ?? null;
            $id_cliente = 1; // Cambiar por el ID correspondiente

            if (empty($fecha_pedido) || empty($total)) {
                $mensaje = "Todos los campos son obligatorios.";
            } else {
                if ($this->pedido->registrarPedido($fecha_pedido, $estado, $total, $id_cliente)) {
                    $mensaje = "Pedido registrado exitosamente.";
                } else {
                    $mensaje = "Error al registrar el pedido.";
                }
            }
            echo $mensaje;
        } else {
            echo "Método de solicitud no válido.";
        }
    }*/
    public function obtenerHistorialPedidos($id_cliente) {
        return $this->pedido->obtenerHistorialPedidos($id_cliente); // Llama al método del modelo
    }
    public function cargarDetallePedido($id_cliente) {
        return $this->pedido->cargarDetallePedido($id_cliente); // Llama al método del modelo
    }
    public function asignarTrabajador($id_empleado, $id_pedido) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trabajadores'])) {
            $trabajadoresAsignados = $_POST['trabajadores'];
    
            foreach ($trabajadoresAsignados as $id_pedido => $id_empleado) {
                if (!empty($id_empleado)) {
                    $resultado = $this->pedido->asignarTrabajador($id_empleado, $id_pedido);
                    if (!$resultado) {
                        echo "Error al asignar trabajador al pedido {$id_pedido}.<br>";
                    }
                }
            }
            echo "Trabajadores asignados correctamente.";
            header("Location: ../vistas/pedidos.php");
            exit();
        } else {
            echo "No se recibieron datos para asignar.";
        }
    }
   /* public function obtenerPedidos($fecha) {
        return $this->pedido->obtenerPedidos($fecha); // Llama al método del modelo
    }
    public function modificarEstadoPedido($idPedido,$newestado) {
        $resultado=$this->pedido->modificarEstadoPedido($idPedido,$newestado); // Llama al método del modelo
        if($resultado){
            echo "<script>alert('Estado del pedido actualizado correctamente.');</script>";
            header("Location: ../vistas/historial_pedidos.php");
            exit();
        }else{
            echo "<script>alert('Error al actualizar el estado del pedido.');</script>";
            header("Location: ../vistas/historial_pedidos.php");
            exit();
        }        
    }*/
    // Otros métodos...
}	
if (isset($_GET['accion'])) {
    $controlador = new ControladorPedido(); // Pasar la conexión al controlador
    $accion = $_GET['accion'];
    if ($accion == 'asignarTrabajador') {
        $id_pedido = $_GET['id_pedido'] ?? null;
        $id_empleado = $_GET['id_empleado'] ?? null;
        $controlador->asignarTrabajador($id_empleado, $id_pedido);
        require_once __DIR__ . '/../vistas/pedidos.php';
    }
}
?>