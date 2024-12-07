<?php
// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../libs/PHPMailer/Exception.php';
require '../libs/PHPMailer/PHPMailer.php';
require '../libs/PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];

    // Instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';        // Servidor SMTP de Gmail
        $mail->SMTPAuth   = true;                    // Habilitar autenticación SMTP
        $mail->Username   = 'jkdev38@gmail.com';     // Correo predefinido de envío
        $mail->Password   = 'ywbv rkrc aeso xhwu';   // Contraseña de aplicación de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar encriptación TLS
        $mail->Port       = 587;                     // Puerto TCP para conectar

        // Configuración del correo
        $mail->setFrom($email, $nombre);             // Correo del usuario que envía el mensaje
        $mail->addAddress('jkdev38@gmail.com');      // Correo de destino (empresa)

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "<h1>Nuevo mensaje de contacto</h1>
                          <p><strong>Nombre:</strong> $nombre</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Teléfono:</strong> $telefono</p>
                          <p><strong>Mensaje:</strong> $mensaje</p>";

        // Enviar el correo
        $mail->send();
        echo "<p>Mensaje enviado con éxito. Nos pondremos en contacto contigo pronto.</p>";
        // Redirección después del envío exitoso
        header("Location: ../vistas/verificar.php"); // Reemplaza con la página a la que quieras redirigir
    } catch (Exception $e) {
        echo "<p>Error al enviar el mensaje. Por favor, intenta nuevamente. Error: {$mail->ErrorInfo}</p>";
    }
} else {
    echo "<p>Acceso no permitido.</p>";
}
?>