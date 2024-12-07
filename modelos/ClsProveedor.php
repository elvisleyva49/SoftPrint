<?php
class ClsProveedor {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerProveedores() {
        $query = "SELECT id_proveedor, nombre FROM proveedor"; // Asegúrate de que el nombre de la tabla sea correcto
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los registros como un array asociativo
    }

    public function registrarProveedor($nombre, $ruc, $celular, $email, $direccion) {
        $query = "INSERT INTO proveedor (nombre, ruc, celular, email, direccion) VALUES (:nombre, :ruc, :celular, :email, :direccion)";
        $stmt = $this->conexion->prepare($query);
        
        // Asignación de parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':ruc', $ruc);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);

        return $stmt->execute(); // Devuelve verdadero si se inserta correctamente
    }

}
?>
