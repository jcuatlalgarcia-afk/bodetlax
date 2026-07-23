<?php

namespace App\Controllers\Repartidor;

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
            ->select('pedidos.*, usuarios.nombre_completo as cliente_nombre')
            ->join('usuarios', 'usuarios.id = pedidos.cliente_id')
            ->whereIn('pedidos.estado', ['pendiente', 'en_camino'])
            ->orderBy('pedidos.created_at', 'ASC')
            ->get()->getResultArray();

        return view('repartidor/pedidos/index', ['pedidos' => $pedidos]);
    }

    public function ver($id)
    {
        $db = \Config\Database::connect();
        $pedido = $db->table('pedidos')
            ->select('pedidos.*, usuarios.nombre_completo as cliente_nombre, usuarios.telefono as cliente_telefono')
            ->join('usuarios', 'usuarios.id = pedidos.cliente_id')
            ->where('pedidos.id', $id)
            ->get()->getRowArray();

        if (! $pedido) {
            return redirect()->to('/repartidor/pedidos')->with('errors', ['pedido' => 'Pedido no encontrado.']);
        }

        $items = $this->pedidoItemModel->where('pedido_id', $id)->findAll();

        return view('repartidor/pedidos/ver', ['pedido' => $pedido, 'items' => $items]);
    }

    public function marcarPagado($id)
    {
        $reglas = ['evidencia' => 'uploaded[evidencia]|max_size[evidencia,3072]|is_image[evidencia]'];

        if (! $this->validate($reglas)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $pedido = $this->pedidoModel->find($id);
        if (! $pedido) {
            return redirect()->to('/repartidor/pedidos')->with('errors', ['pedido' => 'Pedido no encontrado.']);
        }

        $archivo = $this->request->getFile('evidencia');
        $nombreArchivo = $archivo->getRandomName();
        $archivo->move(WRITEPATH . '../public/uploads/evidencias', $nombreArchivo);

        $this->pedidoModel->update($id, [
            'estado'            => 'pagado',
            'evidencia_entrega' => 'uploads/evidencias/' . $nombreArchivo,
            'entregado_por'     => session()->get('usuario_id'),
            'fecha_entrega'     => date('Y-m-d H:i:s'),
        ]);

        $this->historialModel->insert([
            'pedido_id'    => $id,
            'estado'       => 'pagado',
            'cambiado_por' => session()->get('usuario_id'),
        ]);

        session()->setFlashdata('success', 'Pedido marcado como pagado y entregado, con evidencia registrada.');
        return redirect()->to('/repartidor/pedidos');
    }
}