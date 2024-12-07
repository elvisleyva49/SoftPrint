<?php
$imageUrl = $_GET['imagen'] ?? '';
if (empty($imageUrl)) {
    die('No se proporcionó una imagen');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización 3D del Banner</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
        margin: 0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100vh;

        }
        canvas {
            width: 100vw;
            height: 100vh;
            display: block;

        }
        .back-button {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.2em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            z-index: 1000;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .back-button i {
            font-size: 1.5em;
        }
    </style>
    <script src="https://cdn.babylonjs.com/babylon.js"></script>
</head>
<body>
    <canvas id="renderCanvas"></canvas>

    <!-- Botón de regresar centrado en la parte inferior -->
    <button type="button" class="back-button" onclick="window.location.href='/vistas/generarimagen.php';">
        <i class="fas fa-arrow-left"></i> Regresar
    </button>

    <script>
        const canvas = document.getElementById('renderCanvas');
        const engine = new BABYLON.Engine(canvas, true);

        const createScene = () => {
            const scene = new BABYLON.Scene(engine);
            const camera = new BABYLON.ArcRotateCamera("camera", Math.PI / 2, Math.PI / 2, 13, BABYLON.Vector3.Zero(), scene);
            
            camera.wheelPrecision = 17;
            camera.lowerRadiusLimit = 5;
            camera.upperRadiusLimit = 40;
            
            camera.attachControl(canvas, true);

            const ambientLight = new BABYLON.HemisphericLight("ambientLight", new BABYLON.Vector3(0, 1, 0), scene);
            ambientLight.intensity = 1;

            const img = new Image();
            img.src = "<?php echo $imageUrl; ?>";
            
            img.onload = function() {
                const aspectRatio = img.width / img.height;
                const planeHeight = 10;
                const planeWidth = planeHeight * aspectRatio;

                const plane = BABYLON.MeshBuilder.CreatePlane("planeFront", {
                    width: planeWidth,
                    height: planeHeight
                }, scene);

                const materialFront = new BABYLON.StandardMaterial("materialFront", scene);
                materialFront.diffuseTexture = new BABYLON.Texture("<?php echo $imageUrl; ?>", scene);
                materialFront.specularColor = new BABYLON.Color3(0, 0, 0);
                materialFront.emissiveColor = new BABYLON.Color3(1, 1, 1);
                plane.material = materialFront;

                const planeBack = BABYLON.MeshBuilder.CreatePlane("planeBack", {
                    width: planeWidth,
                    height: planeHeight
                }, scene);

                const materialBack = new BABYLON.StandardMaterial("materialBack", scene);
                materialBack.diffuseColor = new BABYLON.Color3(0.2, 0.1, 0.1);
                planeBack.material = materialBack;

                plane.rotation.y = Math.PI;
                plane.rotation.x = 0;
                planeBack.rotation.y = 0;

                planeBack.position.z = -0.01;

                const maxDimension = Math.max(planeWidth, planeHeight);
                camera.radius = maxDimension * 1.5;
            };

            return scene;
        };

        const scene = createScene();

        engine.runRenderLoop(() => {
            scene.render();
        });

        window.addEventListener("resize", () => {
            engine.resize();
        });
    </script>
</body>
</html>
