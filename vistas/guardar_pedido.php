<?php
    session_start(); // Inicia la sesión

    $img_url = $_GET['generated_image_url'] ?? null;

    if (!isset($_SESSION['id_cliente'])) {
        // Si no está logueado, redirige al login
        header('Location: login.php');
        exit;
    }

        // Asegúrate de que el método sea POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtén el ID del producto enviado desde el formulario
        $product_id = $_POST['product_id'] ?? null;

        if ($product_id) {
            // Guarda el product_id como una variable global en la sesión
            $_SESSION['product_id'] = $product_id;

        } else {
            echo "No se recibió el ID del producto.";
        }
    } else {
        // Si el acceso no es mediante POST, redirige o muestra un error
        echo "Acceso no válido.";
    }


    // Obtén el id_cliente de la sesión
    $id_cliente = $_SESSION['id_cliente'];

    // Definir productos estáticos para la prueba
    $productos = [
        1 => [
            'nombre' => 'Tarjetas de Presentación',
            'nom_imagen' => 'tarjetas',
            'descripcion' => 'Impacta con estilo. Elige entre una variedad de estilos, acabados y materiales que destacan tu marca con calidad.',
            'tiempo' => '3 días',
            'estatico' => true,
            'precios' => [
                'Tarjeta Mate Millar' => ['precio' => 75.00, 'insumo' =>'16','altura' => '5.5 cm', 'ancho' => '9 cm'],
                'Tarjeta Brillo Millar' => ['precio' => 55.00,'insumo' =>'17', 'altura' => '5.5 cm', 'ancho' => '9 cm'],
            ]
        ],
        2 => [
            'nombre' => 'Volantes',
            'nom_imagen' => 'volantes',
            'descripcion' => 'Destaca con volantes publicitarios de alta calidad. Selecciona entre múltiples estilos y tamaños que realzan la imagen de tu marca.',
            'tiempo' => '3 días',
            'estatico' => true,
            'precios' => [
                'A6 Millar Volantes' => ['precio' => 70.00, 'insumo' =>'13', 'altura' => '10.5 cm', 'ancho' => '14.8 cm'],
                'A5 Millar Volantes' => ['precio' => 140.00,'insumo' =>'12', 'altura' => '14.8 cm', 'ancho' => '21 cm'],
                'A4 Millar Volantes' => ['precio' => 280.00,'insumo' =>'11', 'altura' => '21 cm', 'ancho' => '29.7 cm'],
                'A3 Millar Volantes' => ['precio' => 560.00,'insumo' =>'10', 'altura' => '29.7 cm', 'ancho' => '42 cm'],
            ]
        ],
        3 => [
            'nombre' => 'Stickers Adhesivos',
            'nom_imagen' => 'stickers',
            'descripcion' => 'Crea diseños únicos. Ofrecemos stickers adhesivos personalizados a gusto del cliente de alta calidad.',
            'tiempo' => '20 Minutos x m²',
            'estatico' => false,
            'precios' => [
                'm² Económico' => ['precio' => 22.00, 'insumo' =>'18', 'altura' => '', 'ancho' => ''],
                'm² Premium' => ['precio' => 25.00, 'insumo' =>'19', 'altura' => '', 'ancho' => ''],
            ]
        ],
        4 => [
            'nombre' => 'Banners Personalizados',
            'nom_imagen' => 'banners',
            'descripcion' => 'Celebra momentos especiales con banners impresos para cumpleaños, publicidad o personalizados.',
            'tiempo' => '20 Minutos x m²',
            'estatico' => false,
            'precios' => [
                'Banner Delgado (8 onz) m²' => ['precio' => 8.00, 'insumo' =>'1', 'altura' => '', 'ancho' => ''],
                'Banner Grueso (10 onz) m²' => ['precio' => 10.00, 'insumo' =>'5', 'altura' => '', 'ancho' => ''],
            ]
        ],
        5 => [
            'nombre' => 'Lonas Luminosas',
            'nom_imagen' => 'lonas',
            'descripcion' => 'Lonas translúcidas personalizadas, ideales para destacar tu negocio con grandes tamaños y colores vibrantes.',
            'tiempo' => '30 Minutos x m²',
            'estatico' => false,
            'precios' => [
                'Lona m²' => ['precio' => 8.00, 'insumo' =>'8', 'altura' => '', 'ancho' => ''],
            ]
        ],
        6 => [
            'nombre' => 'Roll Screen',
            'nom_imagen' => 'roll',
            'descripcion' => 'Muestra tu mensaje de forma impactante con roll screens. Perfectos para eventos y promociones.',
            'tiempo' => 'Medio Día',
            'estatico' => true,
            'precios' => [
                'Estructura + Impresión (1m x 0.85m)' => ['precio' => 90.00, 'insumo' =>'14', 'altura' => '100 cm', 'ancho' => '0.85 cm'],
                'Estructura + Impresión (1m x 2m)' => ['precio' => 115.00, 'insumo' =>'15', 'altura' => '100 cm', 'ancho' => '200 cm'],
            ]
        ],
        7 => [
            'nombre' => 'Pines',
            'nom_imagen' => 'pines',
            'descripcion' => 'Pines personalizados de alta calidad, ideales para promocionar tu marca o como regalos corporativos.',
            'tiempo' => '100 Unidades en Medio Día',
            'estatico' => true,
            'precios' => [
                '100 Unidades' => ['precio' => 70.00, 'insumo' =>'21', 'altura' => '5 cm', 'ancho' => '5 cm'],
            ]
        ],
        8 => [
            'nombre' => 'Llaveros',
            'nom_imagen' => 'llaveros',
            'descripcion' => 'Llaveros personalizados de alta calidad, ideales para promocionar tu marca o como regalos corporativos.',
            'tiempo' => '100 Unidades en Medio Día',
            'estatico' => true,
            'precios' => [
                '100 Unidades' => ['precio' => 70.00, 'insumo' =>'20', 'altura' => '5 cm', 'ancho' => '5 cm'],
            ]
        ]
    ];

    // Verificar si el producto existe
    if (!isset($productos[$product_id])) {
        echo "Producto no encontrado.";
        exit;
    }

    // Obtener el producto
    $producto = $productos[$product_id];
    ?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto - <?php echo $producto['nombre']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background: linear-gradient(to bottom, #d0e7ff, #ffffff);
    }

