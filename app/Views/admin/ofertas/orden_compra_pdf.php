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
        .nota-legal {
            margin-top: 25px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .firma {
            margin-top: 50px;
            width: 100%;
        }
        .firma td {
            width: 50%;
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid #333;
            font-size: 11px;
        }
        .pie {
            margin-top: 30px;
            font-size: 10px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="encabezado">
        <h1>BodeTlax</h1>
        <p>Materiales de construcción</p>
        <p>Orden de compra #<?= esc($oferta['id']) ?></p>
    </div>

    <table class="tabla-info">
        <tr>
            <td>
                <h3>Datos del proveedor</h3>
                <p><?= esc($oferta['proveedor_nombre']) ?></p>
                <p><?= esc($proveedor['email']) ?></p>
                <?php if (! empty($proveedor['telefono'])): ?>
                    <p>Tel: <?= esc($proveedor['telefono']) ?></p>
                <?php endif; ?>
            </td>
            <td>
                <h3>Datos de la orden</h3>
                <p>Fecha de aceptación: <?= esc($oferta['updated_at']) ?></p>
                <p>Categoría: <?= esc($oferta['categoria_nombre']) ?></p>
                <p>Estado: <?= esc(ucfirst($oferta['estado'])) ?></p>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Unidad</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= esc($oferta['nombre_producto']) ?></td>
                <td><?= esc($oferta['unidad_medida']) ?></td>
                <td>$<?= number_format($oferta['precio_ofertado'], 2) ?></td>
                <td><?= esc($oferta['cantidad_ofertada']) ?></td>
                <td>$<?= number_format($oferta['precio_ofertado'] * $oferta['cantidad_ofertada'], 2) ?></td>
            </tr>
        </tbody>
    </table>

    <table class="totales">
        <tr class="total-final">
            <td>TOTAL A PAGAR:</td>
            <td>$<?= number_format($oferta['precio_ofertado'] * $oferta['cantidad_ofertada'], 2) ?></td>
        </tr>
    </table>

    <div class="nota-legal">
        Esta orden de compra confirma que BodeTlax acepta adquirir el producto y cantidad aquí descritos,
        bajo los términos acordados con el proveedor. El pago se realizará conforme a las políticas
        internas del negocio, una vez confirmada la recepción de la mercancía en buen estado.
    </div>

    <table class="firma">
        <tr>
            <td>Firma - BodeTlax</td>
            <td>Firma - Proveedor</td>
        </tr>
    </table>

    <div class="pie">
        Documento generado electrónicamente por BodeTlax — Orden de compra #<?= esc($oferta['id']) ?>
    </div>

</body>
</html>