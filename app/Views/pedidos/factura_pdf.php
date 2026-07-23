<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .encabezado {
            width: 100%;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .encabezado h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 22px;
        }
        .encabezado p {
            margin: 2px 0;
            font-size: 11px;
        }
        .tabla-info {
            width: 100%;
            margin-bottom: 20px;
        }
        .tabla-info td {
            vertical-align: top;
            width: 50%;
        }
        .tabla-info h3 {
            font-size: 13px;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.items th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table.items td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        .totales {
            width: 40%;
            margin-left: 60%;
        }
        .totales td {
            padding: 5px 8px;
        }
        .totales .total-final {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #2c3e50;
        }
        .pie {
            margin-top: 30px;
            font-size: 10px;
            color: #888;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="encabezado">
        <h1>BodeTlax</h1>
        <p>Materiales de construcción</p>
        <p>Comprobante de compra #<?= esc($pedido['id']) ?></p>
    </div>

    <table class="tabla-info">
        <tr>
            <td>
                <h3>Datos del cliente</h3>
                <p><?= esc($cliente['nombre_completo']) ?></p>
                <p><?= esc($cliente['email']) ?></p>
                <p><?= esc($pedido['direccion_envio']) ?></p>
            </td>
            <td>
                <h3>Datos del pedido</h3>
                <p>Fecha: <?= esc($pedido['created_at']) ?></p>
                <p>Estado: <?= esc(ucfirst($pedido['estado'])) ?></p>
                <p>Método de pago: <?= esc(ucfirst($pedido['metodo_pago'])) ?></p>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= esc($item['nombre_producto']) ?></td>
                    <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                    <td><?= esc($item['cantidad']) ?></td>
                    <td>$<?= number_format($item['total_linea'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="totales">
        <tr><td>Subtotal:</td><td>$<?= number_format($pedido['subtotal'], 2) ?></td></tr>
        <tr><td>IVA (16%):</td><td>$<?= number_format($pedido['impuesto'], 2) ?></td></tr>
        <tr><td>Envío:</td><td>$<?= number_format($pedido['costo_envio'], 2) ?></td></tr>
        <tr class="total-final"><td>TOTAL:</td><td>$<?= number_format($pedido['total'], 2) ?></td></tr>
    </table>

    <div class="pie">
        Este documento es un comprobante de compra generado electrónicamente por BodeTlax.<br>
        Gracias por tu compra.
    </div>

</body>
</html>