<?= view('plantillas/encabezado', ['titulo' => 'Administradores - BodeTlax']) ?>

<div class="flex-gap" style="justify-content:space-between; align-items:center;">
    <h1 style="margin:0;">Administradores del sistema</h1>
    <a href="/admin/administradores/crear" class="boton boton-acento">+ Agregar administrador</a>
</div>

<table class="espacio-arriba">
    <tr><th>Nombre</th><th>Correo</th><th>Estado</th></tr>
    <?php foreach ($administradores as $a): ?>
        <tr>
            <td><?= esc($a['nombre_completo']) ?></td>
            <td><?= esc($a['email']) ?></td>
            <td><span class="insignia insignia-<?= esc($a['estado_cuenta']) ?>"><?= esc(ucfirst($a['estado_cuenta'])) ?></span></td>
        </tr>
    <?php endforeach; ?>
</table>

<?= view('plantillas/pie') ?>