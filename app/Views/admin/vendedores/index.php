<?= view('plantillas/encabezado', ['titulo' => 'Vendedores activos - Admin']) ?>

<h1>Vendedores del negocio</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a> · <a href="/admin/vendedores/pendientes">Ver solicitudes pendientes</a></p>

<table class="espacio-arriba">
    <tr><th>Nombre</th><th>Correo</th><th>Estado</th><th>Acciones</th></tr>
    <?php foreach ($vendedores as $v): ?>
        <tr>
            <td><?= esc($v['nombre_completo']) ?></td>
            <td><?= esc($v['email']) ?></td>
            <td><span class="insignia insignia-<?= esc($v['estado_cuenta']) ?>"><?= esc(ucfirst($v['estado_cuenta'])) ?></span></td>
            <td>
                <?php if ($v['estado_cuenta'] === 'activo'): ?>
                    <a href="/admin/vendedores/desactivar/<?= $v['id'] ?>" class="boton boton-secundario" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Desactivar a este vendedor?')">Desactivar</a>
                <?php else: ?>
                    <a href="/admin/vendedores/reactivar/<?= $v['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;">Reactivar</a>
                <?php endif; ?>
                <a href="/admin/vendedores/eliminar/<?= $v['id'] ?>" class="boton boton-peligro" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿ELIMINAR permanentemente a este vendedor? Esta acción no se puede deshacer.')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= view('plantillas/pie') ?>