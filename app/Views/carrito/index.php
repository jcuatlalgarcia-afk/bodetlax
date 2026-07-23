<?= view('plantillas/encabezado', ['titulo' => 'Mi carrito - BodeTlax']) ?>

<h1>Mi carrito</h1>

<?php if (empty($items)): ?>
    <p class="texto-suave">Tu carrito está vacío. <a href="/catalogo">Ver catálogo</a></p>
<?php else: ?>
    <table>
        <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th></th></tr>
        <?php foreach ($items as $item): ?>
            <?php $precio = $item['precio_descuento'] ?? $item['precio']; ?>
            <tr>
                <td><?= esc($item['nombre']) ?></td>
                <td>$<?= esc($precio) ?></td>
                <td>
                    <form action="/carrito/actualizar/<?= $item['id'] ?>" method="post" class="form-en-linea" style="gap:6px;">
                        <?= csrf_field() ?>
                        <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" min="1" max="<?= $item['stock'] ?>" style="width:60px;">
                        <button type="submit" class="boton-secundario" style="padding:5px 10px; font-size:12px;">Actualizar</button>
                    </form>
                </td>
                <td>$<?= number_format($precio * $item['cantidad'], 2) ?></td>
                <td><a href="/carrito/eliminar/<?= $item['id'] ?>" style="color:var(--color-error);" onclick="return confirm('¿Quitar este producto?')">Quitar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="tarjeta espacio-arriba" style="max-width:340px; margin-left:auto;">
        <p>Subtotal: <strong>$<?= number_format($subtotal, 2) ?></strong></p>
        <p>IVA (16%): <strong>$<?= number_format($impuesto, 2) ?></strong></p>
        <p>Envío: <strong>$<?= number_format($costoEnvio, 2) ?></strong></p>
        <h3>Total: $<?= number_format($total, 2) ?></h3>
        <a href="/pago" class="boton boton-acento" style="display:block; text-align:center;">Proceder al pago</a>
    </div>
<?php endif; ?>

<?= view('plantillas/pie') ?>