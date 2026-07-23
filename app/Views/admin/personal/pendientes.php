<?= view('plantillas/encabezado', ['titulo' => 'Solicitudes pendientes - Admin']) ?>

<h1>Solicitudes de <?= esc($rol) ?> pendientes</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a> · <a href="/admin/personal/<?= esc($rol) ?>">Ver <?= esc($rol) ?>es activos</a></p>

<?php if (empty($personal)): ?>
    <p class="texto-suave espacio-arriba">No hay solicitudes pendientes.</p>
<?php else: ?>
    <table class="espacio-arriba">
        <tr><th>Nombre</th><th>Correo</th><th>Fecha de solicitud</th><th>Acciones</th></tr>
        <?php foreach ($personal as $p): ?>
            <tr>
                <td><?= esc($p['nombre_completo']) ?></td>
                <td><?= esc($p['email']) ?></td>
                <td class="texto-suave"><?= esc($p['created_at']) ?></td>
                <td>
                    <a href="/admin/personal/<?= esc($rol) ?>/aprobar/<?= $p['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Aprobar esta cuenta?')">✅ Aprobar</a>
                    <a href="/admin/personal/<?= esc($rol) ?>/rechazar/<?= $p['id'] ?>" class="boton boton-peligro" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Rechazar esta solicitud?')">❌ Rechazar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>