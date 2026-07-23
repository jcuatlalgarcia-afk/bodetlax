<?= view('plantillas/encabezado', ['titulo' => 'Productos por categoría - Admin']) ?>

<h1>Productos por categoría</h1>

<form action="/admin/productos-por-categoria" method="get" style="max-width:300px;">
    <label>Selecciona una categoría</label>
    <select name="categoria_id" onchange="this.form.submit()">
        <option value="">-- Elegir --</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($categoriaActual == $cat['id']) ? 'selected' : '' ?>>
                <?= esc($cat['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($categoriaActual): ?>
    <?php if (empty($productos)): ?>
        <p class="texto-suave espacio-arriba">No hay productos en esta categoría.</p>
    <?php else: ?>
        <table class="espacio-arriba">
            <tr><th>Nombre</th><th>Precio</th><th>Stock</th><th>Estado</th></tr>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= esc($p['nombre']) ?></td>
                    <td>$<?= esc($p['precio']) ?></td>
                    <td><?= esc($p['stock']) ?></td>
                    <td><span class="insignia insignia-<?= esc($p['estado']) ?>"><?= esc(ucfirst($p['estado'])) ?></span></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

<?= view('plantillas/pie') ?>