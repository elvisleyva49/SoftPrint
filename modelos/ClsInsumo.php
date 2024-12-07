<?php
class ClsInsumo {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertarInsumo($descripcion, $stock, $precio_compra) {
        $query = "INSERT INTO insumo (descripcion, stock, precio_compra) VALUES (:descripcion, :stock, :precio_compra)";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':precio_compra', $precio_compra);

        return $stmt->execute();
    }

    public function obtenerInsumos() {
        $query = "SELECT id_insumo, descripcion, stock, precio_compra FROM insumo";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarIngreso($id_insumo, $id_proveedor, $cantidad, $costo_unitario, $observaciones) {
        $query = "INSERT INTO ingreso (id_insumo, fecha, cantidad, costo_unitario, id_proveedor, observaciones) 
                  VALUES (:id_insumo, CURRENT_TIMESTAMP(), :cantidad, :costo_unitario, :id_proveedor, :observaciones)";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_insumo', $id_insumo);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':costo_unitario', $costo_unitario);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        $stmt->bindParam(':observaciones', $observaciones);
        
        $stmt->execute();
    }

    public function obtenerHistorialIngresos() {
        $query = "SELECT i.id_ingreso, ins.descripcion AS insumo, i.fecha, i.cantidad, 
                         i.costo_unitario, (i.cantidad * i.costo_unitario) AS costo_total, 
                         i.observaciones, p.nombre AS proveedor 
                  FROM ingreso i
                  JOIN insumo ins ON i.id_insumo = ins.id_insumo
                  JOIN proveedor p ON i.id_proveedor = p.id_proveedor
                  ORDER BY i.fecha DESC";

        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
