<?php
class BaseDeDatos
{
    private $host;
    private $puerto;
    private $nombre_bd;
    private $usuario;
    private $contrasena;
    public $conexion;

    public function __construct() {
        $config = require __DIR__ . '/config.php';
        $this->host = $config['DB_HOST'];
        $this->puerto = $config['DB_PORT'];
        $this->nombre_bd = $config['DB_NAME'];
        $this->usuario = $config['DB_USER'];
        $this->contrasena = $config['DB_PASS'];
    }

    public function obtenerConexion()
    {
        $this->conexion = null;

        try {
            $this->conexion = new PDO("mysql:host=" . $this->host . ";port=" . $this->puerto . ";dbname=" . $this->nombre_bd, $this->usuario, $this->contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $excepcion) {
            echo "Error de conexión: " . $excepcion->getMessage();
        }

        return $this->conexion;
    }
}
?>