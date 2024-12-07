<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar con Culqi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://checkout.culqi.com/js/v4"></script>
</head>
<body>
    <?php
    // Obtener el id_pedido y el monto de la URL
    $id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : null;
    $monto = isset($_GET['monto']) ? $_GET['monto'] : null;

    if (!$id_pedido || !$monto) {
        die('ID de pedido o monto no proporcionado');
    }

    // Convertir el monto a céntimos (Culqi usa montos en la menor unidad de la moneda)
    $monto_en_centimos = $monto * 100;
    ?>
    <div class="container text-center mt-5">
        <h2>Pagar Pedido #<?= htmlspecialchars($id_pedido) ?></h2>
        <p>Monto a pagar: S/ <?= number_format($monto, 2) ?></p>
        <button class="btn btn-primary mt-4" onclick="setAmountAndPay()">Pagar S/ <?= number_format($monto, 2) ?></button>
    </div>

    <div class="container text-center mt-3">
        <a href="/vistas/mispedidos.php" class="btn btn-secondary">Volver a Mis Pedidos</a>
    </div>

    <script>
        // Configuración de Culqi
        Culqi.publicKey = "<?php echo 'pk_test_4c5dd8fec33a467e'; ?>";

        let selectedAmount = <?= $monto_en_centimos ?>; // Monto dinámico

        function setAmountAndPay() {
            Culqi.settings({
                title: 'Pago de Pedido',
                currency: 'PEN',
                description: 'Pago del pedido #<?= htmlspecialchars($id_pedido) ?>',
                amount: selectedAmount, // Monto dinámico
                paymentMethods: ['card', 'yape', 'bank_transfer', 'boleto']
            });
            Culqi.open();
        }

        function culqi() {
            if (Culqi.token) {
                var token = Culqi.token.id;
                var email = Culqi.token.email;

                var form = document.createElement("form");
                form.method = "POST";
                form.action = "../controladores/ProcesoCulqi.php";

                var tokenField = document.createElement("input");
                tokenField.type = "hidden";
                tokenField.name = "token";
                tokenField.value = token;

                var amountField = document.createElement("input");
                amountField.type = "hidden";
                amountField.name = "amount";
                amountField.value = selectedAmount;

                var emailField = document.createElement("input");
                emailField.type = "hidden";
                emailField.name = "email";
                emailField.value = email;

                // Agregar el campo id_pedido
                var pedidoField = document.createElement("input");
                pedidoField.type = "hidden";
                pedidoField.name = "id_pedido";
                pedidoField.value = "<?php echo htmlspecialchars($id_pedido); ?>";

                form.appendChild(tokenField);
                form.appendChild(amountField);
                form.appendChild(emailField);
                form.appendChild(pedidoField);
                document.body.appendChild(form);
                form.submit();
            } else {
                console.error("No se obtuvo el token de Culqi");
                alert("Error: " + Culqi.error.user_message);
            }
        }
    </script>
</body>
</html>
