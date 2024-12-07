<?php
session_start(); // Inicia la sesión

// Eliminar todas las variables de sesión
$_SESSION = [];

// Si se desea destruir la sesión completamente
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Finalmente, destruir la sesión
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cerrar Sesión</title>
    <link rel="stylesheet" href="/css/logout.css">
    <meta http-equiv="refresh" content="2;url=/index.php">
</head>
<body>
    <h1>¡Has cerrado tu sesión!</h1>
    <p>Serás redirigido al inicio en breve</p>
    <div class="spinner"></div>
</body>
</html>