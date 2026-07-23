<?= view('plantillas/encabezado', ['titulo' => 'Ofertas pendientes - Admin']) ?>

<h1>Ofertas de proveedores pendientes de revisión</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a> · <a href="/admin/ofertas/aceptadas">Ver ofertas aceptadas</a></p>

<?php if (empty($ofertas)): ?>
    <p class="texto-suave espacio-arriba">No hay ofertas pendientes.</p>
<?php else: ?>
    <table class="espacio-arriba">
        <tr><th>Imagen</th><th>Producto</th><th>Proveedor</th><th>Categoría</th><th>Precio</th><th>Cantidad</th><th>Acciones</th></tr>
        <?php foreach ($ofertas as $oferta): ?>
            <tr>
                <td><?php if ($oferta['imagen']): ?><img src="/<?= esc($oferta['imagen']) ?>" width="55" style="border-radius:6px;"><?php endif; ?></td>
                <td><?= esc($oferta['nombre_producto']) ?></td>
                <td><?= esc($oferta['proveedor_nombre']) ?></td>
                <td><?= esc($oferta['categoria_nombre']) ?></td>
                <td>$<?= esc($oferta['precio_ofertado']) ?></td>
                <td><?= esc($oferta['cantidad_ofertada']) ?></td>
                <td>
                    <a href="/admin/ofertas/aceptar/<?= $oferta['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Aceptar esta oferta?')">✅ Aceptar</a>
                    <a href="/admin/ofertas/rechazar/<?= $oferta['id'] ?>" class="boton boton-peligro" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Rechazar esta oferta?')">❌ Rechazar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>