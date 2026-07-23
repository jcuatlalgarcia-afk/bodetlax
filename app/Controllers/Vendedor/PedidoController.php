<?php

namespace App\Controllers\Vendedor;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\HistorialEstadoPedidoModel;

class PedidoController extends BaseController
{
    protected $pedidoModel;
    protected $pedidoItemModel;
    protected $historialModel;

    public function __construct()
    {
        $this->pedidoModel     = new PedidoModel();
        $this->pedidoItemModel = new PedidoItemModel();
        $this->historialModel  = new HistorialEstadoPedidoModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $pedidos = $db->table('pedidos')
            ->select('pedidos.*, usuarios.nombre_completo as cliente_nombre, r.nombre_completo as repartidor_nombre')
            ->join('usuarios', 'usuarios.id = pedidos.cliente_id')
            ->join('usuarios as r', 'r.id = pedidos.entregado_por', 'left')
            ->where('pedidos.estado', 'pagado')
            ->orderBy('pedidos.fecha_entrega', 'ASC')
            ->get()->getResultArray();

        return view('vendedor/pedidos/index', ['pedidos' => $pedidos]);
    }

    public function ver($id)
    {
        $db = \Config\Database::connect();
        $pedido = $db->table('pedidos')
            ->select('pedidos.*, usuarios.nombre_completo as cliente_nombre, r.nombre_completo as repartidor_nombre')
            ->join('usuarios', 'usuarios.id = pedidos.cliente_id')
            ->join('usuarios as r', 'r.id = pedidos.entregado_por', 'left')
            ->where('pedidos.id', $id)
            ->get()->getRowArray();

        if (! $pedido) {
            return redirect()->to('/vendedor/pedidos')->with('errors', ['pedido' => 'Pedido no encontrado.']);
        }

        $items = $this->pedidoItemModel->where('pedido_id', $id)->findAll();

        return view('vendedor/pedidos/ver', ['pedido' => $pedido, 'items' => $items]);
    }

    public function marcarCompleto($id)
    {
        $pedido = $this->pedidoModel->find($id);

        if (! $pedido || $pedido['estado'] !== 'pagado') {
            return redirect()->to('/vendedor/pedidos')->with('errors', ['pedido' => 'Este pedido no está listo para confirmarse.']);
        }

        $this->pedidoModel->update($id, ['estado' => 'completo']);

        $this->historialModel->insert([
            'pedido_id'    => $id,
            'estado'       => 'completo',
            'cambiado_por' => session()->get('usuario_id'),
        ]);

        session()->setFlashdata('success', 'Pedido confirmado como completo.');
        return redirect()->to('/vendedor/pedidos');
    }
}
