<?= view('plantillas/encabezado', ['titulo' => esc($producto['nombre']) . ' - BodeTlax']) ?>

<p><a href="/catalogo">&larr; Volver al catálogo</a></p>

<div class="tarjeta flex-gap" style="align-items:flex-start;">
    <div style="flex:0 0 320px;">
        <?php if ($producto['imagen_principal']): ?>
            <img src="/<?= esc($producto['imagen_principal']) ?>" style="width:100%; border-radius:8px;">
        <?php else: ?>
            <img src="https://placehold.co/320x220?text=Sin+imagen" style="width:100%; border-radius:8px;">
        <?php endif; ?>

        <?php if (! empty($galeria)): ?>
            <div class="flex-gap espacio-arriba">
                <?php foreach ($galeria as $img): ?>
                    <img src="/<?= esc($img['ruta_imagen']) ?>" width="70" style="border-radius:6px;">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div style="flex:1; min-width:260px;">
        <h1><?= esc($producto['nombre']) ?></h1>
        <p class="precio" style="font-size:24px; color:var(--color-acento); font-weight:700;">
            $<?= esc($producto['precio']) ?> <span class="texto-suave" style="font-size:14px;">/ <?= esc($producto['unidad_medida']) ?></span>
        </p>

        <?php if ($producto['stock'] > 0): ?>
            <p><span class="insignia insignia-aprobado">Disponible</span></p>
        <?php else: ?>
            <p><span class="insignia insignia-rechazado">Agotado</span></p>
        <?php endif; ?>

        <p><?= nl2br(esc($producto['descripcion'])) ?></p>

        <?php if (session()->get('isLoggedIn') && session()->get('rol') === 'cliente'): ?>
            <?php if ($producto['stock'] > 0): ?>
                <form action="/carrito/agregar" method="post" class="form-en-linea">
                    <?= csrf_field() ?>
                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                    <input type="number" name="cantidad" value="1" min="1" style="width:80px;">
                    <button type="submit">Agregar al carrito</button>
                </form>
            <?php else: ?>
                <p class="texto-suave">Este producto no está disponible por el momento.</p>
            <?php endif; ?>
        <?php elseif (! session()->get('isLoggedIn')): ?>
            <p><a href="/login">Inicia sesión</a> como cliente para comprar este producto.</p>
        <?php endif; ?>
    </div>
</div>

<?php if (session()->get('isLoggedIn') && session()->get('rol') === 'cliente'): ?>
    <div class="tarjeta espacio-arriba" style="max-width:500px;">
        <h4>Reportar este producto</h4>
        <form action="/catalogo/producto/<?= $producto['id'] ?>/reportar" method="post">
            <?= csrf_field() ?>
            <textarea name="motivo" placeholder="Describe el motivo del reporte..." required></textarea>
            <button type="submit" class="boton-secundario">Reportar</button>
        </form>
    </div>
<?php endif; ?>

<?= view('plantillas/pie') ?>