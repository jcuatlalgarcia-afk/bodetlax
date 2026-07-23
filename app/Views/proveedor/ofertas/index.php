<?= view('plantillas/encabezado', ['titulo' => 'Mis ofertas - BodeTlax']) ?>

<div class="flex-gap" style="justify-content:space-between; align-items:center;">
    <h1 style="margin:0;">Mis ofertas enviadas</h1>
    <a href="/proveedor/ofertas/crear" class="boton boton-acento">+ Nueva oferta</a>
</div>

<?php if (empty($ofertas)): ?>
    <p class="texto-suave espacio-arriba">Aún no has enviado ninguna oferta.</p>
<?php else: ?>
    <table class="espacio-arriba">
        <tr><th>Producto</th><th>Precio ofertado</th><th>Cantidad</th><th>Estado</th><th>Fecha</th></tr>
        <?php foreach ($ofertas as $oferta): ?>
            <tr>
                <td><?= esc($oferta['nombre_producto']) ?></td>
                <td>$<?= esc($oferta['precio_ofertado']) ?></td>
                <td><?= esc($oferta['cantidad_ofertada']) ?></td>
                <td><span class="insignia insignia-<?= esc($oferta['estado']) ?>"><?= esc(ucfirst($oferta['estado'])) ?></span></td>
                <td class="texto-suave"><?= esc($oferta['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>