<?= view('plantillas/encabezado', ['titulo' => 'Catálogo del negocio - BodeTlax']) ?>

<div class="flex-gap" style="justify-content:space-between; align-items:center;">
    <h1 style="margin:0;">Catálogo del negocio</h1>
    <div class="flex-gap">
        <a href="/vendedor/productos/crear" class="boton boton-acento">+ Agregar producto</a>
        <a href="/vendedor/ofertas-disponibles" class="boton">Ofertas por publicar</a>
    </div>
</div>

<table class="espacio-arriba">
    <tr><th>Nombre</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr>
    <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= esc($producto['nombre']) ?></td>
            <td>$<?= esc($producto['precio']) ?></td>
            <td><?= esc($producto['stock']) ?></td>
            <td><span class="insignia insignia-<?= esc($producto['estado']) ?>"><?= esc(ucfirst($producto['estado'])) ?></span></td>
            <td>
                <a href="/vendedor/productos/editar/<?= $producto['id'] ?>" class="boton boton-secundario" style="padding:5px 10px; font-size:12px;">Editar</a>
                <?php if ($producto['estado'] === 'activo'): ?>
                            <a href="/vendedor/productos/eliminar/<?= $producto['id'] ?>" class="boton boton-peligro" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Dar de baja este producto?')">Dar de baja</a>
                <?php else: ?>
                <a href="/vendedor/productos/reactivar/<?= $producto['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;">Reactivar</a>
                <a href="/vendedor/productos/eliminar-definitivo/<?= $producto['id'] ?>" class="boton boton-peligro" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿ELIMINAR PERMANENTEMENTE este producto? Esta acción no se puede deshacer.')">Eliminar definitivo</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= view('plantillas/pie') ?>