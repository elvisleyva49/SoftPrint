<?php
session_start();

class PollinationsImageGenerator {
    public function generateImage($prompt) {
        $seed = rand(1, 9999999);
        $encodedPrompt = urlencode($prompt);
        $url = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=1024&height=1024&nologo=true&seed={$seed}";

        // Descargar la imagen usando cURL desde el servidor (PHP)
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Usamos un User-Agent de navegador para evitar que la API bloquee la solicitud
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200 && $imageData) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageData);
            
            // Si la respuesta es una imagen y no un JSON de error
            if (strpos($mimeType, 'image/') === 0) {
                $dir = '../img/generadas';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                
                $filename = 'gen_' . time() . '_' . $seed . '.jpg';
                $filepath = $dir . '/' . $filename;
                
                // Guardamos la imagen localmente
                file_put_contents($filepath, $imageData);
                
                return $filepath;
            } else {
                throw new Exception("Error interno de la API: " . htmlspecialchars($imageData));
            }
        }
        
        throw new Exception("Error de conexión. Código HTTP: " . $httpCode);
    }
}

// Página PHP completa para generación de imágenes
class ImageGeneratorPage {
    private $generator;

    public function __construct() {
        // Inicializa el generador gratuito de Pollinations AI
        $this->generator = new PollinationsImageGenerator();
    }

    public function render() {
        $imageUrls = [];
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $prompt = $_POST['prompt'] ?? '';
                if (empty($prompt)) {
                    throw new Exception("Por favor, ingresa un prompt");
                }

                // Generar dos imágenes secuencialmente
                $imageUrls[] = $this->generator->generateImage($prompt);
                
                // Modificar ligeramente el prompt para la segunda imagen
                $modifiedPrompt = $prompt . " (alternate version)";
                $imageUrls[] = $this->generator->generateImage($modifiedPrompt);

                // Guardar las URLs de las imágenes generadas en la sesión
                $_SESSION['generated_image_urls'] = $imageUrls;

            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        // Renderizar HTML
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>AI Studio | SoftPrint</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: 'Poppins', sans-serif;
                    margin: 0;
                    padding: 0;
                    color: #f5f5f5;
                    min-height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    /* Gradiente oscuro animado tipo AI */
                    background: linear-gradient(-45deg, #0f172a, #1e1b4b, #09090b, #172554);
                    background-size: 400% 400%;
                    animation: gradientBG 15s ease infinite;
                }

                @keyframes gradientBG {
                    0% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                    100% { background-position: 0% 50%; }
                }

                /* Botón flotante para volver al inicio */
                .back-btn {
                    position: absolute;
                    top: 30px;
                    left: 30px;
                    color: #94a3b8;
                    text-decoration: none;
                    font-size: 14px;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    z-index: 20;
                    transition: all 0.3s ease;
                    background: rgba(30, 41, 59, 0.5);
                    padding: 10px 20px;
                    border-radius: 30px;
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.05);
                }

                .back-btn:hover {
                    color: #ffffff;
                    background: rgba(59, 130, 246, 0.5);
                    transform: translateX(-4px);
                    border-color: rgba(96, 165, 250, 0.5);
                }

                .container {
                    margin: 40px 20px; 
                    padding: 50px 60px;
                    width: 100%;
                    max-width: 1000px;
                    background: rgba(15, 23, 42, 0.6);
                    backdrop-filter: blur(20px);
                    -webkit-backdrop-filter: blur(20px);
                    border-radius: 24px;
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
                    border: 1px solid rgba(255, 255, 255, 0.05);
                    text-align: center;
                    animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
                }

                @keyframes fadeUp {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }

                h1 {
                    font-size: 2.8em;
                    margin-top: 0;
                    margin-bottom: 10px;
                    color: #ffffff; 
                    font-weight: 600;
                    letter-spacing: -0.5px;
                }

                .subtitle {
                    color: #94a3b8;
                    font-size: 1.1em;
                    margin-bottom: 40px;
                }

                form {
                    margin-top: 20px;
                    max-width: 800px;
                    margin-left: auto;
                    margin-right: auto;
                }

                .input-wrapper {
                    position: relative;
                    margin-bottom: 30px;
                }

                .input-wrapper i.magic-icon {
                    position: absolute;
                    left: 20px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #3b82f6;
                    font-size: 1.2em;
                }

                input[type="text"] {
                    width: 100%;
                    box-sizing: border-box;
                    padding: 20px 20px 20px 55px;
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    border-radius: 16px;
                    font-size: 1.1em;
                    background-color: rgba(0, 0, 0, 0.3);
                    color: #ffffff;
                    font-family: 'Poppins', sans-serif;
                    transition: all 0.3s ease;
                }

                input[type="text"]::placeholder {
                    color: #64748b;
                }

