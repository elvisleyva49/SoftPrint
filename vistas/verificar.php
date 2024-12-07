<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de Código</title>
    <link rel="stylesheet" href="../css/verificacion.css">
</head>
<body>
    <div class="container">
            <form class="form" method="POST" action="../controladores/UsuarioControlador.php?accion=verificar">
            <div class="info">
                <span class="title">Verificación de Código</span>
                <p class="description">Introduce tu correo y el código de verificación enviado.</p>
            </div>
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" required>
            <div class="code-inputs">
                <input type="text" name="codigo[]" maxlength="1" required>
                <input type="text" name="codigo[]" maxlength="1" required>
                <input type="text" name="codigo[]" maxlength="1" required>
                <input type="text" name="codigo[]" maxlength="1" required>
                <input type="text" name="codigo[]" maxlength="1" required>
                <input type="text" name="codigo[]" maxlength="1" required>
            </div>
            <div class="action-btns">
                <input class="verify" type="submit" value="Verificar">
            </div>
        </form>
    </div>
</body>
</html>
