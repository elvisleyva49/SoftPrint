<?php
require_once __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/SMTP.php';
require_once __DIR__ . '/../libs/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Lima'); // Asegúrate de tener la zona horaria correcta

require 'conexion.php'; // Conexión a la base de datos

// Crear una instancia de la clase BaseDeDatos
$baseDatos = new BaseDeDatos();
$conn = $baseDatos->obtenerConexion(); // Obtener la conexión

// Hora actual
$horaActual = date('Y-m-d H:i:s');
$cincoMinutosDespues = date('Y-m-d H:i:s', strtotime('+5 minutes')); // 5 minutos después

// Consulta para obtener citas programadas en los próximos 5 minutos
$sql = "SELECT 
            c.id_cita, 
            c.fecha, 
            c.horario, 
            cli.id_cliente, 
            u.email 
        FROM 
            cita c
        JOIN 
            cliente cli ON c.id_cliente = cli.id_cliente
        JOIN 
            usuario u ON cli.id_usuario = u.id_usuario
        WHERE 
            c.estado = 'programada'
        AND 
            CONCAT(c.fecha, ' ', c.horario) BETWEEN :horaActual AND :cincoMinutosDespues";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':horaActual', $horaActual);
$stmt->bindParam(':cincoMinutosDespues', $cincoMinutosDespues);
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Cambia a fetchAll de PDO

// Enviar correos para cada cita
if (!empty($citas)) {
    foreach ($citas as $cita) {
        $emailCliente = $cita['email'];
        $horarioCita = $cita['horario'];

        // Enviar correo
        $mail = new PHPMailer(true); // 'true' habilita las excepciones
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';        // Servidor SMTP de Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'jkdev38@gmail.com';     // Correo predefinido de envío
            $mail->Password   = 'ywbv rkrc aeso xhwu';   // Contraseña de aplicación de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar encriptación TLS
            $mail->Port       = 587;                     // Puerto TCP para conectar

            $mail->setFrom('jkdevelopers38@gmail.com', 'Recordatorio de Cita');
            $mail->addAddress($emailCliente);

            $mail->isHTML(true);
            $mail->Subject = 'Recordatorio: Cita programada';
            $mail->Body = "¡Hola! Te recordamos que tienes una cita programada a las $horarioCita. ¡Nos vemos pronto!";

            // Enviar el correo
            $mail->send();
            echo "Correo enviado a $emailCliente para la cita a las $horarioCita" . PHP_EOL;

        } catch (Exception $e) {
            echo "Error al enviar correo a $emailCliente: {$mail->ErrorInfo}" . PHP_EOL;
        }
    }
} else {
    echo "No hay citas programadas para los proximos 5 minutos." . PHP_EOL;
}
?>
