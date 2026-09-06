<?= view('plantillas/encabezado', ['titulo' => 'Registro de vendedor - BodeTlax']) ?>

<div class="tarjeta" style="max-width:460px; margin:0 auto;">
    <h1>Crear cuenta de vendedor (empleado)</h1>
    <div class="alerta" style="background:#fdf3d0; color:#8a6d00; border:1px solid #f1e2a0;">
         Esta cuenta requiere aprobación de un administrador antes de poder iniciar sesión.
    </div>

    <form action="/registro/vendedor" method="post">
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

        <button type="submit">Solicitar cuenta de vendedor</button>
    </form>

    <p class="texto-suave espacio-arriba"><a href="/registro">&larr; Volver a elegir tipo de cuenta</a></p>
</div>

<?= view('plantillas/pie') ?>