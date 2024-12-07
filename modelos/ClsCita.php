<?php
class ClsCita {
    private $conn; // Definir la propiedad

    public function __construct($db) {
        $this->conn = $db; // Asignar la conexión al constructor
    }

    public function obtenerHistorialCitas($fecha) {
        $query = "SELECT * FROM cita WHERE fecha = :fecha";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();   
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerCitas($fecha) {
        $query = "SELECT c.id_cita,c.fecha,c.horario,c.estado,c.descripcion,c.f_creacion,concat(cl.nombre, ' ', cl.apellido) AS cliente 
                    FROM cita c
                    JOIN cliente cl ON c.id_cliente=cl.id_cliente
                    WHERE fecha = :fecha";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();   
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para registrar la cita
    public function registrarCita($fecha, $horario, $estado, $descripcion, $id_cliente, $id_empleado) {
        $query = "INSERT INTO cita (fecha, horario, estado, descripcion, id_cliente, id_empleado) VALUES (:fecha, :horario, :estado, :descripcion, :id_cliente, :id_empleado)";
        $stmt = $this->conn->prepare($query);
        
        // Asignar valores a los parámetros
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_empleado', $id_empleado);

        return $stmt->execute(); // Devuelve verdadero si se insertó correctamente
    }
    // Método para actualizar el estado de la cita
    public function modificarEstadoCita($idCita, $newestado) {
        $query = "UPDATE cita SET estado = :newestado WHERE id_cita = :idCita";
        $stmt = $this->conn->prepare($query);
        
        // Asignar valores a los parámetros
        $stmt->bindParam(':newestado', $newestado);
        $stmt->bindParam(':idCita', $idCita);

        return $stmt->execute(); // Devuelve verdadero si se actualizó correctamente
    }

    // Otros métodos relacionados con la cita...
}

?>
