<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel  = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function porCategoria()
    {
        $categoriaId = $this->request->getGet('categoria_id');

        $categorias = $this->categoriaModel->findAll();
        $productos  = $categoriaId ? $this->productoModel->porCategoria($categoriaId) : [];

        return view('admin/productos/por_categoria', [
            'categorias'      => $categorias,
            'productos'       => $productos,
            'categoriaActual' => $categoriaId,
        ]);
    }
}