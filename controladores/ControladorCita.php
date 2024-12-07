<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/ClsCita.php';

class ControladorCita {
    private $conn;
    private $cita;

    public function __construct($db) {
        $this->conn = $db;
        $this->cita = new ClsCita($this->conn); // Instancia de ClsCita con la conexión
    }

    public function registrarCita() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fecha = $_POST['fecha'] ?? null;
            $horario = $_POST['horario'] ?? null;
            $estado = 'programada';
            $descripcion = $_POST['descripcion'] ?? '';
            session_start();
            $id_cliente = $_SESSION['id_cliente']; 
            $id_empleado = 1; // Cambiar por el ID correspondiente

            if (empty($fecha) || empty($horario) || empty($descripcion)) {
                $mensaje = "Todos los campos son obligatorios.";
            } else {
                if ($this->cita->registrarCita($fecha, $horario, $estado, $descripcion, $id_cliente, $id_empleado)) {
                    $mensaje = "Cita registrada exitosamentee.";
                } else {
                    $mensaje = "Error al registrar la cita.";
                }
            }
            ob_start();
            echo $mensaje;
            header("Location: ../vistas/registrar_cita.php");
            ob_end_flush();
            exit();
        } else {
            echo "Método de solicitud no válido.";
        }
    }
    public function obtenerHistorialCitas($fecha) {
        return $this->cita->obtenerHistorialCitas($fecha); // Llama al método del modelo
    }
    public function obtenerCitas($fecha) {
        return $this->cita->obtenerCitas($fecha); // Llama al método del modelo
    }
    public function modificarEstadoCita($idCita,$newestado) {
        $resultado=$this->cita->modificarEstadoCita($idCita,$newestado); // Llama al método del modelo
        if($resultado){
            echo "<script>alert('Estado de la cita actualizado correctamente.');</script>";
            header("Location: ../vistas/historial_citas.php");
            exit();
        }else{
            echo "<script>alert('Error al actualizar el estado de la cita.');</script>";
            header("Location: ../vistas/historial_citas.php");
            exit();
        }        
    }
    // Otros métodos...
}

// Crear la conexión a la base de datos
$baseDeDatos = new BaseDeDatos();
$conexion = $baseDeDatos->obtenerConexion();

// Control de la acción
if (isset($_GET['accion'])) {
    $controlador = new ControladorCita($conexion); // Pasar la conexión al controlador
    $accion = $_GET['accion'];
    if ($accion === 'registrarcita') {
        $controlador->registrarCita();
    }elseif ($accion === 'verHistorial') {
        $historialcitas = $controlador->obtenerHistorialCitas($fechaac); // Cambia la fecha según sea necesario
        include '../vistas/registrar_cita.php'; // Incluye la vista donde imprimes la tabla
    }elseif ($accion === 'obtenerHistorial') {
        $fecha = $_GET["fecha"];
        $historialCitas = $controlador->obtenerHistorialCitas($fecha);
        echo json_encode($historialCitas);
        exit; // Asegúrate de terminar el script aquí para evitar la salida de HTML adicional
    }elseif ($accion === 'modificarEstado') {
        $newestado = $_GET["estado"];
        $idCita = $_GET["id_cita"];
        $controlador->modificarEstadoCita($idCita, $newestado);
        exit; // Asegúrate de terminar el script aquí para evitar la salida de HTML adicional
    }
    

}
?>
