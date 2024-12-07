<?php
class ClsEmpleado {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener el id_empleado usando el id_usuario
    public function obtenerIdEmpleadoPorUsuario($id_usuario) {
        // Consulta SQL para obtener el id_empleado por id_usuario
        $query = "SELECT id_empleado FROM empleado WHERE id_usuario = :id_usuario LIMIT 1";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Vincular el parámetro :id_usuario
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se encontró un resultado
        if ($stmt->rowCount() > 0) {
            // Obtener el id_empleado
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id_empleado'];  // Retorna el id_empleado
        } else {
            // Si no se encuentra el id_usuario, retornar null
            return null;
        }
    }
}
?>
