<?= view('plantillas/encabezado', ['titulo' => 'Panel de administración - BodeTlax']) ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1>Panel de administración</h1>

<div class="tarjetas-fila">
    <div class="stat-tarjeta">
        <h4>Clientes</h4>
        <p class="numero"><?= esc($totalClientes) ?></p>
    </div>
    <div class="stat-tarjeta">
        <h4>Proveedores</h4>
        <p class="numero"><?= esc($totalProveedores) ?></p>
    </div>
    <div class="stat-tarjeta">
        <h4>Productos activos</h4>
        <p class="numero"><?= esc($totalProductosActivos) ?></p>
    </div>
    <div class="stat-tarjeta">
        <h4>Pedidos totales</h4>
        <p class="numero"><?= esc($totalPedidos) ?></p>
    </div>
    <div class="stat-tarjeta alerta">
        <h4>Vendedores pendientes</h4>
        <p class="numero"><?= esc($vendedoresPendientes) ?></p>
        <a href="/admin/vendedores/pendientes" style="font-size:12px;">Revisar →</a>
    </div>
    <div class="stat-tarjeta alerta">
        <h4>Ofertas pendientes</h4>
        <p class="numero"><?= esc($ofertasPendientes) ?></p>
        <a href="/admin/ofertas" style="font-size:12px;">Revisar →</a>
    </div>
</div>

<div class="tarjeta" style="max-width:420px; height:320px;">
    <h3>Usuarios activos por rol</h3>
    <canvas id="graficaUsuarios"></canvas>
</div>

<script>
    fetch('/admin/dashboard/datos/usuarios').then(r => r.json()).then(datos => {
        new Chart(document.getElementById('graficaUsuarios'), {
            type: 'doughnut',
            data: { labels: datos.labels, datasets: [{ data: datos.values, backgroundColor: ['#1f3a5f', '#e67e22', '#9b59b6', '#27ae60'] }]},
            options: { responsive: true, maintainAspectRatio: false }
        });
    });
</script>

<?= view('plantillas/pie') ?>