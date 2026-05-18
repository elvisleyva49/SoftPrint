<?php
require('../config/conf_recaptcha.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .error {
            color: #ef4444;
            display: none;
            margin-top: 5px;
            font-size: 13px;
        }
        .g-recaptcha {
            margin: 20px 0;
            display: flex;
        }
    </style>
</head>
<body class="fade-in">
    <?php
    session_start();
    if (isset($_SESSION['error_message'])) {
        $error_msg = $_SESSION['error_message'];
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-start',
                    icon: 'error',
                    title: '" . addslashes($error_msg) . "',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    background: '#1e293b',
                    color: '#ffffff'
                });
            });
        </script>";
        unset($_SESSION['error_message']);
    }
    // Error de reCAPTCHA desde el header GET
    if (isset($_GET['error']) && $_GET['error'] == 'captcha') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-start',
                    icon: 'warning',
                    title: 'Por favor, completa el reCAPTCHA',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    background: '#1e293b',
                    color: '#ffffff'
                });
            });
        </script>";
    }
    ?>
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
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="../controladores/UsuarioControlador.php?accion=login" onsubmit="return validateForm()">
            
            <div class="input-icon">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
                <i class="fas fa-envelope"></i> 
            </div>

            <div class="input-icon">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
                <i class="fas fa-lock"></i> 
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember"> Recordarme
                </label>
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>

            <div class="g-recaptcha" data-sitekey="6Lcvx2MqAAAAAD-lji0Awt4DAgteYclFzTcqwhi1" data-theme="dark"></div>
            <div class="error" id="captcha-error">Por favor, verifica que no eres un robot</div>

            <input type="submit" name="login" value="Ingresar">
        </form>
        <p>¿No tienes una cuenta? <a href="../vistas/registrar.php">Regístrate aquí</a></p> 
    </div>

    <script>
    function validateForm() {
        var response = grecaptcha.getResponse();
        if (response.length === 0) {
            document.getElementById('captcha-error').style.display = 'block';
            return false;
        }
        document.getElementById('captcha-error').style.display = 'none';
        return true;
    }

    function correctCaptcha() {
        document.getElementById('captcha-error').style.display = 'none';
    }
    </script>
</body>
</html>