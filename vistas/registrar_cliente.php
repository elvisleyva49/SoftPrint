<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="../css/registrarcliente.css"> <!-- Enlaza tu archivo de estilos si lo necesitas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarDepartamentos();
        });

        function cargarDepartamentos() {
            fetch(`../controladores/UbigeoControlador.php?accion=departamentos`)
                .then(response => response.json())
                .then(data => {
                    const departamentosSelect = document.getElementById("departamentos");
                    departamentosSelect.innerHTML = "<option value=''>Seleccione un departamento</option>";

                    data.forEach(departamento => {
                        const option = document.createElement("option");
                        option.value = departamento.cod_ubigeo; // Ajusta según tu modelo de datos
                        option.text = departamento.descripcion; // Ajusta según tu modelo de datos
                        departamentosSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar departamentos:', error));
        }

        function cargarProvincias() {
            const departamentoSeleccionado = document.getElementById("departamentos").value;
            const provinciasSelect = document.getElementById("provincias");
            const distritosSelect = document.getElementById("distritos");

            // Restablecer el combobox de provincias y distritos
            provinciasSelect.innerHTML = "<option value=''>Seleccione una provincia</option>";
            distritosSelect.innerHTML = "<option value=''>Seleccione un distrito</option>";

            if (departamentoSeleccionado) {
                fetch(`../controladores/UbigeoControlador.php?accion=provincias&departamento=${departamentoSeleccionado}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(provincia => {
                            const option = document.createElement("option");
                            option.value = provincia.cod_ubigeo; // Ajusta según tu modelo de datos
                            option.text = provincia.descripcion; // Ajusta según tu modelo de datos
                            provinciasSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al cargar provincias:', error));
            }
        }

        function cargarDistritos() {
            const provinciaSeleccionada = document.getElementById("provincias").value;
            const distritosSelect = document.getElementById("distritos");

            // Restablecer el combobox de distritos
            distritosSelect.innerHTML = "<option value=''>Seleccione un distrito</option>";

            if (provinciaSeleccionada) {
                fetch(`../controladores/UbigeoControlador.php?accion=distritos&provincia=${provinciaSeleccionada}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(distrito => {
                            const option = document.createElement("option");
                            option.value = distrito.cod_ubigeo; // Ajusta según tu modelo de datos
                            option.text = distrito.descripcion; // Ajusta según tu modelo de datos
                            distritosSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al cargar distritos:', error));
            }
        }
    </script>
</head>
<body>


    <?php
    // Obtener el idusuario de la URL
    $idusuario = isset($_GET['idusuario']) ? $_GET['idusuario'] : '';
    ?>
    <form action="../controladores/ClienteControlador.php?accion=registrar_cliente" method="POST">
        <h1>Registrar Cliente</h1>
        
        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($idusuario); ?>">    

        <!-- Nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <!-- Apellido -->
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        <br><br>

        <!-- DNI -->
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required maxlength="8" minlength="8" pattern="\d{8}" title="Debe ser un número de 8 dígitos">
        <br><br>

        <!-- Celular -->
        <label for="celular">Celular:</label>
        <input type="text" id="celular" name="celular" required maxlength="9" pattern="\d{9}" title="Debe ser un número de 9 dígitos">
        <br><br>

        <!-- Combo Box de Departamentos -->
        <label for="departamentos">Departamento:</label>
        <select id="departamentos" name="departamento" onchange="cargarProvincias()" required>
            <option value="">Seleccione un departamento</option>
        </select>
        <br><br>

        <!-- Combo Box de Provincias -->
        <label for="provincias">Provincia:</label>
        <select id="provincias" name="provincia" onchange="cargarDistritos()" required>
            <option value="">Seleccione una provincia</option>
        </select>
        <br><br>

        <!-- Combo Box de Distritos -->
        <label for="distritos">Distrito:</label>
        <select id="distritos" name="distrito" required>
            <option value="">Seleccione un distrito</option>
        </select>
        <br><br>

        <input type="submit" value="Registrar">
    </form>

</body>
</html>
