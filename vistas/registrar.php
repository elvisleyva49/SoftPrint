<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/registrar.css">
</head>
<body class="fade-in">
    <div class="container"> 
        <h2>Registrar Usuario</h2>
        <form method="POST" action="../controladores/UsuarioControlador.php?accion=registrar">
            
            <div class="input-icon">
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" required placeholder="Ingresa tu Email">
                <i class="fas fa-envelope"></i> 
            </div>

            <div class="input-icon">
                <label for="pass">Contraseña:</label>
                <input type="password" name="pass" required placeholder="Ingresa tu Contraseña">
                <i class="fas fa-lock"></i> 
            </div>

            <input type="submit" name="register" value="Registrar">
        </form>
    </div>
</body>
</html>
