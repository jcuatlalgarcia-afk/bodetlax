<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titulo ?? 'BodeTlax' ?></title>
    <link rel="stylesheet" href="/assets/css/estilos.css">
</head>
<body>

<div class="barra-nav">
    <a href="/" class="marca">BodeTlax</a>

    <?php if (session()->get('isLoggedIn')): ?>
        <nav>
            <?php $rol = session()->get('rol'); ?>

            <?php if ($rol === 'cliente'): ?>
                <a href="/catalogo">Catálogo</a>
                <a href="/carrito">Carrito</a>
                <a href="/pedidos">Mis pedidos</a>
            <?php elseif ($rol === 'vendedor'): ?>
                <a href="/vendedor/dashboard">Dashboard</a>
                <a href="/vendedor/productos">Catálogo</a>
                <a href="/vendedor/ofertas-disponibles">Ofertas por publicar</a>
                <a href="/vendedor/pedidos">Confirmar entregas</a>
                <a href="/vendedor/clientes">Clientes</a>
            <?php elseif ($rol === 'proveedor'): ?>
                <a href="/proveedor/dashboard">Dashboard</a>
                <a href="/proveedor/ofertas">Mis ofertas</a>
                <a href="/proveedor/ofertas/crear">Nueva oferta</a>
            <?php elseif ($rol === 'repartidor'): ?>
                <a href="/repartidor/dashboard">Dashboard</a>
            <?php elseif ($rol === 'administrador'): ?>
                <a href="/admin/dashboard">Dashboard</a>
                <a href="/admin/personal/vendedor/pendientes">Vendedores</a>
                <a href="/admin/personal/repartidor/pendientes">Repartidores</a>
                <a href="/admin/administradores">Administradores</a>
                <a href="/admin/ofertas">Ofertas</a>
                <a href="/admin/categorias">Categorías</a>
                <a href="/admin/productos-por-categoria">Productos</a>
                <a href="/admin/clientes">Clientes</a>
                <a href="/admin/reportes">Reportes</a>
            <?php endif; ?>

            <a href="/logout">Cerrar sesión</a>
            <span class="usuario-chip"><?= esc(session()->get('nombre_completo')) ?></span>
        </nav>
    <?php else: ?>
        <nav>
            <a href="/catalogo">Catálogo</a>
            <a href="/login">Iniciar sesión</a>
            <a href="/registro" class="boton" style="margin-left:18px; padding:6px 16px;">Registrarse</a>
        </nav>
    <?php endif; ?>
</div>

<div class="contenedor">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alerta alerta-exito"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alerta alerta-error">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>