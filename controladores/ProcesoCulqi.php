<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../config/conexion.php';

// Llave privada
$llave_privada = "sk_test_766697c164a13c6c";

// Token, monto, correo y id_pedido enviados desde JavaScript
$token = $_POST['token'];
$amount = $_POST['amount'];
$email = $_POST['email'];
$id_pedido = $_POST['id_pedido'];

// Configurar la cabecera de la solicitud
$headers = [
    "Authorization: Bearer $llave_privada",
    "Content-Type: application/json"
];

// Cuerpo de la solicitud con datos dinámicos
$data = [
    "amount" => (int) $amount,
    "currency_code" => "PEN",
    "email" => $email,
    "source_id" => $token
];

// Inicializar la solicitud cURL
$ch = curl_init("https://api.culqi.com/v2/charges");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Ejecutar la solicitud
$response = curl_exec($ch);
curl_close($ch);

// Manejo de la respuesta
$response_data = json_decode($response, true);

if (isset($response_data['object']) && $response_data['object'] == 'charge') {
    try {
        // Crear conexión a la base de datos
        $baseDatos = new BaseDeDatos();
        $conn = $baseDatos->obtenerConexion();

        // Preparar la consulta SQL para actualizar el estado de pago
        $sql = "UPDATE pedido SET pagado = 1 WHERE id_pedido = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_pedido]);

        if ($stmt->rowCount() > 0) {
            // Redirigir de vuelta a la página de pedidos con un mensaje de éxito
            header("Location: ../vistas/mispedidos.php?mensaje=pago_exitoso");
            exit();
        } else {
            // Redirigir con mensaje de error si no se pudo actualizar
            header("Location: ../vistas/mispedidos.php?mensaje=error_actualizacion");
            exit();
        }
    } catch (PDOException $e) {
        // Redirigir con mensaje de error en caso de excepción
        header("Location: ../vistas/mispedidos.php?mensaje=error_db");
        exit();
    }
} else {
    // Redirigir con mensaje de error si el pago falló
    header("Location: ../vistas/mispedidos.php?mensaje=error_pago");
    exit();
}
?>