</style>

<body>
<div class="container py-5">
    <div class="row">
        <!-- Imagen del Producto -->
        <div class="col-md-6 d-flex justify-content-center align-items-center mt-5" style="height: 100%;">
            <img src="../img/<?php echo strtolower(str_replace(' ', '_', $producto['nom_imagen'])); ?>.jpg" alt="Imagen de <?php echo $producto['nombre']; ?>" class="img-fluid rounded">
        </div>

        <!-- Detalles del Producto -->
        <div class="col-md-6">
            <h1><?php echo $producto['nombre']; ?></h1>
            <p class="lead"><?php echo $producto['descripcion']; ?></p>
            <p><strong>Tiempo de entrega:</strong> <?php echo $producto['tiempo']; ?></p>

            <div class="my-4">
                <h4>Precios:</h4>
                <ul>
                    <?php foreach ($producto['precios'] as $tipo => $detalle): ?>
                        <li>
                            <?php echo $tipo; ?>: <strong>s/.<?php echo number_format($detalle['precio'], 2); ?></strong>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <form method="POST" action="../controladores/pedidosControlador.php?accion=registrarPedido">
                <div class="mb-3">
                    <label for="product-type" class="form-label">Selecciona el tipo:</label>
                    <select id="product-type" name="product-type" class="form-select" onchange="updateTotalAndDimensions()">
                        <?php foreach ($producto['precios'] as $tipo => $detalle): ?>
                            <option value="<?php echo $tipo; ?>" data-precio="<?php echo $detalle['precio']; ?>" 
                                data-altura="<?php echo $detalle['altura']; ?>" 
                                data-ancho="<?php echo $detalle['ancho']; ?>"
                                data-insumo="<?php echo $detalle['insumo']; ?>">
                                <?php echo $tipo; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1" oninput="calculateTotal()" onkeypress="return preventEnter(event)" required>
                </div>

                <div class="mb-3">
                    <label for="product-altura" class="form-label">Altura (cm):</label>
                    <input type="<?php echo $producto['estatico'] ? 'text' : 'number'; ?>" 
                        id="product-altura" 
                        class="form-control" 
                        placeholder="Ingrese una medida en cm" 
                        onkeypress="return preventEnter(event)" 
                        <?php echo $producto['estatico'] ? 'readonly' : ''; ?>>

                </div>

                <div class="mb-3">
                    <label for="product-ancho" class="form-label">Ancho (cm):</label>
                    <input type="<?php echo $producto['estatico'] ? 'text' : 'number'; ?>" 
                        id="product-ancho" 
                        class="form-control" 
                        placeholder="Ingrese una medida en cm" 
                        onkeypress="return preventEnter(event)" 
                        <?php echo $producto['estatico'] ? 'readonly' : ''; ?>>
                </div>

                <div class="mb-3">
                    <p><strong>Total: </strong>s/.<span id="total"><?php echo number_format(reset($producto['precios'])['precio'], 2); ?></span></p>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción adicional:</label>
                    <input type="text" id="description" name="description" class="form-control" placeholder="Ingrese una descripción adicional" onkeypress="return preventEnter(event)">
                </div>

                <!-- Generar imagen y pegar URL -->
                <div class="mb-3">
                    <label for="generate-image" class="form-label">¿Quieres generar una imagen del diseño?</label>
                    <a href="../vistas/generarimagen.php" target="_blank" class="btn btn-primary">
                        <i class="fas fa-brain"></i> Generar Imagen
                    </a>
                </div>

                <div class="mb-3">
                    <label for="image-url" class="form-label">Pega la URL copiada del diseño:</label>
                    <input type="text" id="image-url" name="image_url" class="form-control" placeholder="Pega aquí la URL de la imagen generada" onkeypress="return preventEnter(event)">
                </div>

                <div class="d-flex justify-content-start gap-2 mb-3">
                    <!-- Botón de Pegar URL -->
                    <button type="button" id="paste-url-btn" onclick="pasteUrl()" class="btn btn-secondary">
                        <i class="fas fa-paste"></i> Pegar URL
                    </button>

                    <!-- Botón de Guardar Pedido -->
                    <button type="submit" onclick="submitForm()" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Pedido
                    </button>
                </div>

                <input type="hidden" name="id_cliente" value="<?php echo $_SESSION['id_cliente']; ?>"> 
                <input type="hidden" name="id_producto" value="<?php echo $product_id; ?>"> 
                <input type="hidden" name="total" id="total-input">
                <input type="hidden" id="description-input" name="description">
                <input type="hidden" id="hidden-altura" name="altura">
                <input type="hidden" id="hidden-ancho" name="ancho">
                <input type="hidden" id="hidden-insumo" name="insumo">
                <input type="hidden" id="image-url-input" name="image_url">
            </form>
        </div>
    </div>
