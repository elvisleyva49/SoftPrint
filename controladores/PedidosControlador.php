<?php
require_once __DIR__ . '/../modelos/ClsPedido.php';
require_once __DIR__ . '/../modelos/ClsCliente.php';
require_once __DIR__ . '/../config/conexion.php';

class PedidosControlador {
    private $pedido;

    public function __construct() {
        $baseDeDatos = new BaseDeDatos();
        $db = $baseDeDatos->obtenerConexion();
        $this->pedido = new ClsPedido($db);
        $this->cliente = new ClsCliente($db);
    }

    public function mostrarPedidosporcliente($id_cliente) {
        $resultados = $this->pedido->obtenerPedidosporcliente($id_cliente);
        if (!$resultados) {
            return ['error' => 'Pedido no encontrado'];
        }
        return $resultados;
    }
    public function mostrarPedidosporDesigner($id_disenador) {
        $resultados = $this->pedido->obtenerPedidospordesigner($id_disenador);
        if (!$resultados) {
            return ['error' => 'No se encontraron pedidos para este diseñador'];
        }
        return $resultados;
    }
    public function mostrarPedidos() {
        $resultados = $this->pedido->obtenerPedidos();
        if (!$resultados) {
            return ['error' => 'Pedidos no encontrados'];
        }
        return $resultados;
    }
    public function seguimientoPedido($id_pedido) {
        $resultados = $this->pedido->obtenerEstadoPedido($id_pedido);
        if (!$resultados) {
            return ['error' => 'Pedido no encontrado'];
        }
        return $resultados;
    }
    public function verDetallePedido($id_pedido) {
        $resultados = $this->pedido->verDetallePedido($id_pedido);
        if (!$resultados) {
            return ['error' => 'Detalle Pedido no encontrado'];
        }
        return $resultados;
    }
    public function registrarPedido($id_cliente, $total, $product_id , $descripcion, $cantidad, $altura, $ancho, $insumo, $image_url) {
        $estado = 'pendiente';
        $id_empleado = null; 
        $fecha_pedido = date('Y-m-d H:i:s'); 
        $id_pedido = $this->pedido->insertarPedido($id_cliente, $id_empleado, $fecha_pedido, $estado, $total, $product_id, $descripcion);
        
        if (!$id_pedido) {
            return ['error' => 'Pedido no registrado'];
        }

        if (isset($_POST['image_url'])) {
            $image_url = $_POST['image_url'];
            echo "La URL de la imagen es: " . $image_url;
        } else {
            echo "No se ha recibido la URL de la imagen.";
        }
        
    
        $resultadosDetalle = $this->pedido->insertarDetallePedido($id_pedido, $product_id, $descripcion, $altura, $ancho, $cantidad, $insumo, $image_url);
        
        if (!$resultadosDetalle) {
            return ['error' => 'Detalle del pedido no registrado'];
        }

        // Descontar stock del insumo
        $resultadoStock = $this->pedido->descontarStockInsumo($insumo, $cantidad);
        
        if (!$resultadoStock) {
            return ['error' => 'No se pudo actualizar el stock del insumo.'];
        }
    
        header('Location: ../vistas/mispedidos.php');
        exit;
    
        return $resultadosDetalle;
    }
    public function modificarEstadoPedido($idPedido,$newestado) {
        $resultado=$this->pedido->modificarEstadoPedido($idPedido,$newestado); // Llama al método del modelo
        if($resultado){
            echo "<script>alert('Estado de la cita actualizado correctamente.');</script>";
            header("Location: ../vistas/pedidos_asignados.php");
            exit();
        }else{
            echo "<script>alert('Error al actualizar el estado de la cita.');</script>";
            header("Location: ../vistas/pedidos_asignados.php");
            exit();
        }        
    }
}

// Manejo de la acción
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $controlador = new PedidosControlador();
    
    if ($accion == 'listarpedidoporusuario') {
        $id_pedido = $_GET['id_pedido'] ?? null;
        $pedidosporusuario = $controlador->mostrarPedidosporcliente($id_pedido);
        require_once __DIR__ . '/../vistas/mispedidos.php';
    }
    elseif ($accion == 'listarpedidospordisenador') {
        $id_disenador = $_GET['id_disenador'] ?? null;
        $pedidosporDiseñador = $controlador->mostrarPedidosporDiseñador($id_disenador);
        if (isset($pedidosporDiseñador['error'])) {
            die($pedidosporDiseñador['error']);
        }
        require_once __DIR__ . '/../vistas/pedidospor_disenador.php';
    }
    elseif ($accion == 'seguimientoPedido') {
        $id_pedido = $_GET['id_pedido'] ?? null;
        $pedido = $controlador->seguimientoPedido($id_pedido);
        if (isset($pedido['error'])) {
            die($pedido['error']);
        }
        require_once __DIR__ . '/../vistas/seguimiento.php';
    }
    elseif ($accion == 'verDetallePedido') {
        $id_pedido = $_GET['id_pedido'] ?? null;
        $pedido = $controlador->verDetallePedido($id_pedido);
        if (isset($pedido['error'])) {
            die($pedido['error']);
        }
        //require_once __DIR__ . '/../vistas/detalle_pedido.php';
    }
    elseif ($accion == 'registrarPedido') {
        $id_cliente = $_POST['id_cliente'];
        $total = $_POST['total'];
        $product_id = $_POST['id_producto'];
        $descripcion = $_POST['description'];
        $cantidad = $_POST['cantidad'];
        $altura = $_POST['altura'];
        $ancho = $_POST['ancho'];
        $insumo = $_POST['insumo'];
        $image_url = $_POST['image_url'] ?? null;
        $pedido=$controlador->registrarPedido($id_cliente, $total, $product_id, $descripcion, $cantidad, $altura, $ancho, $insumo,$image_url);
        if (isset($pedido['error'])) {
            die($pedido['error']);
        }
    }elseif ($accion === 'modificarEstado') {
        $newestado = $_GET["estado"];
        $idPedido = $_GET["id_pedido"];
        $controlador->modificarEstadoPedido($idPedido, $newestado);
        exit; // Asegúrate de terminar el script aquí para evitar la salida de HTML adicional
    }

}
?>
