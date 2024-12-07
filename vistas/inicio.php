<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Inicio</title>
        <link rel="stylesheet" href="css/inicio.css">
    </head>
    <body>
        <div class="banner">
            <h2 id="text">
                <img src="img/logo.png" alt="logo" class="logo">
            </h2>
            <div class="clouds">
                <img src="img/cloud1.png" style="--i:1;">
                <img src="img/cloud2.png" style="--i:2;">
                <img src="img/cloud3.png" style="--i:3;">
                <img src="img/cloud4.png" style="--i:4;">
                <img src="img/cloud5.png" style="--i:5;">
                <img src="img/cloud1.png" style="--i:10">
                <img src="img/cloud1.png" style="--i:9;">
                <img src="img/cloud1.png" style="--i:8;">
                <img src="img/cloud1.png" style="--i:7;">
                <img src="img/cloud1.png" style="--i:6;">
            </div>
        </div>
        <script type="text/javascript">
            let text = document.getElementById('text');
            window.addEventListener('scroll', function(){
                let value = window.scrollY;
                text.style.marginBottom = value * 2 + 'px';
            });
        </script>
    </body>
</html>


