<?= view('plantillas/encabezado', ['titulo' => 'Editar producto - BodeTlax']) ?>

<div class="tarjeta" style="max-width:480px; margin:0 auto;">
    <h1>Editar producto</h1>

    <form action="/vendedor/productos/actualizar/<?= $producto['id'] ?>" method="post">
        <?= csrf_field() ?>

        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= esc($producto['nombre']) ?>" required>

        <label>Categoría</label>
        <select name="categoria_id" required>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $producto['categoria_id']) ? 'selected' : '' ?>>
                    <?= esc($cat['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Descripción</label>
        <textarea name="descripcion"><?= esc($producto['descripcion']) ?></textarea>

        <label>Unidad de medida</label>
        <input type="text" name="unidad_medida" value="<?= esc($producto['unidad_medida']) ?>" required>

        <label>Precio</label>
        <input type="number" step="0.01" name="precio" value="<?= esc($producto['precio']) ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?= esc($producto['stock']) ?>" required>

        <button type="submit">Guardar cambios</button>
    </form>
</div>

<?= view('plantillas/pie') ?>