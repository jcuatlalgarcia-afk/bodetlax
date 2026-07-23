<?= view('plantillas/encabezado', ['titulo' => 'Ofertas disponibles - BodeTlax']) ?>

<h1>Ofertas aceptadas, listas para publicar</h1>
<p><a href="/vendedor/productos">&larr; Ver catálogo</a></p>

<?php if (empty($ofertas)): ?>
    <p class="texto-suave espacio-arriba">No hay ofertas aceptadas pendientes de publicar.</p>
<?php else: ?>
    <table class="espacio-arriba">
        <tr><th>Imagen</th><th>Producto</th><th>Proveedor</th><th>Categoría</th><th>Precio ofertado</th><th>Cantidad</th><th>Acciones</th></tr>
        <?php foreach ($ofertas as $oferta): ?>
            <tr>
                <td><?php if ($oferta['imagen']): ?><img src="/<?= esc($oferta['imagen']) ?>" width="55" style="border-radius:6px;"><?php endif; ?></td>
                <td><?= esc($oferta['nombre_producto']) ?></td>
                <td><?= esc($oferta['proveedor_nombre']) ?></td>
                <td><?= esc($oferta['categoria_nombre']) ?></td>
                <td>$<?= esc($oferta['precio_ofertado']) ?></td>
                <td><?= esc($oferta['cantidad_ofertada']) ?></td>
                <td><a href="/vendedor/productos/publicar-desde-oferta/<?= $oferta['id'] ?>" class="boton boton-acento" style="padding:5px 10px; font-size:12px;">Publicar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>