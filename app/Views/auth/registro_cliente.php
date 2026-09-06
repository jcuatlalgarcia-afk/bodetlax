<?= view('plantillas/encabezado', ['titulo' => 'Registro de cliente - BodeTlax']) ?>

<div class="tarjeta" style="max-width:420px; margin:0 auto;">
    <h1>Crear cuenta de cliente</h1>

    <form action="/registro/cliente" method="post">
        <?= csrf_field() ?>

        <label>Nombre completo</label>
        <input type="text" name="nombre_completo" value="<?= old('nombre_completo') ?>" required>

        <label>Correo electrónico</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>

        <label>Teléfono</label>
        <input type="tel" name="telefono" value="<?= old('telefono') ?>" placeholder="10 dígitos" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirm" required>

        <button type="submit">Crear cuenta</button>
    </form>

    <p class="texto-suave espacio-arriba"><a href="/registro">&larr; Volver a elegir tipo de cuenta</a></p>
</div>

<?= view('plantillas/pie') ?>