<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor</title>
    <!-- Bootstrap CSS solo para este archivo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos solo para este formulario */
        .register-page {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            margin-top: 80px; /* suba más */
            width: 100%;
            max-width: 900px; 
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            color: #003f7f;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container label {
            font-weight: bold;
            color: #003f7f;
        }

        .form-container input {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
        }

        .form-container input:focus {
            border-color: #0044cc;
            box-shadow: 0 0 5px rgba(0, 68, 204, 0.5);
        }

        .form-container button {
            background-color: #0044cc;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .form-container button:hover {
            background-color: #0036a3;
        }
    </style>
</head>
<body>
    <!-- Envuelve el contenido de la página con una clase específica -->
    <div class="register-page">
        <div class="form-container">
            <form action="../controladores/ProveedorControlador.php?accion=registrarProveedor" method="POST">
                <h1>Registrar Proveedor</h1>

                <!-- Fila con dos columnas -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ruc" class="form-label">RUC:</label>
                        <input type="text" id="ruc" name="ruc" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="celular" class="form-label">Celular:</label>
                        <input type="text" id="celular" name="celular" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS solo para este archivo -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
