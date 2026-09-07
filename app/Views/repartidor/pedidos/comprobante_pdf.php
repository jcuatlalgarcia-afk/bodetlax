<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
.header { border-bottom: 3px solid #2c3e50; padding-bottom: 10px; margin-bottom: 20px; }
.header h1 { color: #2c3e50; margin: 0; font-size: 20px; }
table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
th { background: #2c3e50; color: white; padding: 6px; text-align:left; font-size: 11px; }
td { padding: 6px; border-bottom: 1px solid #ddd; font-size: 11px; }
.firma-box { margin-top: 80px; }
.linea-firma { border-top: 1px solid #333; width: 300px; margin-top: 60px; padding-top: 6px; text-align: center; }
</style>
</head>
<body>

<div class="header">
    <h1>BodeTlax - Comprobante de entrega</h1>
    <p>Pedido #<?= esc($pedido['id']) ?></p>
</div>

<p><strong>Cliente:</strong> <?= esc($pedido['cliente_nombre']) ?></p>
<p><strong>Teléfono:</strong> <?= esc($pedido['cliente_telefono'] ?? 'No registrado') ?></p>
<p><strong>Dirección de entrega:</strong> <?= esc($pedido['direccion_envio']) ?></p>
<p><strong>Fecha:</strong> <?= date('d/m/Y H:i') ?></p>

<table>
    <tr><th>Producto</th><th>Cantidad</th></tr>
    <?php foreach ($items as $item): ?>
        <tr><td><?= esc($item['nombre_producto']) ?></td><td><?= esc($item['cantidad']) ?></td></tr>
    <?php endforeach; ?>
</table>

<p><strong>Total pagado:</strong> $<?= number_format($pedido['total'], 2) ?></p>

<p style="margin-top:30px;">Yo, el cliente arriba mencionado, confirmo haber recibido el pedido completo y a mi entera satisfacción.</p>

<div class="firma-box">
    <div class="linea-firma">
        Firma del cliente<br>
        <?= esc($pedido['cliente_nombre']) ?>
    </div>
</div>

</body>
</html>