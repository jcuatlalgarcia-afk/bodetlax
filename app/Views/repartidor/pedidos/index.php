<?= view('plantillas/encabezado', ['titulo' => 'Pedidos por entregar - BodeTlax']) ?>

<h1>Pedidos por entregar</h1>

<?php if (empty($pedidos)): ?>
    <p class="texto-suave">No hay pedidos pendientes de entrega por el momento.</p>
<?php else: ?>
    <table>
        <tr><th>#</th><th>Cliente</th><th>Dirección</th><th>Monto a pagar</th><th>Estado</th><th></th></tr>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td>#<?= $pedido['id'] ?></td>
                <td><?= esc($pedido['cliente_nombre']) ?></td>
                <td><?= esc($pedido['direccion_envio']) ?></td>
                <td>$<?= number_format($pedido['total'], 2) ?></td>
                <td><span class="insignia insignia-<?= esc($pedido['estado']) ?>"><?= esc(ucfirst($pedido['estado'])) ?></span></td>
                <td><a href="/repartidor/pedidos/<?= $pedido['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;">Ver detalle</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>