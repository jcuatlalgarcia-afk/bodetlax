<?= view('plantillas/encabezado', ['titulo' => 'Catálogo - BodeTlax']) ?>

<h1>Catálogo de materiales</h1>

<form action="/catalogo" method="get" class="tarjeta flex-gap" style="max-width:none; flex-direction:row; align-items:flex-end; margin-bottom:24px;">
    <div style="flex:1; min-width:160px;">
        <label>Buscar</label>
        <input type="text" name="palabra" placeholder="Nombre del producto..." value="<?= esc($filtros['palabra'] ?? '') ?>">
    </div>
    <div>
        <label>Categoría</label>
        <select name="categoria_id">
            <option value="">Todas</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($filtros['categoria_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= esc($cat['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label>Precio mín.</label>
        <input type="number" name="precio_min" value="<?= esc($filtros['precio_min'] ?? '') ?>" style="width:100px;">
    </div>
    <div>
        <label>Precio máx.</label>
        <input type="number" name="precio_max" value="<?= esc($filtros['precio_max'] ?? '') ?>" style="width:100px;">
    </div>
    <div>
        <label>Disponibilidad</label>
        <select name="disponibilidad">
            <option value="">Cualquiera</option>
            <option value="disponible" <?= ($filtros['disponibilidad'] === 'disponible') ? 'selected' : '' ?>>Solo disponibles</option>
        </select>
    </div>
    <button type="submit">Filtrar</button>
</form>

<?php if (empty($productos)): ?>
    <p class="texto-suave">No se encontraron productos con esos criterios.</p>
<?php endif; ?>

<div class="grid-productos">
    <?php foreach ($productos as $producto): ?>
        <div class="producto-tarjeta">
            <?php if ($producto['imagen_principal']): ?>
                <img src="/<?= esc($producto['imagen_principal']) ?>">
            <?php else: ?>
                <img src="https://placehold.co/220x150?text=Sin+imagen">
            <?php endif; ?>
            <div class="contenido">
                <h3><?= esc($producto['nombre']) ?></h3>
                <p class="precio">$<?= esc($producto['precio']) ?> <span class="texto-suave">/ <?= esc($producto['unidad_medida']) ?></span></p>
                <?php if ($producto['stock'] > 0): ?>
                    <p class="insignia insignia-aprobado">Stock: <?= esc($producto['stock']) ?></p>
                <?php else: ?>
                    <p class="insignia insignia-rechazado">Stock: <?= esc($producto['stock']) ?></p>
                <?php endif; ?>
                <a href="/catalogo/producto/<?= $producto['id'] ?>" class="boton" style="margin-top:auto; text-align:center;">Ver detalle</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="espacio-arriba"><?= $pager->links() ?></div>

<?= view('plantillas/pie') ?>