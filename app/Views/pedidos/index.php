<?= view('plantillas/encabezado', ['titulo' => 'Mis pedidos - BodeTlax']) ?>

<h1>Mis pedidos</h1>

<?php if (empty($pedidos)): ?>
    <p class="texto-suave">Todavía no tienes pedidos. <a href="/catalogo">Ir al catálogo</a></p>
<?php else: ?>
    <table>
        <tr><th>#</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th></tr>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td>#<?= $pedido['id'] ?></td>
                <td class="texto-suave"><?= esc($pedido['created_at']) ?></td>
                <td>$<?= number_format($pedido['total'], 2) ?></td>
                <td><span class="insignia insignia-<?= esc($pedido['estado']) ?>"><?= esc(ucfirst($pedido['estado'])) ?></span></td>
                <td><a href="/pedidos/<?= $pedido['id'] ?>" class="boton boton-secundario" style="padding:5px 10px; font-size:12px;">Ver detalle</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>