                input[type="text"]:focus {
                    border-color: #60a5fa; 
                    outline: none;
                    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2); 
                    background-color: rgba(0, 0, 0, 0.5);
                }

                .button-container {
                    display: flex;
                    justify-content: center;
                    gap: 15px;
                    margin-top: 20px;
                }

                button {
                    padding: 16px 32px;
                    font-size: 1.1em;
                    font-weight: 500;
                    border: none;
                    border-radius: 12px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-family: 'Poppins', sans-serif;
                }

                button i {
                    margin-right: 10px;
                }

                button[type="submit"] {
                    background: linear-gradient(135deg, #2563eb, #4f46e5); 
                    color: #ffffff;
                    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
                }

                button[type="submit"]:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5); 
                }

                button[type="submit"]:active {
                    transform: translateY(0);
                }

                .error {
                    background-color: rgba(239, 68, 68, 0.1);
                    color: #f87171;
                    padding: 15px;
                    border-radius: 8px;
                    border: 1px solid rgba(239, 68, 68, 0.2);
                    margin-bottom: 30px;
                    font-size: 1em;
                }

                /* Sección de Resultados */
                .results-section {
                    margin-top: 50px;
                    border-top: 1px solid rgba(255, 255, 255, 0.05);
                    padding-top: 40px;
                }

                .image-container {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 30px;
                }

                @media (max-width: 768px) {
                    .image-container {
                        grid-template-columns: 1fr;
                    }
                    .container {
                        padding: 30px 20px;
                    }
                }

                .single-image-card {
                    background: rgba(255, 255, 255, 0.03);
                    border: 1px solid rgba(255, 255, 255, 0.05);
                    border-radius: 16px;
                    padding: 20px;
                    transition: transform 0.3s ease;
                }

                .single-image-card:hover {
                    transform: translateY(-5px);
                    background: rgba(255, 255, 255, 0.05);
                }

                .single-image-card h2 {
                    font-size: 1.2em;
                    color: #e2e8f0;
                    margin-top: 0;
                    margin-bottom: 15px;
                }

                .single-image-card img {
                    width: 100%;
                    border-radius: 12px;
                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
                }

                .image-buttons {
                    display: flex;
                    justify-content: center;
                    gap: 10px;
                    margin-top: 20px;
                }

                .button-link {
                    display: inline-flex;
                    align-items: center;
                    padding: 12px 20px;
                    text-decoration: none;
                    font-size: 0.95em;
                    font-weight: 500;
                    border-radius: 8px;
                    color: #e2e8f0;
                    background-color: rgba(255, 255, 255, 0.1); 
                    transition: all 0.2s ease;
                    border: 1px solid rgba(255, 255, 255, 0.05);
                    cursor: pointer;
                }

                .button-link i {
                    margin-right: 8px;
                }

                .button-link:hover {
                    background-color: rgba(59, 130, 246, 0.2); 
                    color: #ffffff;
                    border-color: rgba(59, 130, 246, 0.4);
                }
                
                button.btn-download {
                    background-color: rgba(16, 185, 129, 0.15);
                    color: #34d399;
                    border-color: rgba(16, 185, 129, 0.2);
                }
                button.btn-download:hover {
                    background-color: rgba(16, 185, 129, 0.3);
                    color: #ffffff;
                    border-color: rgba(16, 185, 129, 0.5);
                }

                /* Overlay de Carga Simple */
                #simple-loading-overlay {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(15, 23, 42, 0.9);
                    backdrop-filter: blur(10px);
                    z-index: 9999;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    color: white;
                }

                #simple-loading-overlay.show {
                    display: flex;
                }

                .spinner {
                    font-size: 4em;
                    color: #3b82f6;
                    margin-bottom: 25px;
                }

                .loading-message {
                    font-size: 1.3em;
                    font-weight: 500;
                    text-align: center;
                    color: #e2e8f0;
                    line-height: 1.5;
                }
            </style>
        </head>
        <body>
            <!-- Overlay de carga simple -->
            <div id="simple-loading-overlay">
                <div class="spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="loading-message">
                    Se está generando la imagen...<br>Por favor, espera unos minutos.
                </div>
            </div>
            <!-- Botón de regreso -->
            <a href="../index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Volver al inicio
            </a>

            <div class="container">
                <h1>SoftPrint AI Studio</h1>
                <div class="subtitle">Generador de Imágenes Creativas</div>
                
                <?php if ($error): ?>
                    <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="input-wrapper">
                        <i class="fas fa-wand-magic-sparkles magic-icon"></i>
                        <input type="text" id="prompt" name="prompt" placeholder="Ej: Un zorro cyberpunk en una ciudad neón realista, 8k..." required>
                    </div>
                    <div class="button-container">
                        <button type="submit">
                            <i class="fas fa-sparkles"></i> Generar Arte AI
                        </button>
                    </div>
                </form>

                <?php if (!empty($imageUrls)): ?> 
                    <div class="results-section">
                        <div class="image-container">
                            <?php foreach ($imageUrls as $index => $imageUrl): ?>
                                <div class="single-image-card">
                                    <h2>Opción <?php echo $index + 1; ?></h2>
                                    <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Imagen generada <?php echo $index + 1; ?>">
                                    <div class="image-buttons">
                                        <a href="<?php echo htmlspecialchars($imageUrl); ?>" target="_blank" class="button-link">
                                            <i class="fas fa-external-link-alt"></i> Abrir
                                        </a>
                                        <button onclick="downloadImage('<?php echo htmlspecialchars($imageUrl); ?>', 'softprint_ai_<?php echo $index + 1; ?>.png')" class="button-link btn-download">
                                            <i class="fas fa-download"></i> Descargar
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <script>
                function downloadImage(url, filename) {
                    fetch(url)
                        .then(response => response.blob())
                        .then(blob => {
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.download = filename;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        })
                        .catch(error => {
                            console.error('Error downloading image:', error);
                            alert('No se pudo descargar la imagen');
                        });
                }

                // Lógica para mostrar la pantalla de carga
                document.querySelector('form').addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
                    
                    document.getElementById('simple-loading-overlay').classList.add('show');
                });
                </script>
            </div>
        </body>
        </html>
        <?php
    }
}

$page = new ImageGeneratorPage();
$page->render();
?>