<?php

namespace App\Controllers;

use App\Models\CarritoItemModel;
use App\Models\ProductoModel;

class CarritoController extends BaseController
{
    protected $carritoModel;
    protected $productoModel;

    public function __construct()
    {
        $this->carritoModel  = new CarritoItemModel();
        $this->productoModel = new ProductoModel();
    }

    public function index()
    {
        $items = $this->carritoModel->conProductos(session()->get('usuario_id'));

        $subtotal = 0;
        foreach ($items as $item) {
            $precio = $item['precio_descuento'] ?? $item['precio'];
            $subtotal += $precio * $item['cantidad'];
        }

        $impuesto    = round($subtotal * 0.16, 2);
        $costoEnvio  = $subtotal > 0 ? 100.00 : 0;
        $total       = $subtotal + $impuesto + $costoEnvio;

        return view('carrito/index', [
            'items'       => $items,
            'subtotal'    => $subtotal,
            'impuesto'    => $impuesto,
            'costoEnvio'  => $costoEnvio,
            'total'       => $total,
        ]);
    }

    public function agregar()
    {
        $reglas = [
            'producto_id' => 'required|integer',
            'cantidad'    => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $productoId = $this->request->getPost('producto_id');
        $cantidad   = $this->request->getPost('cantidad');

        $producto = $this->productoModel->where('estado', 'activo')->find($productoId);

        if (! $producto) {
            return redirect()->back()->with('errors', ['producto' => 'Producto no disponible.']);
        }

        if ($cantidad > $producto['stock']) {
            return redirect()->back()->with('errors', ['producto' => 'No hay suficiente stock disponible.']);
        }

        $usuarioId = session()->get('usuario_id');

        $existente = $this->carritoModel
            ->where('usuario_id', $usuarioId)
            ->where('producto_id', $productoId)
            ->first();

        if ($existente) {
            $nuevaCantidad = $existente['cantidad'] + $cantidad;

            if ($nuevaCantidad > $producto['stock']) {
                return redirect()->back()->with('errors', ['producto' => 'No hay suficiente stock disponible.']);
            }

            $this->carritoModel->update($existente['id'], ['cantidad' => $nuevaCantidad]);
        } else {
            $this->carritoModel->insert([
                'usuario_id'  => $usuarioId,
                'producto_id' => $productoId,
                'cantidad'    => $cantidad,
            ]);
        }

        session()->setFlashdata('success', 'Producto agregado al carrito.');
        return redirect()->to('/carrito');
    }

    public function actualizarCantidad($carritoItemId)
    {
        $cantidad = $this->request->getPost('cantidad');

        $item = $this->carritoModel
            ->where('usuario_id', session()->get('usuario_id'))
            ->find($carritoItemId);

        if (! $item) {
            return redirect()->to('/carrito');
        }

        $producto = $this->productoModel->find($item['producto_id']);

        if ($cantidad < 1 || $cantidad > $producto['stock']) {
            return redirect()->to('/carrito')->with('errors', ['cantidad' => 'Cantidad no válida.']);
        }

        $this->carritoModel->update($carritoItemId, ['cantidad' => $cantidad]);
        return redirect()->to('/carrito');
    }

    public function eliminar($carritoItemId)
    {
        $this->carritoModel
            ->where('usuario_id', session()->get('usuario_id'))
            ->where('id', $carritoItemId)
            ->delete();

        return redirect()->to('/carrito');
    }
}