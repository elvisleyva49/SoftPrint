<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif !important;
            background-color: #ffffff;
            color: #333;
            display: flex;
            flex-direction: column;
            width: 100%;
            min-height: 100vh;
            margin: 0;
        }

        /* Contenedor principal */
        .container {
            position: relative;
            z-index: 1000;
            text-align: center;
            padding: 20px;
            flex: 1;
            width: 100%; /* Abarca todo el ancho */
        }

        /* Título principal */
        .title {
            font-size: 5.5rem;
            color: black;
            font-weight: 600;
            margin-bottom: 50px;
        }

        /* Estilo de las filas de contenido */
        .row {
            display: flex;
            flex-wrap: nowrap; /* Evita que las columnas bajen a otra fila */
            justify-content: space-evenly; /* Distribuye columnas de manera uniforme */
            align-items: center;
            gap: 200px; /* Aumento aún más el espaciado entre columnas */
        }

        /* Estilo de las columnas dentro de la fila */
        .column {
            flex: 0 0 300px; /* Tamaño fijo para cada columna */
            max-width: 350px; /* Mantén el límite de ancho máximo */
            text-align: center;
        }

        .column img {
            width: 120%;
            height: auto;
            max-width: 360px; /* Asegura que las imágenes no se estiren demasiado */
        }

        .column p {
            margin-top: 20px;
            font-size: 1.3rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">SOBRE NOSOTROS</h1>
        <div class="row">
            <div class="column">
                <img src="img/nosotros1.svg" alt="Diseño 1">
                <p>En América, somos su imprenta confiable, con soluciones de impresión creativas y de alta calidad.</p>
            </div>
            <div class="column">
                <img src="img/nosotros2.svg" alt="Diseño 2">
                <p>En América, imprimimos su éxito con compromiso y dedicación.</p>
            </div>
            <div class="column">
                <img src="img/nosotros3.svg" alt="Diseño 3">
                <p>Usamos tecnología avanzada para diseñar banners, tarjetas, volantes y más que superen sus expectativas.</p>
            </div>
        </div>
    </div>
</body>
</html>
