<?php

class ClsCliente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertarCliente($idusuario, $nombre, $apellido, $dni, $celular, $direccion, $cod_ubigeo) {
        // Consulta SQL para insertar el cliente
        $sql = "INSERT INTO cliente (id_usuario, nombre, apellido, dni, celular, direccion, cod_ubigeo) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = $this->conn->prepare($sql);
        
        // Ejecutar la consulta y manejar errores
        if ($stmt->execute([$idusuario, $nombre, $apellido, $dni, $celular, $direccion, $cod_ubigeo])) {
            return true; // Registro exitoso
        } else {
            // Imprimir el error detallado
            echo "Error al registrar: " . implode(", ", $stmt->errorInfo());
            return false; // Error al registrar
        }
    }

    public function obtenerDatosCliente($idUsuario) {
        // Primero, obtener los datos básicos del cliente
        $stmt = $this->conn->prepare("
            SELECT c.nombre, c.apellido, c.dni, c.celular, c.direccion, c.cod_ubigeo
            FROM cliente c
            WHERE c.id_usuario = :id_usuario
        ");
        $stmt->bindParam(':id_usuario', $idUsuario);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $datosCliente = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener datos del cliente
    
            // Ahora llamamos al procedimiento almacenado para obtener la descripción del ubigeo
            $codUbigeo = $datosCliente['cod_ubigeo'];
            
            $stmtUbigeo = $this->conn->prepare("CALL obtenerDPyD(:codUbigeo)");
            $stmtUbigeo->bindParam(':codUbigeo', $codUbigeo);
            $stmtUbigeo->execute();
    
            // Obtener los resultados del procedimiento almacenado
            $datosUbigeo = $stmtUbigeo->fetch(PDO::FETCH_ASSOC);
            
            // Combinar los datos del cliente y del ubigeo
            return array_merge($datosCliente, $datosUbigeo);
        } else {
            return false; // No se encontró el cliente
        }
    }

    public function actualizarCliente($idusuario, $nombre, $apellido, $dni, $celular, $direccion) {
        $sql = "UPDATE cliente SET nombre = ?, apellido = ?, dni = ?, celular = ?, direccion = ? WHERE id_usuario = ?";

        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute([$nombre, $apellido, $dni, $celular, $direccion, $idusuario])) {
            return true;
        } else {
            echo "Error al actualizar: " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

}
?>
