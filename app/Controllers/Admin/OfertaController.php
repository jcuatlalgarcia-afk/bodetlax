<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OfertaProveedorModel;
use App\Models\UsuarioModel;
use App\Libraries\GeneradorPDF;
use App\Libraries\Notificador;

class OfertaController extends BaseController
{
    protected $ofertaModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->ofertaModel  = new OfertaProveedorModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $ofertas = $this->ofertaModel->pendientes()->findAll();
        return view('admin/ofertas/index', ['ofertas' => $ofertas]);
    }

    public function aceptar($id)
{
    $oferta = $this->ofertaModel
        ->select('ofertas_proveedores.*, usuarios.nombre_completo as proveedor_nombre, usuarios.email as proveedor_email')
        ->join('usuarios', 'usuarios.id = ofertas_proveedores.proveedor_id')
        ->find($id);

    if (! $oferta) {
        return redirect()->to('/admin/ofertas')->with('errors', ['oferta' => 'Oferta no encontrada.']);
    }

    $this->ofertaModel->update($id, [
        'estado'       => 'aceptada',
        'revisado_por' => session()->get('usuario_id'),
    ]);

    (new Notificador())->ofertaRevisada($oferta['proveedor_email'], $oferta['proveedor_nombre'], $oferta['nombre_producto'], 'aceptada');

    session()->setFlashdata('success', 'Oferta aceptada. Se notificó al proveedor.');
    return redirect()->to('/admin/ofertas');
}

public function rechazar($id)
{
    $oferta = $this->ofertaModel
        ->select('ofertas_proveedores.*, usuarios.nombre_completo as proveedor_nombre, usuarios.email as proveedor_email')
        ->join('usuarios', 'usuarios.id = ofertas_proveedores.proveedor_id')
        ->find($id);

    if (! $oferta) {
        return redirect()->to('/admin/ofertas')->with('errors', ['oferta' => 'Oferta no encontrada.']);
    }

    $this->ofertaModel->update($id, [
        'estado'       => 'rechazada',
        'revisado_por' => session()->get('usuario_id'),
    ]);

    (new Notificador())->ofertaRevisada($oferta['proveedor_email'], $oferta['proveedor_nombre'], $oferta['nombre_producto'], 'rechazada');

    session()->setFlashdata('success', 'Oferta rechazada. Se notificó al proveedor.');
    return redirect()->to('/admin/ofertas');
}

    // Lista de ofertas ya aceptadas (aceptadas o publicadas), para poder generar su orden de compra
    public function aceptadas()
    {
        $ofertas = $this->ofertaModel
            ->select('ofertas_proveedores.*, usuarios.nombre_completo as proveedor_nombre, categorias.nombre as categoria_nombre')
            ->join('usuarios', 'usuarios.id = ofertas_proveedores.proveedor_id')
            ->join('categorias', 'categorias.id = ofertas_proveedores.categoria_id')
            ->whereIn('ofertas_proveedores.estado', ['aceptada', 'publicada'])
            ->orderBy('ofertas_proveedores.updated_at', 'DESC')
            ->findAll();

        return view('admin/ofertas/aceptadas', ['ofertas' => $ofertas]);
    }

    public function descargarOrdenCompra($id)
    {
        $oferta = $this->ofertaModel
            ->select('ofertas_proveedores.*, usuarios.nombre_completo as proveedor_nombre, categorias.nombre as categoria_nombre')
            ->join('usuarios', 'usuarios.id = ofertas_proveedores.proveedor_id')
            ->join('categorias', 'categorias.id = ofertas_proveedores.categoria_id')
            ->find($id);

        if (! $oferta || ! in_array($oferta['estado'], ['aceptada', 'publicada'])) {
            return redirect()->to('/admin/ofertas/aceptadas')->with('errors', ['oferta' => 'Esta oferta no tiene una orden de compra disponible.']);
        }

        $proveedor = $this->usuarioModel->find($oferta['proveedor_id']);

        $html = view('admin/ofertas/orden_compra_pdf', [
            'oferta'    => $oferta,
            'proveedor' => $proveedor,
        ]);

        $pdf = new GeneradorPDF();
        $pdf->mostrar($html, 'Orden_Compra_' . $oferta['id'] . '.pdf', true);
    }
}
