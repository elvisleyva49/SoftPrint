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
            <title>Generador de Imágenes</title>
            <style>
                .image-container {
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                    margin-top: 30px;
                }
                .single-image-container {
                    text-align: center;
                    width: 45%;
                }
                .single-image-container img {
                    max-width: 100%;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
                }
                .image-buttons {
                    display: flex;
                    justify-content: center;
                    gap: 10px;
                    margin-top: 15px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Generador de Imágenes con DALL-E</h1>
                
                <?php if ($error): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <form method="POST">
                    <label for="prompt">Describe las imágenes que quieres generar:</label><br>
                    <input type="text" id="prompt" name="prompt" required>
                    <div class="button-container">
                        <button type="submit">
                            <i class="fas fa-image"></i> Generar Imágenes
                        </button>
                        <button type="button" onclick="window.location.href='../index.php';">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </button>
                    </div>
                </form>

                <?php if (!empty($imageUrls)): ?> 
                    <div class="image-container">
                        <?php foreach ($imageUrls as $index => $imageUrl): ?>
                            <div class="single-image-container">
                                <h2>Imagen <?php echo $index + 1; ?></h2>
                                <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Imagen generada <?php echo $index + 1; ?>">
                                <div class="image-buttons">
                                    <a href="<?php echo htmlspecialchars($imageUrl); ?>" target="_blank" class="button-link">
                                        <i class="fas fa-external-link-alt"></i> Abrir imagen
                                    </a>
                                    <button onclick="downloadImage('<?php echo htmlspecialchars($imageUrl); ?>', 'imagen_<?php echo $index + 1; ?>.png')" class="button-link">
                                        <i class="fas fa-download"></i> Descargar
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
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