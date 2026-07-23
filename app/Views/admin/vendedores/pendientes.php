<?= view('plantillas/encabezado', ['titulo' => 'Vendedores pendientes - Admin']) ?>

<h1>Solicitudes de vendedor pendientes</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a> · <a href="/admin/vendedores">Ver vendedores activos</a></p>

<?php if (empty($vendedores)): ?>
    <p class="texto-suave espacio-arriba">No hay solicitudes pendientes.</p>
<?php else: ?>
    <table class="espacio-arriba">
        <tr><th>Nombre</th><th>Correo</th><th>Fecha de solicitud</th><th>Acciones</th></tr>
        <?php foreach ($vendedores as $v): ?>
            <tr>
                <td><?= esc($v['nombre_completo']) ?></td>
                <td><?= esc($v['email']) ?></td>
                <td class="texto-suave"><?= esc($v['created_at']) ?></td>
                <td>
                    <a href="/admin/vendedores/aprobar/<?= $v['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Aprobar a este vendedor?')">✅ Aprobar</a>
                    <a href="/admin/vendedores/rechazar/<?= $v['id'] ?>" class="boton boton-peligro" style="padding:5px 10px; font-size:12px;" onclick="return confirm('¿Rechazar esta solicitud?')">❌ Rechazar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>