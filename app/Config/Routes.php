<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('testdb', 'TestDB::index');

// ---------- AUTENTICACIÓN ----------
$routes->get('registro', 'Auth::registro');

$routes->get('registro/cliente', 'Auth::registroCliente');
$routes->post('registro/cliente', 'Auth::intentarRegistroCliente');

$routes->get('registro/proveedor', 'Auth::registroProveedor');
$routes->post('registro/proveedor', 'Auth::intentarRegistroProveedor');

$routes->get('registro/vendedor', 'Auth::registroVendedor');
$routes->post('registro/vendedor', 'Auth::intentarRegistroVendedor');

$routes->get('registro/repartidor', 'Auth::registroRepartidor');
$routes->post('registro/repartidor', 'Auth::intentarRegistroRepartidor');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::intentarLogin');
$routes->get('logout', 'Auth::logout');

// ---------- CATÁLOGO PÚBLICO ----------
$routes->get('catalogo', 'CatalogoController::index');
$routes->get('catalogo/producto/(:num)', 'CatalogoController::ver/$1');

// ---------- PROVEEDOR ----------
$routes->group('proveedor', ['filter' => 'auth:proveedor'], function ($routes) {
    $routes->get('dashboard', 'Proveedor\DashboardController::index');
    $routes->get('dashboard/datos/estados', 'Proveedor\DashboardController::datosEstados');

    $routes->get('ofertas', 'Proveedor\OfertaController::index');
    $routes->get('ofertas/crear', 'Proveedor\OfertaController::crear');
    $routes->post('ofertas', 'Proveedor\OfertaController::guardar');
});

// ---------- VENDEDOR ----------
$routes->group('vendedor', ['filter' => 'auth:vendedor'], function ($routes) {
    $routes->get('dashboard', 'Vendedor\DashboardController::index');
    $routes->get('dashboard/datos/ventas', 'Vendedor\DashboardController::datosVentas');
    $routes->get('dashboard/datos/mas-vendidos', 'Vendedor\DashboardController::datosMasVendidos');

    $routes->get('productos', 'Vendedor\ProductoController::index');
    $routes->get('productos/crear', 'Vendedor\ProductoController::crear');
    $routes->post('productos', 'Vendedor\ProductoController::guardar');
    $routes->get('productos/editar/(:num)', 'Vendedor\ProductoController::editar/$1');
    $routes->post('productos/actualizar/(:num)', 'Vendedor\ProductoController::actualizar/$1');
    $routes->get('productos/eliminar/(:num)', 'Vendedor\ProductoController::eliminar/$1');
    $routes->get('productos/eliminar-definitivo/(:num)', 'Vendedor\ProductoController::eliminarDefinitivo/$1');

    $routes->get('ofertas-disponibles', 'Vendedor\ProductoController::ofertasDisponibles');
    $routes->get('productos/publicar-desde-oferta/(:num)', 'Vendedor\ProductoController::publicarDesdeOferta/$1');

    $routes->get('pedidos', 'Vendedor\PedidoController::index');
    $routes->get('pedidos/(:num)', 'Vendedor\PedidoController::ver/$1');
    $routes->post('pedidos/(:num)/completo', 'Vendedor\PedidoController::marcarCompleto/$1');

    $routes->get('clientes', 'Admin\ClienteController::index');
    $routes->get('productos/reactivar/(:num)', 'Vendedor\ProductoController::reactivar/$1');
});

// ---------- REPARTIDOR ----------
$routes->group('repartidor', ['filter' => 'auth:repartidor'], function ($routes) {
    $routes->get('dashboard', 'Repartidor\PedidoController::index');
    $routes->get('pedidos', 'Repartidor\PedidoController::index');
    $routes->get('pedidos/(:num)', 'Repartidor\PedidoController::ver/$1');
    $routes->post('pedidos/(:num)/pagado', 'Repartidor\PedidoController::marcarPagado/$1');
    $routes->get('pedidos/(:num)/comprobante', 'Repartidor\PedidoController::descargarComprobante/$1');
});

// ---------- ADMINISTRADOR ----------
$routes->group('admin', ['filter' => 'auth:administrador'], function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->get('dashboard/datos/usuarios', 'Admin\DashboardController::datosUsuarios');

    // Personal (vendedores y repartidores) - rutas específicas ANTES que la genérica
    $routes->get('personal/(:segment)/pendientes', 'Admin\PersonalController::pendientes/$1');
    $routes->get('personal/(:segment)/aprobar/(:num)', 'Admin\PersonalController::aprobar/$1/$2');
    $routes->get('personal/(:segment)/rechazar/(:num)', 'Admin\PersonalController::rechazar/$1/$2');
    $routes->get('personal/(:segment)/desactivar/(:num)', 'Admin\PersonalController::desactivar/$1/$2');
    $routes->get('personal/(:segment)/reactivar/(:num)', 'Admin\PersonalController::reactivar/$1/$2');
    $routes->get('personal/(:segment)/eliminar/(:num)', 'Admin\PersonalController::eliminar/$1/$2');
    $routes->get('personal/(:segment)', 'Admin\PersonalController::index/$1');

    // Administradores
    $routes->get('administradores', 'Admin\AdministradorController::index');
    $routes->get('administradores/crear', 'Admin\AdministradorController::crear');
    $routes->post('administradores', 'Admin\AdministradorController::guardar');

    // Ofertas de proveedores
    $routes->get('ofertas', 'Admin\OfertaController::index');
    $routes->get('ofertas/aceptar/(:num)', 'Admin\OfertaController::aceptar/$1');
    $routes->get('ofertas/rechazar/(:num)', 'Admin\OfertaController::rechazar/$1');
    $routes->get('ofertas/aceptadas', 'Admin\OfertaController::aceptadas');
    $routes->get('ofertas/orden-compra/(:num)', 'Admin\OfertaController::descargarOrdenCompra/$1');

    // Categorías
    $routes->get('categorias', 'Admin\CategoriaController::index');
    $routes->post('categorias', 'Admin\CategoriaController::guardar');
    $routes->post('categorias/actualizar/(:num)', 'Admin\CategoriaController::actualizar/$1');
    $routes->get('categorias/eliminar/(:num)', 'Admin\CategoriaController::eliminar/$1');

    // Productos por categoría
    $routes->get('productos-por-categoria', 'Admin\ProductoController::porCategoria');

    // Clientes
    $routes->get('clientes', 'Admin\ClienteController::index');

    // Reportes
    $routes->get('reportes', 'Admin\ReporteController::index');
    $routes->get('reportes/revisar/(:num)', 'Admin\ReporteController::marcarRevisado/$1');
});

// ---------- CLIENTE (carrito, pago, pedidos) ----------
$routes->group('', ['filter' => 'auth:cliente'], function ($routes) {
    $routes->get('carrito', 'CarritoController::index');
    $routes->post('carrito/agregar', 'CarritoController::agregar');
    $routes->post('carrito/actualizar/(:num)', 'CarritoController::actualizarCantidad/$1');
    $routes->get('carrito/eliminar/(:num)', 'CarritoController::eliminar/$1');
    $routes->get('carrito/resumen', 'CarritoController::resumen');

    $routes->get('pago', 'PagoController::index');
    $routes->post('pago/procesar', 'PagoController::procesar');

    $routes->get('pedidos', 'PedidoController::index');
    $routes->get('pedidos/(:num)', 'PedidoController::ver/$1');
    $routes->get('pedidos/(:num)/factura', 'PedidoController::descargarFactura/$1');

    $routes->post('catalogo/producto/(:num)/reportar', 'CatalogoController::reportar/$1');
});