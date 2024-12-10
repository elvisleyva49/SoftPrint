<?php
require __DIR__ . '/../libs/PHPMailer/Exception.php';
require __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require __DIR__ . '/../libs/PHPMailer/SMTP.php';


require __DIR__ . '/../modelos/ClsUsuario.php';
require_once __DIR__ . '/../config/conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UsuarioControlador {
    private $usuario;

    public function __construct() {
        // Crear una instancia de la clase BaseDeDatos
        $baseDeDatos = new BaseDeDatos();
        $db = $baseDeDatos->obtenerConexion(); // Obtener la conexión a la base de datos
        $this->usuario = new ClsUsuario($db);
      //  $controladorCliente = new ControladorCliente();
    }

    public function cargarTrabajadores() {
        return $this->usuario->obtenerTrabajadores();
    }

    public function login() {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
    // Crear una instancia de ControladorCliente y llamar a obtenerDatosCliente
    
    
            // Llama al método de inicio de sesión en el modelo Usuario
            $resultado = $this->usuario->iniciarSesion($email, $password);
            if ($resultado) {
                if($resultado['tipo'] == 'cliente'){
                    $datosCliente = $this->usuario->CargarDatosCliente($resultado['id_usuario']);
                    // Éxito, almacenar información en la sesión
                    session_start(); // Asegúrate de que la sesión esté iniciada
                    $_SESSION['usuario'] = $resultado['id_usuario']; // Almacena el ID del usuario en la sesión
                    $_SESSION['estado'] = $resultado['estado']; // Almacena el estado (activo/inactivo)
                    $_SESSION['tipo'] = $resultado['tipo']; // Si necesitas almacenar el tipo de usuario 

                    $_SESSION['id_cliente'] = $datosCliente['id_cliente'];
                    $_SESSION['celular'] = $datosCliente['celular'];
                    $_SESSION['nombre'] = $datosCliente['nombre'];
                    $_SESSION['apellido'] = $datosCliente['apellido'];
                    $_SESSION['dni'] = $datosCliente['dni'];
                    $_SESSION['celular'] = $datosCliente['celular'];     
                }else{
                    session_start();
                    $_SESSION['usuario'] = $resultado['id_usuario']; // Almacena el ID del usuario en la sesión
                    $_SESSION['estado'] = $resultado['estado']; // Almacena el estado (activo/inactivo)
                    $_SESSION['tipo'] = $resultado['tipo'];
                }
                if($resultado['tipo'] == 'cliente'){
                    echo "<script>alert('Bienvenido, " . $_SESSION['nombre'] . " al sistema: " . "');</script>";
                // Redirigir a una página de bienvenida o a otra parte de la aplicación
                }else{
                    echo "<script>alert('Bienvenido, " . $email . ". Tipo: " . $_SESSION['tipo'] . "');</script>";
                }

                echo "<script>window.location.href='../index.php';</script>"; // Redirigir a la página de bienvenida
            } else {
                echo "<script>alert('Correo o contraseña incorrectos.');</script>";
                echo "<script>window.location.href='../vistas/login.php';</script>"; // Redirigir a la página de inicio de sesión
            }
        }
    }
    

    public function registrar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['pass'];

            // Generar código de verificación aleatorio
            $codigoConfirmacion = rand(100000, 999999);

            // Guardar el usuario en la base de datos (puedes ajustar según tu lógica)
            $this->usuario->guardarUsuario($email, $password, $codigoConfirmacion);

            // Enviar el código por correo
            $this->enviarCodigoVerificacion($email, $codigoConfirmacion);

            echo "Se ha enviado un código de verificación a tu correo.";
        }
    }

    private function enviarCodigoVerificacion($email, $codigo) {
        $mail = new PHPMailer(true); // Crear una instancia de PHPMailer

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia esto si usas otro servidor
            $mail->SMTPAuth = true;
            $mail->Username = 'jkdev38@gmail.com'; // Correo predefinido de envío
            $mail->Password = 'ywbv rkrc aeso xhwu';     // Contraseña de aplicación de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinatarios
            $mail->setFrom('jkdevelopers38@gmail.com', 'JK Developers');
            $mail->addAddress($email); // Añadir destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; 
            $mail->Subject = "Código de Verificación";
            $mail->Body    = "Tu código de verificación es: <b>$codigo</b>";
            $mail->AltBody = "Tu código de verificación es: $codigo"; // Para clientes que no soportan HTML

            $mail->send();
            echo "Código de verificación enviado.";

            // Redirección después del envío exitoso
            header("Location: ../vistas/verificar.php"); // Reemplaza con la página a la que quieras redirigir
            exit();
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}";
        }
    }

    public function verificarCodigo() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
    
            // Combinar los valores del código de verificación si se envían como un arreglo
            if (isset($_POST['codigo']) && is_array($_POST['codigo'])) {
                $codigoIngresado = implode('', $_POST['codigo']); // Combina los valores en un string
            } else {
                echo "Código no proporcionado.";
                return;
            }
    
            // Validar el código en la base de datos
            if ($this->usuario->validarCodigo($email, $codigoIngresado)) {
                echo "Código verificado con éxito.";
                // Obtener el idusuario para redirigir
                $idUsuario = $this->usuario->obtenerIdUsuarioPorEmail($email);
                header("Location: ../vistas/registrar_cliente.php?idusuario=$idUsuario");
                exit(); // Asegúrate de detener la ejecución después de un redireccionamiento
            } else {
                echo "Código incorrecto.";
            }
        }
    }
    
}
// Manejo de la acción
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $controlador = new UsuarioControlador();
    
    if ($accion == 'registrar') {
        $controlador->registrar();
    } elseif ($accion == 'verificar') {
        $controlador->verificarCodigo();
    } elseif ($accion == 'login') {
        $controlador->login();
    }
}
?>
