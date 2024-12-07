<?php
class ClsPedido{
    private $conn; // Definir la propiedad

    public function __construct($db) {
        $this->conn = $db; // Asignar la conexión al constructor
    }

    public function obtenerHistorialPedidos($id_cliente) {
        $query = "SELECT * FROM pedido WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();   
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cargarDetallePedido($id_pedido) {
        $query = "SELECT * FROM detalle_pedido WHERE id_pedido = :id_pedido";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pedido', $id_pedido);
        $stmt->execute();   
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPedidosporcliente($id_cliente) {
        $sql = "SELECT c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, 
                dp.descripcion, p.fecha_pedido, p.estado,p.total, p.pagado, p.id_pedido
        FROM pedido p
        INNER JOIN cliente c ON p.id_cliente = c.id_cliente
        INNER JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
        WHERE p.id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function obtenerPedidospordesigner($id_disenador) {
        $sql = "SELECT c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, 
                       dp.descripcion, p.fecha_pedido, p.estado, p.pagado, p.id_pedido
                FROM pedido p
                INNER JOIN cliente c ON p.id_cliente = c.id_cliente
                INNER JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
                LEFT JOIN empleado e ON p.id_empleado = e.id_empleado
                WHERE p.id_empleado = :id_disenador";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_disenador', $id_disenador, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function obtenerPedidos() {
        $sql = "SELECT c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, 
                       dp.descripcion, p.fecha_pedido, p.estado, p.id_pedido
                FROM pedido p
                INNER JOIN cliente c ON p.id_cliente = c.id_cliente
                INNER JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
                WHERE p.estado = 'pendiente'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerEstadoPedido($id_pedido) {
        $sql = "
            SELECT 
                p.estado, 
                e.nombre AS nombre_disenador, 
                e.apellido AS apellido_disenador, 
                e.celular 
            FROM pedido p
            LEFT JOIN empleado e ON p.id_empleado = e.id_empleado
            WHERE p.id_pedido = :id_pedido
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function verDetallePedido($id_pedido) {
        $sql = "SELECT 
                dp.id_pedido,
                p.nombre AS nombre_producto,
                dp.descripcion,
                dp.altura,
                dp.ancho,
                dp.cantidad,
                i.descripcion AS insumo,
                dp.url_img 
                FROM detalle_pedido dp
                JOIN producto p ON dp.id_producto = p.id_producto
                LEFT JOIN insumo i ON dp.id_insumo = i.id_insumo
                WHERE dp.id_pedido = :id_pedido";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
    public function asignarTrabajador($id_empleado, $id_pedido) {
        $query = "UPDATE pedido 
              SET id_empleado = :id_empleado, estado = 'asignado' 
              WHERE id_pedido = :id_pedido";
        $stmt = $this->conn->prepare($query);
        
        // Asignación de parámetros
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':id_pedido', $id_pedido);

        return $stmt->execute();
    }
    public function insertarPedido($id_cliente, $id_empleado, $fecha_pedido, $estado, $total) {
        $query = "INSERT INTO pedido (id_cliente, id_empleado, fecha_pedido, estado, total) 
                  VALUES (:id_cliente, :id_empleado, :fecha_pedido, :estado, :total)";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular los parámetros
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':fecha_pedido', $fecha_pedido);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':total', $total);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Retorna el ID del pedido insertado
        }
        
        return false;
    }

    public function insertarDetallePedido($id_pedido, $id_producto, $descripcion, $altura, $ancho, $cantidad, $insumo, $image_url) {
        // Consulta para insertar los detalles del pedido en la tabla 'detalle_pedido'
        $query = "INSERT INTO detalle_pedido (id_pedido, id_producto, descripcion, altura, ancho, cantidad, id_insumo, url_img) 
                  VALUES (:id_pedido, :id_producto, :descripcion, :altura, :ancho, :cantidad, :id_insumo, :url_img)";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular los parámetros
        $stmt->bindParam(':id_pedido', $id_pedido);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':altura', $altura);
        $stmt->bindParam(':ancho', $ancho);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_insumo', $insumo);
        $stmt->bindParam(':url_img', $image_url);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    public function descontarStockInsumo($insumo, $cantidad) {
        // Consulta para actualizar el stock del insumo
        $query = "UPDATE insumo 
                  SET stock = stock - :cantidad 
                  WHERE id_insumo = :insumo AND stock >= :cantidad";
        
        $stmt = $this->conn->prepare($query);
    
        // Vincular los parámetros
        $stmt->bindParam(':insumo', $insumo, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Verificar si se realizó la actualización
            if ($stmt->rowCount() > 0) {
                return true; // Stock descontado exitosamente
            } else {
                return false; // No se pudo descontar (stock insuficiente)
            }
        }
        
        return false; // Error al ejecutar la consulta
    }
    public function modificarEstadoPedido($idPedido, $newestado) {
        $query = "UPDATE pedido SET estado = :newestado WHERE id_pedido = :idPedido";
        $stmt = $this->conn->prepare($query);
        
        // Asignar valores a los parámetros
        $stmt->bindParam(':newestado', $newestado);
        $stmt->bindParam(':idPedido', $idPedido);

        return $stmt->execute(); // Devuelve verdadero si se actualizó correctamente
    }
    
}

?>