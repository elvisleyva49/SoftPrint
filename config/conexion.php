<?php
class BaseDeDatos {
    private $host = "localhost";
    private $puerto = "3306";
    private $nombre_bd = "bdimprenta";
    private $usuario = "root";
    private $contrasena = "";
    public $conexion;

    public function obtenerConexion() {
        $this->conexion = null;

        try {
            $this->conexion = new PDO("mysql:host=" . $this->host . ";port=" . $this->puerto . ";dbname=" . $this->nombre_bd, $this->usuario, $this->contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $excepcion) {
            echo "Error de conexión: " . $excepcion->getMessage();
        }

        return $this->conexion;
    }
}
?>
