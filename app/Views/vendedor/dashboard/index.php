<?= view('plantillas/encabezado', ['titulo' => 'Dashboard - BodeTlax']) ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1>Dashboard del vendedor</h1>

<div class="tarjetas-fila">
    <div class="stat-tarjeta">
        <h4>Productos activos</h4>
        <p class="numero"><?= esc($totalProductos) ?></p>
    </div>
    <div class="stat-tarjeta pendiente">
        <h4>Ofertas por publicar</h4>
        <p class="numero"><?= esc($ofertasPorPublicar) ?></p>
        <a href="/vendedor/ofertas-disponibles" style="font-size:12px;">Ver ofertas →</a>
    </div>
</div>

<div class="flex-gap">
    <div class="tarjeta" style="flex:1; min-width:400px; height:320px;">
        <h3>Ventas del negocio (últimos 7 días)</h3>
        <canvas id="graficaVentas"></canvas>
    </div>
    <div class="tarjeta" style="flex:1; min-width:340px; height:320px;">
        <h3>Top 5 productos más vendidos</h3>
        <canvas id="graficaMasVendidos"></canvas>
    </div>
</div>

<script>
    fetch('/vendedor/dashboard/datos/ventas').then(r => r.json()).then(datos => {
        new Chart(document.getElementById('graficaVentas'), {
            type: 'line',
            data: { labels: datos.labels, datasets: [{
                label: 'Ventas ($)', data: datos.values,
                borderColor: '#1f3a5f', backgroundColor: 'rgba(31,58,95,0.1)',
                fill: true, tension: 0.2, pointRadius: 6, pointHoverRadius: 8
            }]},
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
        });
    });
    fetch('/vendedor/dashboard/datos/mas-vendidos').then(r => r.json()).then(datos => {
        new Chart(document.getElementById('graficaMasVendidos'), {
            type: 'bar',
            data: { labels: datos.labels, datasets: [{ label: 'Unidades vendidas', data: datos.values, backgroundColor: '#e67e22' }]},
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
        });
    });
</script>

<?= view('plantillas/pie') ?>