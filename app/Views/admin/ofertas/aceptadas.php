<?= view('plantillas/encabezado', ['titulo' => 'Ofertas aceptadas - Admin']) ?>

<h1>Ofertas aceptadas</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a> · <a href="/admin/ofertas">Ver pendientes de revisión</a></p>

<?php if (empty($ofertas)): ?>
    <p class="texto-suave espacio-arriba">No hay ofertas aceptadas todavía.</p>
<?php else: ?>
    <table class="espacio-arriba">
        <tr><th>Producto</th><th>Proveedor</th><th>Cantidad</th><th>Precio</th><th>Estado</th><th>Acciones</th></tr>
        <?php foreach ($ofertas as $oferta): ?>
            <tr>
                <td><?= esc($oferta['nombre_producto']) ?></td>
                <td><?= esc($oferta['proveedor_nombre']) ?></td>
                <td><?= esc($oferta['cantidad_ofertada']) ?></td>
                <td>$<?= esc($oferta['precio_ofertado']) ?></td>
                <td><span class="insignia insignia-<?= esc($oferta['estado']) ?>"><?= esc(ucfirst($oferta['estado'])) ?></span></td>
                <td><a href="/admin/ofertas/orden-compra/<?= $oferta['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;">📄 Orden de compra</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>