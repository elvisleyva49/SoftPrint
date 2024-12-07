<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../modelos/ClsCliente.php';

class ClienteControlador {
    private $conexion;
    private $cliente;

    public function __construct() {
        // Crear una instancia de la clase BaseDeDatos y obtener la conexión
        $baseDeDatos = new BaseDeDatos();
        $this->conexion = $baseDeDatos->obtenerConexion();
        $this->cliente = new ClsCliente($this->conexion); // Pasar la conexión al modelo
    }

    public function registrarCliente() {
        // Verificar que se reciben los datos necesarios
        if (isset($_POST['id_usuario'], $_POST['nombre'], $_POST['apellido'], $_POST['dni'], $_POST['celular'], $_POST['distrito'])) {
            // Obtener datos del formulario
            $idusuario = $_POST['id_usuario']; // Obtener el id_usuario del formulario
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $dni = $_POST['dni'];
            $celular = $_POST['celular'];
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : ''; // Campo opcional
            $cod_ubigeo = $_POST['distrito']; // Código del distrito
            // Insertar el cliente
            $resultado = $this->cliente->insertarCliente($idusuario, $nombre, $apellido, $dni, $celular, $direccion, $cod_ubigeo);
            // Devolver resultado
            if ($resultado) {
                // Redireccionar al index.php si el registro fue exitoso
                header("Location: ../index.php?mensaje=Cliente registrado con éxito.");
                exit(); // Asegúrate de salir después de la redirección
            } else {
                // Manejar el error, tal vez redirigir con un mensaje de error
                header("Location: ../index.php?mensaje=Error al registrar el cliente.");
                exit();
            }
        }
    }

    // Método para actualizar los datos del cliente
    public function actualizarCliente() {
        // Verificar que se reciben los datos necesarios
        if (isset($_POST['id_usuario'], $_POST['nombre'], $_POST['apellido'], $_POST['dni'], $_POST['celular'])) {
            // Obtener datos del formulario
            $idusuario = $_POST['id_usuario']; // id_usuario del cliente
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $dni = $_POST['dni'];
            $celular = $_POST['celular'];
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : ''; // Campo opcional

            // Actualizar el cliente
            $resultado = $this->cliente->actualizarCliente($idusuario, $nombre, $apellido, $dni, $celular, $direccion);

            // Devolver resultado
            if ($resultado) {
                header("Location: ../index.php"); // Redirige a la página principal
                exit();
            } else {
                header("Location: ../index.php?mensaje=Error al actualizar el cliente.");
                exit();
            }
        } else {
            header("Location: ../index.php?mensaje=Faltan datos para actualizar el cliente.");
            exit();
        }
    }

    // Método para mostrar el perfil del usuario
    public function mostrarPerfil() {
        session_start();

        if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_usuario'])) {
            header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
            exit();
        }

        $idUsuario = $_SESSION['id_usuario'];
        $datosCliente = $this->cliente->obtenerDatosCliente($idUsuario); // Método para obtener los datos del cliente

        if (!$datosCliente) {
            echo "No se encontraron datos para el cliente.";
            exit();
        }

        // Incluir la vista de perfil del cliente
        include __DIR__ . '/../vistas/miperfil.php'; // Cambia la ruta según tu estructura de directorios
    }
}

// Verificar la acción solicitada
if (isset($_GET['accion'])) {
    $controlador = new ClienteControlador();
    switch ($_GET['accion']) {
        case 'actualizar':
            $controlador->actualizarCliente();
            break;
        case 'miperfil':
            $controlador->mostrarPerfil();
            break;
        case 'registrar_cliente':
            $controlador->registrarCliente();
            break;
        default:
            echo "Acción no válida.";
    }
} else {
    echo "No se ha especificado una acción.";
}
?>
