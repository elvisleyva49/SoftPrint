<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="css/barranavegacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-container {
            z-index: 100000 !important;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    require_once 'controladores/UsuarioControlador.php';
    $usuarioControlador = new UsuarioControlador();
    
    // Alerta de bienvenida elegante
    if (isset($_SESSION['welcome_message'])) {
        $msg = $_SESSION['welcome_message'];
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-start',
                    icon: 'success',
                    title: '" . addslashes($msg) . "',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    background: '#1e293b',
                    color: '#ffffff',
                    iconColor: '#3b82f6',
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
            });
        </script>";
        unset($_SESSION['welcome_message']);
    }
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
        window.addEventListener('scroll', function () {
            nav.classList.toggle('active', window.scrollY > 0);
        });       
    </script>
    <script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>

    <script type="text/javascript">
        (function (d, t) {
            var v = d.createElement(t), s = d.getElementsByTagName(t)[0];
            v.onload = function () {
                window.voiceflow.chat.load({
                    verify: { projectID: '6a0a914da62d285256e07621' },
                    url: 'https://general-runtime.voiceflow.com',
                    versionID: 'production'
                });
            }
            v.src = "https://cdn.voiceflow.com/widget/bundle.mjs"; v.type = "text/javascript"; s.parentNode.insertBefore(v, s);
        })(document, 'script');
    </script>

</body>

</html>