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
    <style>
        .error {
            color: red;
            display: none;
            margin-top: 5px;
            font-size: 14px;
        }
        .g-recaptcha {
            margin: 15px 0;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body class="fade-in">
    <div class="container"> 
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="../controladores/UsuarioControlador.php?accion=login" onsubmit="return validateForm()">
            
            <div class="input-icon">
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" required placeholder="Ingresa tu Email">
                <i class="fas fa-envelope"></i> 
            </div>

            <div class="input-icon">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" required placeholder="Ingresa tu Contraseña">
                <i class="fas fa-lock"></i> 
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember"> Recordarme
                </label>
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>

            <div class="g-recaptcha" data-sitekey="6Lcvx2MqAAAAAD-lji0Awt4DAgteYclFzTcqwhi1"></div>
            <div class="error" id="captcha-error">Por favor, complete el reCAPTCHA</div>

            <input type="submit" name="login" value="Iniciar Sesión">
        </form>

        <div class="or-divider">O con</div>

        <div class="social-buttons">
            <button class="social-btn google">
                <img src="../img/googleicono.png" alt="Google" width="20">
                Continuar con Google
            </button>
        </div>
        <p>¿No tienes una cuenta? <a href="../vistas/registrar.php">Regístrate</a></p> 
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