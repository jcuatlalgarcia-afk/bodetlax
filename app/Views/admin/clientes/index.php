<?= view('plantillas/encabezado', ['titulo' => 'Clientes registrados - BodeTlax']) ?>

<h1>Clientes registrados</h1>

<table class="espacio-arriba">
    <tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Dirección</th><th>Estado</th><th>Registrado</th></tr>
    <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?= esc($c['nombre_completo']) ?></td>
            <td><?= esc($c['email']) ?></td>
            <td><?= esc($c['telefono'] ?? '-') ?></td>
            <td><?= esc($c['direccion'] ?? '-') ?></td>
            <td><span class="insignia insignia-<?= esc($c['estado_cuenta']) ?>"><?= esc(ucfirst($c['estado_cuenta'])) ?></span></td>
            <td class="texto-suave"><?= esc($c['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?= view('plantillas/pie') ?>