<?= view('plantillas/encabezado', ['titulo' => 'Reportes - Admin']) ?>

<h1>Reportes de productos</h1>
<p><a href="/admin/dashboard">&larr; Volver al dashboard</a></p>

<?php if (empty($reportes)): ?>
    <p class="texto-suave espacio-arriba">No hay reportes registrados.</p>
<?php else: ?>
    <table class="espacio-arriba">
        <tr><th>Producto</th><th>Reportado por</th><th>Motivo</th><th>Estado</th><th>Fecha</th><th>Acciones</th></tr>
        <?php foreach ($reportes as $reporte): ?>
            <tr>
                <td><a href="/catalogo/producto/<?= $reporte['producto_id'] ?>" target="_blank"><?= esc($reporte['producto_nombre']) ?></a></td>
                <td><?= esc($reporte['reportante_nombre']) ?></td>
                <td><?= esc($reporte['motivo']) ?></td>
                <td><span class="insignia insignia-<?= esc($reporte['estado']) ?>"><?= esc(ucfirst($reporte['estado'])) ?></span></td>
                <td class="texto-suave"><?= esc($reporte['created_at']) ?></td>
                <td>
                    <?php if ($reporte['estado'] === 'pendiente'): ?>
                        <a href="/admin/reportes/revisar/<?= $reporte['id'] ?>" class="boton" style="padding:5px 10px; font-size:12px;">Marcar revisado</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('plantillas/pie') ?>