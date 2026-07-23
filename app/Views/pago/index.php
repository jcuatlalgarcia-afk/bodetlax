<?= view('plantillas/encabezado', ['titulo' => 'Finalizar compra - BodeTlax']) ?>

<h1>Finalizar compra</h1>

<div class="flex-gap" style="align-items:flex-start;">
    <div class="tarjeta" style="flex:1; min-width:260px;">
        <h3>Resumen del pedido</h3>
        <ul>
            <?php foreach ($items as $item): ?>
                <li><?= esc($item['nombre']) ?> x <?= $item['cantidad'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="tarjeta" style="flex:1; min-width:280px;">
        <form action="/pago/procesar" method="post">
            <?= csrf_field() ?>

            <label>Dirección de envío</label>
            <textarea name="direccion_envio" required></textarea>

            <label>Método de pago</label>
            <select name="metodo_pago" required>
                <option value="efectivo">Efectivo contra entrega</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>

            <button type="submit">Confirmar pedido</button>
        </form>
    </div>
</div>

<?= view('plantillas/pie') ?>