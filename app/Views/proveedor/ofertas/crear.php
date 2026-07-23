<?= view('plantillas/encabezado', ['titulo' => 'Nueva oferta - BodeTlax']) ?>

<div class="tarjeta" style="max-width:520px; margin:0 auto;">
    <h1>Ofrecer un producto al negocio</h1>

    <form action="/proveedor/ofertas" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Nombre del producto</label>
        <input type="text" name="nombre_producto" value="<?= old('nombre_producto') ?>" required>

        <label>Categoría</label>
        <select name="categoria_id" required>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= esc($cat['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Descripción</label>
        <textarea name="descripcion"><?= old('descripcion') ?></textarea>

        <label>Unidad de medida</label>
        <input type="text" name="unidad_medida" placeholder="pieza, kg, saco, m2..." required>

        <label>Precio que ofreces al negocio (por unidad)</label>
        <input type="number" step="0.01" name="precio_ofertado" required>

        <label>Cantidad disponible</label>
        <input type="number" name="cantidad_ofertada" required>

        <label>Imagen (opcional)</label>
        <input type="file" name="imagen" accept="image/*">

        <button type="submit">Enviar oferta</button>
    </form>

    <p class="texto-suave espacio-arriba"><a href="/proveedor/ofertas">&larr; Ver mis ofertas</a></p>
</div>

<?= view('plantillas/pie') ?>