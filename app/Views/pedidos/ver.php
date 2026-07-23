<?= view('plantillas/encabezado', ['titulo' => 'Pedido #' . $pedido['id'] . ' - BodeTlax']) ?>

<div class="flex-gap" style="justify-content:space-between; align-items:center;">
    <h1 style="margin:0;">Pedido #<?= $pedido['id'] ?></h1>
    <a href="/pedidos/<?= $pedido['id'] ?>/factura" class="boton boton-acento">📄 Descargar factura en PDF</a>
</div>

<div class="tarjeta espacio-arriba">
    <h3>Seguimiento</h3>
    <ul>
        <?php foreach ($historial as $h): ?>
            <li><span class="insignia insignia-<?= esc($h['estado']) ?>"><?= esc(ucfirst($h['estado'])) ?></span> — <span class="texto-suave"><?= esc($h['created_at']) ?></span></li>
        <?php endforeach; ?>
    </ul>
</div>

<h3 class="espacio-arriba">Productos</h3>
<table>
    <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th></tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= esc($item['nombre_producto']) ?></td>
            <td>$<?= esc($item['precio_unitario']) ?></td>
            <td><?= esc($item['cantidad']) ?></td>
            <td>$<?= number_format($item['total_linea'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="tarjeta espacio-arriba" style="max-width:340px; margin-left:auto;">
    <p>Subtotal: <strong>$<?= number_format($pedido['subtotal'], 2) ?></strong></p>
    <p>IVA: <strong>$<?= number_format($pedido['impuesto'], 2) ?></strong></p>
    <p>Envío: <strong>$<?= number_format($pedido['costo_envio'], 2) ?></strong></p>
    <h3>Total: $<?= number_format($pedido['total'], 2) ?></h3>
</div>

<p class="espacio-arriba"><strong>Dirección de envío:</strong> <?= esc($pedido['direccion_envio']) ?></p>
<p><strong>Método de pago:</strong> <?= esc(ucfirst($pedido['metodo_pago'])) ?></p>

<?= view('plantillas/pie') ?>