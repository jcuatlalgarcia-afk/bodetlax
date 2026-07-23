<?= view('plantillas/encabezado', ['titulo' => 'Registro de proveedor - BodeTlax']) ?>

<div class="tarjeta" style="max-width:460px; margin:0 auto;">
    <h1>Crear cuenta de proveedor</h1>
    <p class="texto-suave">Podrás enviar ofertas de productos para que el negocio las revise y, si le interesan, las compre para revenderlas.</p>

    <form action="/registro/proveedor" method="post">
        <?= csrf_field() ?>

        <label>Nombre completo o razón social</label>
        <input type="text" name="nombre_completo" value="<?= old('nombre_completo') ?>" required>

        <label>Correo electrónico</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirm" required>

        <button type="submit">Crear cuenta</button>
    </form>

    <p class="texto-suave espacio-arriba"><a href="/registro">&larr; Volver a elegir tipo de cuenta</a></p>
</div>

<?= view('plantillas/pie') ?>