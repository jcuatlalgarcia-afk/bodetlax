<?= view('plantillas/encabezado', ['titulo' => 'Publicar producto - BodeTlax']) ?>

<div class="tarjeta" style="max-width:520px; margin:0 auto;">
    <h1>Publicar producto desde oferta</h1>
    <p class="texto-suave">
        Basado en la oferta de <strong><?= esc($oferta['proveedor_nombre']) ?></strong> —
        precio ofertado: $<?= esc($oferta['precio_ofertado']) ?> por <?= esc($oferta['unidad_medida']) ?>.
    </p>

    <form action="/vendedor/productos" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="oferta_origen_id" value="<?= $oferta['id'] ?>">

        <label>Nombre del producto</label>
        <input type="text" name="nombre" value="<?= esc($oferta['nombre_producto']) ?>" required>

        <label>Categoría</label>
        <select name="categoria_id" required>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $oferta['categoria_id']) ? 'selected' : '' ?>>
                    <?= esc($cat['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Descripción</label>
        <textarea name="descripcion"><?= esc($oferta['descripcion']) ?></textarea>

        <label>Unidad de medida</label>
        <input type="text" name="unidad_medida" value="<?= esc($oferta['unidad_medida']) ?>" required>

        <label>Precio de reventa al cliente</label>
        <input type="number" step="0.01" name="precio" placeholder="Define tu precio de venta" required>
        <small class="texto-suave">Precio de costo (oferta del proveedor): $<?= esc($oferta['precio_ofertado']) ?></small>

        <label>Stock a publicar</label>
        <input type="number" name="stock" value="<?= esc($oferta['cantidad_ofertada']) ?>" required>

        <label>Imagen principal (opcional, si no subes una se usará la de la oferta)</label>
        <input type="file" name="imagen_principal" accept="image/*">

        <button type="submit">Publicar en el catálogo</button>
    </form>
</div>

<?= view('plantillas/pie') ?>