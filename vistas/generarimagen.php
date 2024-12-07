<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #121212;
        color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        text-align: center;

        background: linear-gradient(
            135deg,
            #121212 25%,
            #1a1a1a 25%,
            #1a1a1a 50%,
            #121212 50%,
            #121212 75%,
            #1a1a1a 75%,
            #1a1a1a
        );
        background-size: 40px 40px;
        animation: move 4s linear infinite;
    }

    @keyframes move {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 40px 40px;
        }
    }

    .container {
        margin: 100px; 
        padding: 40px 40px;
        width: 100%;
        max-width: 1500px;
        background-color: #1e1e1e;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
    }

    h1 {
        font-size: 3em;
        margin-bottom: 30px;
        color: #007bff; 
        font-weight: 600;
    }

    form {
        margin-top: 20px;
    }

    label {
        font-size: 1.5em;
        color: #cccccc;
        margin-bottom: 15px;
        display: inline-block;
    }

    input[type="text"] {
        width: 100%;
        padding: 15px;
        margin: 15px 0;
        border: 1px solid #333;
        border-radius: 8px;
        font-size: 1.2em;
        background-color: #292929;
        color: #f5f5f5;
    }

    input[type="text"]:focus {
        border-color: #1E3A8A; 
        outline: none;
        box-shadow: 0 0 8px #1E3A8A; 
    }

    .button-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }

    button {
        padding: 20px 30px;
        font-size: 1.2em;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    button i {
        margin-right: 15px;
    }

    button[type="submit"] {
        background-color: #1E3A8A; 
        color: #ffffff;
    }

    button[type="submit"]:hover {
        background-color: #1E40AF; 
    }

    button[type="button"] {
        background-color: #333;
        color: #f5f5f5;
    }

    button[type="button"]:hover {
        background-color: #444;
    }

    .button-link {
        display: inline-block;
        padding: 15px 25px;
        text-decoration: none;
        font-size: 1.2em;
        border-radius: 8px;
        color: #fff;
        background-color: #1E3A8A; 
        transition: all 0.3s ease;
        margin-right: 40px; 
    }

    .button-link:hover {
        background-color: #0056b3; 
    }


    .error {
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 30px;
        font-size: 1.2em;
    }

    img {
        max-width: 80%;
        border-radius: 8px;
        margin-top: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    .links {
        margin-top: 30px;
    }

    .links a {
        display: inline-block;
        margin: 15px;
        padding: 15px 25px;
        text-decoration: none;
        font-size: 1.2em;
        border-radius: 8px;
        color: #f5f5f5;
        transition: all 0.3s ease;
    }

    .links a:first-child {
        background-color: #4caf50;
    }

    .links a:first-child:hover {
        background-color: #3d8c40;
    }

    .links a:last-child {
        background-color: #3498db;
    }

    .links a:last-child:hover {
        background-color: #2874a6;
    }
</style>

<?php
session_start();

class AzureOpenAIImageGenerator {
    private $apiVersion;
    private $azureEndpoint;
    private $apiKey;

    public function __construct($apiKey, $azureEndpoint, $apiVersion = "2024-02-01") {
        $this->apiKey = $apiKey;
        $this->azureEndpoint = $azureEndpoint;
        $this->apiVersion = $apiVersion;
    }

    public function generateImage($prompt, $n = 1, $size = "1024x1024", $quality = "standard", $style = "vivid") {
        $url = rtrim($this->azureEndpoint, '/') . "/openai/deployments/dall-e-3/images/generations?api-version={$this->apiVersion}";

        $data = [
            'prompt' => $prompt,
            'n' => $n,
            'size' => $size,
            'quality' => $quality,
            'style' => $style
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'api-key: ' . $this->apiKey
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }
        
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode == 200 && isset($responseData['data'][0]['url'])) {
            return $responseData['data'][0]['url'];
        } else {
            throw new Exception("Error generando imagen: " . 
                ($responseData['error']['message'] ?? 'Unknown error'));
        }
    }
}

// Página PHP completa para generación de imágenes
class ImageGeneratorPage {
    private $generator;

    public function __construct() {
        // Configura tus credenciales de Azure OpenAI
        $apiKey = "2Lm57xrCZ9fG0akhulPusH78RJeuqcUy8lAoHpYTcrmEB4iBUMjaJQQJ99AKACfhMk5XJ3w3AAAAACOGxb8h";
        $azureEndpoint = "https://blast-m3qxqoht-swedencentral.cognitiveservices.azure.com/";
        
        $this->generator = new AzureOpenAIImageGenerator($apiKey, $azureEndpoint);
    }

    public function render() {
        $imageUrl = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $prompt = $_POST['prompt'] ?? '';
                if (empty($prompt)) {
                    throw new Exception("Por favor, ingresa un prompt");
                }

                // Generar imagen
                $imageUrl = $this->generator->generateImage($prompt);
                // Guardar la URL de la imagen generada en la sesión
                $_SESSION['generated_image_url'] = $imageUrl;

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
            <title>Generador de Imágenes</title>
        </head>
        <body>
            <div class="container">
                <?php
                // Incluir el archivo de loader.php
                    include_once("../vistas/loader.php");
                ?>
                <h1>Generador de Imágenes con DALL-E</h1>
                
                <?php if ($error): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <form method="POST">
                    <label for="prompt">Describe la imagen que quieres generar:</label><br>
                    <input type="text" id="prompt" name="prompt" required>
                    <div class="button-container">
                        <button type="submit">
                            <i class="fas fa-image"></i> Generar Imagen
                        </button>
                        <button type="button" onclick="window.history.back();">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </button>

                    </div>
                </form>

                <?php if ($imageUrl): ?> 
                    <h2>Imagen Generada:</h2>
                    <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Imagen generada">
                    <p>
                        <a href="<?php echo htmlspecialchars($imageUrl); ?>" target="_blank" class="button-link">
                            <i class="fas fa-external-link-alt"></i> Abrir imagen en nueva pestaña
                        </a>
                        <a href="ver3d.php?imagen=<?php echo urlencode($imageUrl); ?>" class="button-link">
                            <i class="fas fa-cube"></i> Ver en 3D
                        </a>
                        <button onclick="copyToClipboard('<?php echo htmlspecialchars($imageUrl); ?>')" class="button-link">
                            <i class="fas fa-copy"></i> Copiar URL al portapapeles
                        </button>
                    
                        <button type="button" onclick="window.history.go(-2);">
                            <i class="fas fa-arrow-left"></i> Registrar Imagen
                        </button>
                    </p>
                <?php endif; ?>
                <script>
    function copyToClipboard(url) {
        // Crea un campo de texto temporal para copiar la URL
        var tempInput = document.createElement("input");
        tempInput.value = url;
        document.body.appendChild(tempInput);

        // Selecciona el contenido del campo de texto
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // Para dispositivos móviles

        // Intenta copiar al portapapeles
        try {
            document.execCommand("copy");
            alert("URL copiada al portapapeles!");
        } catch (err) {
            alert("No se pudo copiar la URL");
        }

        // Elimina el campo de texto temporal
        document.body.removeChild(tempInput);
    }
</script>
            </div>
        </body>
            <!-- Aquí es donde debes pegar tu script -->
            <script>
                function toggleLoadingCode(show) {
                    const loadingCodeElement = document.getElementById('loading-code');
                    loadingCodeElement.style.display = show ? 'block' : 'none';
                }
            </script>
        </html>
        <?php
    }
}

$page = new ImageGeneratorPage();
$page->render();
?>
