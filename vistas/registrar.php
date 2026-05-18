<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario | SoftPrint</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Reutilizamos el mismo CSS elegante del login -->
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="fade-in">
    <!-- Nubes animadas en el fondo para mayor dinamismo -->
    <div class="clouds">
        <img src="../img/cloud1.png" style="--i:1;">
        <img src="../img/cloud2.png" style="--i:2;">
        <img src="../img/cloud3.png" style="--i:3;">
        <img src="../img/cloud4.png" style="--i:4;">
        <img src="../img/cloud5.png" style="--i:5;">
        <img src="../img/cloud1.png" style="--i:10;">
        <img src="../img/cloud2.png" style="--i:9;">
        <img src="../img/cloud3.png" style="--i:8;">
    </div>

    <!-- Botón de regreso -->
    <a href="../index.php" class="back-btn fade-in">
        <i class="fas fa-arrow-left"></i> Volver al inicio
    </a>

    <div class="container"> 
        <h2>Crear Cuenta</h2>
        <form method="POST" action="../controladores/UsuarioControlador.php?accion=registrar">
            
            <div class="input-icon">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
                <i class="fas fa-envelope"></i> 
            </div>

            <div class="input-icon">
                <label for="pass">Contraseña</label>
                <input type="password" id="pass" name="pass" required placeholder="••••••••">
                <i class="fas fa-lock"></i> 
            </div>

            <input type="submit" name="register" value="Registrarme">
        </form>
        <p>¿Ya tienes una cuenta? <a href="../vistas/login.php">Inicia sesión aquí</a></p> 
    </div>
</body>
</html>
