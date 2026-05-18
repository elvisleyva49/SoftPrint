<?php
// ARCHIVO DE EJEMPLO PARA GITHUB
// Copia este archivo, renómbralo a "config.php" y coloca tus propias credenciales.

return [
    // Base de Datos
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_NAME' => 'nombre_de_tu_bd',
    'DB_USER' => 'tu_usuario',
    'DB_PASS' => 'tu_contrasena',

    // Google OAuth (Login con Google)
    'GOOGLE_CLIENT_ID' => 'TU_GOOGLE_CLIENT_ID',
    'GOOGLE_CLIENT_SECRET' => 'TU_GOOGLE_CLIENT_SECRET',
    'GOOGLE_REDIRECT_URI' => 'http://tudominio.com/ruta/callback.php',

    // Google reCAPTCHA v2 (Secret Key)
    'RECAPTCHA_SECRET_KEY' => 'TU_RECAPTCHA_SECRET_KEY'
];
?>
