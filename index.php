<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="css/barranavegacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php
    session_start();
    require_once 'controladores/UsuarioControlador.php';
    $usuarioControlador = new UsuarioControlador();
?>

    <!-- barra de navegación -->
    <header>
        <?php include('vistas/barranavegacion.php'); ?> 
    </header>
    
    <!-- Contenido principal-->
    <main>
        <!-- Sección Nosotros -->
        <div id="inicio" class="overlay">
            <?php include('vistas/inicio.php'); ?>
        </div>    
   

        <!-- Sección Nosotros -->
        <div id="nosotros" class="overlay">
            <?php include('vistas/nosotros.php'); ?>
        </div>

        <!-- Sección Productos -->
        <div id="productos">
            <?php include('vistas/productos.php'); ?>
        </div>

        <!-- Sección Contacto -->
        <div id="contacto">
            <?php include('vistas/contactanos.php'); ?>
        </div>

        <div id="mapa">
            <?php include('vistas/mapa.php'); ?>
        </div>
    </main>

    <!-- Pie de página -->
    <footer>
        <?php include('vistas/piepagina.php'); ?>
    </footer>

    <!-- Script animación de scroll-->
    <script>
        const nav = document.querySelector('.nav');
        window.addEventListener('scroll', function(){
            nav.classList.toggle('active', window.scrollY > 0);
        });       
    </script>
        <script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>

        <script type="text/javascript">
        (function(d, t) {
            var v = d.createElement(t), s = d.getElementsByTagName(t)[0];
            v.onload = function() {
                window.voiceflow.chat.load({
                verify: { projectID: '672ae3e41891ba0bf93f64a6' },
                url: 'https://general-runtime.voiceflow.com',
                versionID: 'production'
                });
            }
            v.src = "https://cdn.voiceflow.com/widget/bundle.mjs"; v.type = "text/javascript"; s.parentNode.insertBefore(v, s);
        })(document, 'script');
        </script>

</body>
</html>
