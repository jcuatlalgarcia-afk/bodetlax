<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ProductoImagenModel;
use App\Models\ReporteModel;

class CatalogoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    protected $imagenModel;

    public function __construct()
    {
        $this->productoModel  = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->imagenModel    = new ProductoImagenModel();
    }

    public function index()
    {
        $filtros = [
            'palabra'        => $this->request->getGet('palabra'),
            'categoria_id'   => $this->request->getGet('categoria_id'),
            'precio_min'     => $this->request->getGet('precio_min'),
            'precio_max'     => $this->request->getGet('precio_max'),
            'disponibilidad' => $this->request->getGet('disponibilidad'),
        ];

        $productos = $this->productoModel
            ->buscarYFiltrar($filtros)
            ->orderBy('created_at', 'DESC')
            ->paginate(12);

        $categorias = $this->categoriaModel->findAll();

        return view('catalogo/index', [
            'productos'  => $productos,
            'categorias' => $categorias,
            'filtros'    => $filtros,
            'pager'      => $this->productoModel->pager,
        ]);
    }

    public function ver($id)
    {
        $producto = $this->productoModel->where('estado', 'activo')->find($id);

        if (! $producto) {
            return redirect()->to('/catalogo')->with('errors', ['producto' => 'Producto no disponible.']);
        }

        $galeria = $this->imagenModel->where('producto_id', $id)->findAll();

        return view('catalogo/ver', [
            'producto' => $producto,
            'galeria'  => $galeria,
        ]);
    }
    public function reportar($productoId)
{
    $reglas = ['motivo' => 'required|min_length[10]|max_length[500]'];

    if (! $this->validate($reglas)) {
        return redirect()->back()->with('errors', $this->validator->getErrors());
    }

    $reporteModel = new ReporteModel();
    $reporteModel->insert([
        'producto_id'   => $productoId,
        'reportado_por' => session()->get('usuario_id'),
        'motivo'        => $this->request->getPost('motivo'),
        'estado'        => 'pendiente',
    ]);

    session()->setFlashdata('success', 'Reporte enviado. El administrador lo revisará.');
    return redirect()->to('/catalogo/producto/' . $productoId);
}
}
