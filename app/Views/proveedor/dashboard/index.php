<?= view('plantillas/encabezado', ['titulo' => 'Dashboard - BodeTlax']) ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1>Dashboard del proveedor</h1>

<div class="tarjetas-fila">
    <div class="stat-tarjeta">
        <h4>Ofertas totales</h4>
        <p class="numero"><?= esc($totalOfertas) ?></p>
    </div>
    <div class="stat-tarjeta pendiente">
        <h4>Pendientes de revisión</h4>
        <p class="numero"><?= esc($pendientes) ?></p>
    </div>
    <div class="stat-tarjeta ok">
        <h4>Aceptadas</h4>
        <p class="numero"><?= esc($aceptadas) ?></p>
    </div>
</div>

<div class="tarjeta" style="max-width:420px; height:320px;">
    <h3>Mis ofertas por estado</h3>
    <canvas id="graficaEstados"></canvas>
</div>

<p class="espacio-arriba"><a href="/proveedor/ofertas/crear" class="boton boton-acento">+ Nueva oferta</a></p>

<script>
    fetch('/proveedor/dashboard/datos/estados').then(r => r.json()).then(datos => {
        new Chart(document.getElementById('graficaEstados'), {
            type: 'doughnut',
            data: { labels: datos.labels, datasets: [{ data: datos.values, backgroundColor: ['#f1c40f', '#27ae60', '#e74c3c', '#3498db'] }]},
            options: { responsive: true, maintainAspectRatio: false }
        });
    });
</script>

<?= view('plantillas/pie') ?>