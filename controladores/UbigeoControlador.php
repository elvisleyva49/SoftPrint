<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/ClsUbigeo.php';

class UbigeoControlador {
    private $conexion;
    private $ubigeo;

    public function __construct() {
        // Crear una instancia de la clase BaseDeDatos y obtener la conexión
        $baseDeDatos = new BaseDeDatos();
        $this->conexion = $baseDeDatos->obtenerConexion();
        $this->ubigeo = new ClsUbigeo($this->conexion); // Pasar la conexión al modelo
    }

    public function obtenerDepartamentos() {
        $departamentos = $this->ubigeo->obtenerDepartamentos();
        echo json_encode($departamentos);
    }

    public function obtenerProvincias() {
        if (isset($_GET['departamento'])) {
            $codDepartamento = $_GET['departamento'];
            $provincias = $this->ubigeo->obtenerProvincias($codDepartamento);
            echo json_encode($provincias);
        }
    }

    public function obtenerDistritos() {
        if (isset($_GET['provincia'])) {
            $codProvincia = $_GET['provincia'];
            $distritos = $this->ubigeo->obtenerDistritos($codProvincia);
            echo json_encode($distritos);
        }
    }
}

// Ejecución del controlador
$controlador = new UbigeoControlador();

if (isset($_GET['accion'])) {
    switch ($_GET['accion']) {
        case 'departamentos':
            $controlador->obtenerDepartamentos();
            break;
        case 'provincias':
            $controlador->obtenerProvincias();
            break;
        case 'distritos':
            $controlador->obtenerDistritos();
            break;
        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
}
?>
