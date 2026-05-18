<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Verificar reCAPTCHA primero
    $config = require __DIR__ . '/../config/config.php';
    $recaptcha_secret = $config['RECAPTCHA_SECRET_KEY'];
    $response = $_POST['g-recaptcha-response'];
    
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$response}");
    $captcha_success = json_decode($verify);
    
    if ($captcha_success->success == false) {
        // Redirigir con error
        header("Location: ../vistas/login.php?error=captcha");
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
}
?>