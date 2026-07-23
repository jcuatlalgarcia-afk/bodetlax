<?= view('plantillas/encabezado', ['titulo' => 'Iniciar sesión - BodeTlax']) ?>

<div class="tarjeta" style="max-width:400px; margin:0 auto;">
    <h1>Iniciar sesión</h1>

    <form action="/login" method="post">
        <?= csrf_field() ?>

        <label>Correo electrónico</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>

    <p class="espacio-arriba texto-suave">¿No tienes cuenta? <a href="/registro">Regístrate</a></p>
</div>

<?= view('plantillas/pie') ?>