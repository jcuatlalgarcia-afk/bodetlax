<?= view('plantillas/encabezado', ['titulo' => 'Pedido #' . $pedido['id'] . ' - BodeTlax']) ?>

<p><a href="/repartidor/pedidos">&larr; Volver a la lista</a></p>
<p><a href="/repartidor/pedidos/<?= $pedido['id'] ?>/comprobante" class="boton boton-acento"> Descargar comprobante para firma</a></p>

<div class="tarjeta">
    <h1>Pedido #<?= $pedido['id'] ?></h1>
    <p><strong>Cliente:</strong> <?= esc($pedido['cliente_nombre']) ?></p>
    <?php if (! empty($pedido['cliente_telefono'])): ?>
        <p><strong>Teléfono:</strong> <?= esc($pedido['cliente_telefono']) ?></p>
    <?php endif; ?>
    <p><strong>Dirección de entrega:</strong> <?= esc($pedido['direccion_envio']) ?></p>
    <p><strong>Monto a cobrar:</strong> $<?= number_format($pedido['total'], 2) ?></p>
    <p><strong>Método de pago:</strong> <?= esc(ucfirst($pedido['metodo_pago'])) ?></p>
</div>

<h3 class="espacio-arriba">Productos a entregar</h3>
<table>
    <tr><th>Producto</th><th>Cantidad</th></tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= esc($item['nombre_producto']) ?></td>
            <td><?= esc($item['cantidad']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (in_array($pedido['estado'], ['pendiente', 'en_camino'])): ?>
    <div class="tarjeta espacio-arriba" style="max-width:420px;">
        <h3>Confirmar entrega</h3>
        <form action="/repartidor/pedidos/<?= $pedido['id'] ?>/pagado" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label>Foto de evidencia de entrega</label>
            <input type="file" name="evidencia" accept="image/*" required>
            <button type="submit" class="boton-acento">Marcar como pagado y entregado</button>
        </form>
    </div>
<?php else: ?>
    <p class="texto-suave espacio-arriba">Este pedido ya fue marcado como <?= esc($pedido['estado']) ?>.</p>
<?php endif; ?>

<?= view('plantillas/pie') ?>