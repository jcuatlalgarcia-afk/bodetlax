<?= view('plantillas/encabezado', ['titulo' => 'Pedido #' . $pedido['id'] . ' - BodeTlax']) ?>

<p><a href="/vendedor/pedidos">&larr; Volver a la lista</a></p>

<div class="tarjeta">
    <h1>Pedido #<?= $pedido['id'] ?></h1>
    <p><strong>Cliente:</strong> <?= esc($pedido['cliente_nombre']) ?></p>
    <p><strong>Entregado por:</strong> <?= esc($pedido['repartidor_nombre'] ?? 'N/D') ?></p>
    <p><strong>Fecha de entrega:</strong> <?= esc($pedido['fecha_entrega']) ?></p>
    <p><strong>Total:</strong> $<?= number_format($pedido['total'], 2) ?></p>

    <?php if ($pedido['evidencia_entrega']): ?>
        <h4>Evidencia de entrega</h4>
        <img src="/<?= esc($pedido['evidencia_entrega']) ?>" style="max-width:320px; border-radius:8px;">
    <?php endif; ?>
</div>

<h3 class="espacio-arriba">Productos</h3>
<table>
    <tr><th>Producto</th><th>Cantidad</th><th>Subtotal</th></tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= esc($item['nombre_producto']) ?></td>
            <td><?= esc($item['cantidad']) ?></td>
            <td>$<?= number_format($item['total_linea'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if ($pedido['estado'] === 'pagado'): ?>
    <form action="/vendedor/pedidos/<?= $pedido['id'] ?>/completo" method="post" class="espacio-arriba">
        <?= csrf_field() ?>
        <button type="submit" class="boton-acento" onclick="return confirm('¿Confirmar este pedido como completo?')">Marcar como completo</button>
    </form>
<?php else: ?>
    <p class="texto-suave espacio-arriba">Estado actual: <span class="insignia insignia-<?= esc($pedido['estado']) ?>"><?= esc(ucfirst($pedido['estado'])) ?></span></p>
<?php endif; ?>

<?= view('plantillas/pie') ?>