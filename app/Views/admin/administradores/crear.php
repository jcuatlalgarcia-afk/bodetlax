<?= view('plantillas/encabezado', ['titulo' => 'Nuevo administrador - BodeTlax']) ?>

<div class="tarjeta" style="max-width:420px; margin:0 auto;">
    <h1>Agregar administrador</h1>

    <form action="/admin/administradores" method="post">
        <?= csrf_field() ?>

        <label>Nombre completo</label>
        <input type="text" name="nombre_completo" value="<?= old('nombre_completo') ?>" required>

        <label>Correo electrónico</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirm" required>

        <button type="submit">Crear administrador</button>
    </form>

    <p class="texto-suave espacio-arriba"><a href="/admin/administradores">&larr; Volver</a></p>
</div>

<?= view('plantillas/pie') ?>