<?= view('plantillas/encabezado', ['titulo' => 'Nuevo producto - BodeTlax']) ?>

<div class="tarjeta" style="max-width:480px; margin:0 auto;">
    <h1>Agregar producto directamente</h1>
    <p class="texto-suave">Publica un producto sin necesidad de una oferta previa de proveedor.</p>

    <form action="/vendedor/productos" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Nombre del producto</label>
        <input type="text" name="nombre" value="<?= old('nombre') ?>" required>

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

        <label>Precio</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Stock inicial</label>
        <input type="number" name="stock" required>

        <label>Imagen principal</label>
        <input type="file" name="imagen_principal" accept="image/*" required>

        <button type="submit">Publicar producto</button>
    </form>
</div>

<?= view('plantillas/pie') ?>