<?= view('plantillas/encabezado', ['titulo' => ucfirst($rol) . 'es activos - Admin']) ?>

<h1><?= esc(ucfirst($rol)) ?>es del negocio</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a> · <a href="/admin/personal/<?= esc($rol) ?>/pendientes">Ver solicitudes pendientes</a></p>

<table class="espacio-arriba">
    <tr><th>Nombre</th><th>Correo</th><th>Estado</th><th>Acciones</th></tr>
    <?php foreach ($personal as $p): ?>
        <tr>
            <td><?= esc($p['nombre_completo']) ?></td>
            <td><?= esc($p['email']) ?></td>
            <td><span class="insignia insignia-<?= esc($p['estado_cuenta']) ?>"><?= esc(ucfirst($p['estado_cuenta'])) ?></span></td>
            <td>
                <?php if ($p['estado_cuenta'] === 'activo'): ?>
                    <a href="/admin/personal/<?= esc($rol) ?>/desactivar/<?= $p['id'] ?>" class="boton boton-secundario" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Desactivar esta cuenta?')">Desactivar</a>
                <?php else: ?>
                    <a href="/admin/personal/<?= esc($rol) ?>/reactivar/<?= $p['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;">Reactivar</a>
                <?php endif; ?>
                <a href="/admin/personal/<?= esc($rol) ?>/eliminar/<?= $p['id'] ?>" class="boton boton-peligro" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿ELIMINAR permanentemente esta cuenta?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= view('plantillas/pie') ?>