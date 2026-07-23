<?= view('plantillas/encabezado', ['titulo' => 'Categorías - Admin']) ?>

<h1>Gestión de categorías</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a></p>

<div class="tarjeta" style="max-width:400px;">
    <form action="/admin/categorias" method="post" class="form-en-linea">
        <?= csrf_field() ?>
        <input type="text" name="nombre" placeholder="Nueva categoría" required style="flex:1;">
        <button type="submit">Agregar</button>
    </form>
</div>

<table class="espacio-arriba">
    <tr><th>Nombre</th><th>Acciones</th></tr>
    <?php foreach ($categorias as $cat): ?>
        <tr>
            <td>
                <form action="/admin/categorias/actualizar/<?= $cat['id'] ?>" method="post" class="form-en-linea" style="gap:6px;">
                    <?= csrf_field() ?>
                    <input type="text" name="nombre" value="<?= esc($cat['nombre']) ?>">
                    <button type="submit" class="boton-secundario" style="padding:5px 10px; font-size:12px;">Guardar</button>
                </form>
            </td>
            <td><a href="/admin/categorias/eliminar/<?= $cat['id'] ?>" style="color:var(--color-error);" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?= view('plantillas/pie') ?>