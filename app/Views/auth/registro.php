<?= view('plantillas/encabezado', ['titulo' => 'Crear cuenta - BodeTlax']) ?>

<h1 style="text-align:center;">¿Qué tipo de cuenta quieres crear?</h1>

<div class="tarjetas-tipo-cuenta">
    <div class="tipo-cuenta">
        <h3> Cliente</h3>
        <p>Compra materiales de construcción en nuestro catálogo.</p>
        <a href="/registro/cliente" class="boton">Registrarme</a>
    </div>

    <div class="tipo-cuenta">
        <h3> Proveedor</h3>
        <p>Ofrece tus productos para que el negocio los revenda.</p>
        <a href="/registro/proveedor" class="boton">Registrarme</a>
    </div>

    <div class="tipo-cuenta">
        <h3> Trabajo aquí</h3>
        <p>Cuenta de empleado (vendedor), requiere aprobación del administrador.</p>
        <a href="/registro/vendedor" class="boton">Registrarme</a>
    </div>

    <div class="tipo-cuenta">
        <h3> Repartidor</h3>
        <p>Entrega los pedidos del negocio, requiere aprobación del administrador.</p>
        <a href="/registro/repartidor" class="boton">Registrarme</a>
    </div>
</div>

<p style="text-align:center; margin-top:24px;" class="texto-suave">
    ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
</p>

<?= view('plantillas/pie') ?>