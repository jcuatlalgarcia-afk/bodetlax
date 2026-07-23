<?= view('plantillas/encabezado', ['titulo' => 'Pedidos entregados - BodeTlax']) ?>

<h1>Pedidos con evidencia de entrega</h1>

<?php if (empty($pedidos)): ?>
    <p class="texto-suave">No hay pedidos pendientes de confirmación.</p>
<?php else: ?>
    <table>
        <tr><th>#</th><th>Cliente</th><th>Repartidor</th><th>Fecha de entrega</th><th>Total</th><th></th></tr>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td>#<?= $pedido['id'] ?></td>
                <td><?= esc($pedido['cliente_nombre']) ?></td>
                <td><?= esc($pedido['repartidor_nombre'] ?? 'N/D') ?></td>
                <td class="texto-suave"><?= esc($pedido['fecha_entrega']) ?></td>
                <td>$<?= number_format($pedido['total'], 2) ?></td>
                <td><a href="/vendedor/pedidos/<?= $pedido['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;">Ver evidencia</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>