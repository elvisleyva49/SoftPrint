<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - America Imprenta</title>
    <link rel="stylesheet" href="css/productos.css">
</head>
<body>
<div class="products-container">
    <h1 class="products-title">NUESTROS PRODUCTOS</h1>
    <div class="products">
        
        <!-- Tarjeta de producto -->
        <div class="flip-card-container">
        <p class="card-text">Tarjetas de Presentación</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/tarjetas.jpg" alt="Producto 1" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Impacta con estilo</strong><br>
                                Elige entre una variedad de estilos, acabados y materiales que destacan tu marca con calidad
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                El tiempo de entrega es de 3 días
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                Tarjeta Mate Millar: <strong>s/.75.00</strong><br>
                                Tarjeta Brillo Millar: <strong>s/.55.00</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="1">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>

        </div>

        <!-- VOLANTES -->
        <div class="flip-card-container">
        <p class="card-text">Volantes</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/volantes.jpg" alt="Producto 2" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Destaca con volantes publicitarios de alta calidad</strong><br>
                                Selecciona entre múltiples estilos y tamaños que realzan la imagen de tu marca
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                El tiempo de entrega es de 3 días
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                A6 Millar Volantes: <strong>s/.70.00</strong><br>
                                A5 Millar Volantes: <strong>s/.140.00</strong><br>
                                A4 Millar Volantes: <strong>s/.280.00</strong><br>
                                A3 Millar Volantes: <strong>s/.560.00</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="2">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>

        </div>

        <!-- STICKERS -->
        <div class="flip-card-container">
        <p class="card-text">Stickers Adhesivos</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/stickers.jpg" alt="Producto 3" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Crea diseños únicos</strong><br>
                                Ofrecemos stickers adhesivos personalizados a gusto del cliente de alta calidad 
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                20 Minutos x m²
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                m² Economico: <strong>s/.22.00</strong><br>
                                m² Premium: <strong>s/.25.00</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="3">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>
        </div>

        <!-- banners -->
        <div class="flip-card-container">
        <p class="card-text">Banners Personalizados</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/banners.jpg" alt="Producto 4" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Gigantografias Personalizadas</strong><br>
                                Celebra momentos especiales con banners para cumpleaños, publicidad o personalizados
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                20 Minutos x m²
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                Bannner Delgado (8 onz) m²: <strong>s/.8.00</strong><br>
                                Bannner Grueso (10 onz) m²: <strong>s/.10.00</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="4">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>
        </div>

        <!-- lonas -->
        <div class="flip-card-container">
        <p class="card-text">Lonas Luminosas</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/lonas.jpg" alt="Producto 5" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Atrae clientes</strong><br>
                            lonas translucidas personalizadas, ideales para destacar tu negocio con grandes tamaños y colores vibrantes, tanto en interiores como exteriores
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                30 Minutos x m²
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                Lona m²: <strong>s/.25.00</strong><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="5">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>
        </div>

        <!-- rollscreen -->
        <div class="flip-card-container">
        <p class="card-text">Roll Screen</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/roll.jpg" alt="Producto 6" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Rolls screens</strong><br>
                            Perfectos para eventos y promociones. Son fáciles de transportar y montar.
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                Medio Dia de Entrega
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                Estructura + Impresion (1m x 0.85cm): <strong>s/.90.00</strong><br>
                                Estructura + Impresion (1m x 2m): <strong>s/.115.00</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="6">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>
        </div>

        <!-- pines -->
        <div class="flip-card-container">
        <p class="card-text">Pines</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/pines.jpg" alt="Producto 7" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Pines personalizados de alta calidad</strong><br>
                            Ideales para promocionar tu marca o como regalos corporativos
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                100 Unidades Medio Dia
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                s/70 soles (100 unidades)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="7">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>
        </div>

        <!-- llaveros -->
        <div class="flip-card-container">
        <p class="card-text">LLaveros</p><br>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="img/llaveros.jpg" alt="Producto 8" class="product-img">
                    </div>
                    <div class="flip-card-back">
                        <div class="product-details">
                            <p><strong><i class="fas fa-paint-brush"></i> Llaveros personalizados de alta calidad</strong><br>
                            Ideales para promocionar tu marca o como regalos corporativos
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-clock"></i> Tiempo</strong><br>
                                100 Unidades Medio Dia
                            </p>
                            <hr>
                            <p><strong><i class="fas fa-tag"></i> Precios</strong><br>
                                s/70 soles (100 unidades)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="centro">
                <!-- Formulario para enviar el producto -->
                <form action="vistas/guardar_pedido.php" method="POST">
                    <input type="hidden" name="product_id" value="8">
                    <button type="submit" class="button">
                        <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                        <p class="text">Agregar Producto</p>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
