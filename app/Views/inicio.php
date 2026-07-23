<?= view('plantillas/encabezado', ['titulo' => 'BodeTlax - Materiales de construcción']) ?>

<div class="landing-hero" style="margin: -28px -20px 30px; border-radius: 0 0 var(--borde-radio) var(--borde-radio);">
    <h1>Bienvenido a BodeTlax</h1>
    <p>Materiales de construcción de calidad, directo a tu obra.</p>
    <div class="botones">
        <a href="/login" class="boton boton-acento">Iniciar sesión</a>
        <a href="/registro" class="boton boton-secundario">Registrarse</a>
    </div>
</div>

<h2 style="text-align:center;">¿Qué tipo de cuenta necesitas?</h2>
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
        <p>Cuenta de empleado, requiere aprobación del administrador.</p>
        <a href="/registro/vendedor" class="boton">Registrarme</a>
    </div>
</div>

<p style="text-align:center; margin-top:30px;">
    <a href="/catalogo">Ver catálogo sin iniciar sesión →</a>
</p>

<?= view('plantillas/pie') ?>