</div>

<script>
    function pasteUrl() {
        navigator.clipboard.readText().then(text => {
            document.getElementById('image-url').value = text;
        }).catch(err => {
            console.error('Error al leer el portapapeles: ', err);
        });
    }

    function calculateTotal() {
        const selectedOption = document.querySelector('#product-type option:checked');
        const precio = parseFloat(selectedOption.dataset.precio);
        const cantidad = parseInt(document.getElementById('cantidad').value);
        const total = precio * cantidad;

        document.getElementById('total').innerText = total.toFixed(2);
        document.getElementById('total-input').value = total.toFixed(2);
    }

    function updateDimensions() {
        const selectedOption = document.querySelector('#product-type option:checked');
        const altura = selectedOption.dataset.altura;
        const ancho = selectedOption.dataset.ancho;
        const insumo = selectedOption.dataset.insumo;

        document.getElementById('hidden-altura').value = altura;
        document.getElementById('hidden-ancho').value = ancho;
        document.getElementById('hidden-insumo').value = insumo;

        // Solo actualizar campos de altura y ancho si no está en modo 'estático'
        const isStatic = <?php echo $producto['estatico'] ? 'true' : 'false'; ?>;
        if (isStatic) {
            // Si es estatico, mantiene los valores actuales sin cambiar
            document.getElementById('product-altura').value = altura;
            document.getElementById('product-ancho').value = ancho;
        }
        // Si no es estatico, los campos se mantienen igual (no se actualizan)
    }

    function updateTotalAndDimensions() {
        calculateTotal(); // Calcula el total
        updateDimensions(); // Actualiza las dimensiones solo si el tipo de producto cambia
    }

    function submitForm() {
        document.getElementById('description-input').value = document.getElementById('description').value;
        document.getElementById('image-url-input').value = document.getElementById('image-url').value;
    }

    function preventEnter(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
    }

    // Inicializa el total y las dimensiones cuando se cargue la página
    updateTotalAndDimensions();
</script>
</body>
</html>