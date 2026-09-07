<?php

namespace App\Controllers;

use App\Models\CarritoItemModel;
use App\Models\ProductoModel;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\HistorialEstadoPedidoModel;
use App\Models\MovimientoInventarioModel;
use App\Models\UsuarioModel;
use App\Libraries\Notificador;

class PagoController extends BaseController
{
    protected $carritoModel;
    protected $productoModel;
    protected $pedidoModel;
    protected $pedidoItemModel;
    protected $historialModel;
    protected $inventarioModel;

    public function __construct()
    {
        $this->carritoModel    = new CarritoItemModel();
        $this->productoModel   = new ProductoModel();
        $this->pedidoModel     = new PedidoModel();
        $this->pedidoItemModel = new PedidoItemModel();
        $this->historialModel  = new HistorialEstadoPedidoModel();
        $this->inventarioModel = new MovimientoInventarioModel();
    }

    public function index()
    {
        $items = $this->carritoModel->conProductos(session()->get('usuario_id'));

        if (empty($items)) {
            return redirect()->to('/carrito')->with('errors', ['carrito' => 'Tu carrito está vacío.']);
        }

        return view('pago/index', ['items' => $items]);
    }

    public function procesar()
    {
        $reglas = [
            'direccion_envio' => 'required|min_length[10]|max_length[255]',
            'metodo_pago'     => 'required|in_list[efectivo,tarjeta,transferencia]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuarioId = session()->get('usuario_id');
        $items     = $this->carritoModel->conProductos($usuarioId);

        if (empty($items)) {
            return redirect()->to('/carrito')->with('errors', ['carrito' => 'Tu carrito está vacío.']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Revalidar stock
        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if (! $producto || $item['cantidad'] > $producto['stock']) {
                $db->transRollback();
                return redirect()->to('/carrito')->with('errors', [
                    'stock' => 'El producto "' . $item['nombre'] . '" ya no tiene suficiente stock.',
                ]);
            }
        }

        // 2. Calcular totales
        $subtotal = 0;
        foreach ($items as $item) {
            $precio = $item['precio_descuento'] ?? $item['precio'];
            $subtotal += $precio * $item['cantidad'];
        }
        $impuesto   = round($subtotal * 0.16, 2);
        $costoEnvio = 1000.00;
        $total      = $subtotal + $impuesto + $costoEnvio;

        // 3. Crear pedido
        $pedidoId = $this->pedidoModel->insert([
            'cliente_id'      => $usuarioId,
            'subtotal'        => $subtotal,
            'impuesto'        => $impuesto,
            'costo_envio'     => $costoEnvio,
            'total'           => $total,
            'estado'          => 'pendiente',
            'direccion_envio' => $this->request->getPost('direccion_envio'),
            'metodo_pago'     => $this->request->getPost('metodo_pago'),
        ]);

        // 4. Crear pedido_items, descontar stock, registrar movimiento
        foreach ($items as $item) {
            $precio = $item['precio_descuento'] ?? $item['precio'];

            $this->pedidoItemModel->insert([
                'pedido_id'       => $pedidoId,
                'producto_id'     => $item['producto_id'],
                'nombre_producto' => $item['nombre'],
                'precio_unitario' => $precio,
                'cantidad'        => $item['cantidad'],
                'total_linea'     => $precio * $item['cantidad'],
            ]);

            $this->productoModel->update($item['producto_id'], [
                'stock' => $item['stock'] - $item['cantidad'],
            ]);

            $this->inventarioModel->insert([
                'producto_id' => $item['producto_id'],
                'tipo'        => 'salida',
                'cantidad'    => $item['cantidad'],
                'motivo'      => 'Venta - Pedido #' . $pedidoId,
                'creado_por'  => $usuarioId,
            ]);
        }

        // 5. Historial de estado inicial
        $this->historialModel->insert([
            'pedido_id'    => $pedidoId,
            'estado'       => 'pendiente',
            'cambiado_por' => $usuarioId,
        ]);

        // 6. Vaciar carrito
        $this->carritoModel->where('usuario_id', $usuarioId)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/carrito')->with('errors', ['pedido' => 'Ocurrió un error al procesar tu pedido. Intenta de nuevo.']);
        }

        session()->setFlashdata('success', 'Pedido realizado con éxito.');
        $usuarioModel = new UsuarioModel();
$cliente = $usuarioModel->find($usuarioId);
(new Notificador())->pedidoConfirmado($cliente['email'], $cliente['nombre_completo'], $pedidoId, $total);
        return redirect()->to('/pedidos/' . $pedidoId);
    }
}
