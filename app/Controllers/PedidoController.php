<?php

namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\HistorialEstadoPedidoModel;
use App\Models\UsuarioModel;
use App\Libraries\GeneradorPDF;

class PedidoController extends BaseController
{
    protected $pedidoModel;
    protected $pedidoItemModel;
    protected $historialModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->pedidoModel     = new PedidoModel();
        $this->pedidoItemModel = new PedidoItemModel();
        $this->historialModel  = new HistorialEstadoPedidoModel();
        $this->usuarioModel    = new UsuarioModel();
    }

    public function index()
    {
        $pedidos = $this->pedidoModel
            ->where('cliente_id', session()->get('usuario_id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('pedidos/index', ['pedidos' => $pedidos]);
    }

    public function ver($id)
    {
        $pedido = $this->pedidoModel
            ->where('cliente_id', session()->get('usuario_id'))
            ->find($id);

        if (! $pedido) {
            return redirect()->to('/pedidos')->with('errors', ['pedido' => 'Pedido no encontrado.']);
        }

        $items     = $this->pedidoItemModel->where('pedido_id', $id)->findAll();
        $historial = $this->historialModel->where('pedido_id', $id)->orderBy('created_at', 'ASC')->findAll();

        return view('pedidos/ver', [
            'pedido'    => $pedido,
            'items'     => $items,
            'historial' => $historial,
        ]);
    }

    public function descargarFactura($id)
    {
        $pedido = $this->pedidoModel
            ->where('cliente_id', session()->get('usuario_id'))
            ->find($id);

        if (! $pedido) {
            return redirect()->to('/pedidos')->with('errors', ['pedido' => 'Pedido no encontrado.']);
        }

        $items   = $this->pedidoItemModel->where('pedido_id', $id)->findAll();
        $cliente = $this->usuarioModel->find($pedido['cliente_id']);

        $html = view('pedidos/factura_pdf', [
            'pedido'  => $pedido,
            'items'   => $items,
            'cliente' => $cliente,
        ]);

        $pdf = new GeneradorPDF();
        $pdf->mostrar($html, 'Factura_Pedido_' . $pedido['id'] . '.pdf', true);
    }
}