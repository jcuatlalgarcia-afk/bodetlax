<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class CategoriaController extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $categorias = $this->categoriaModel->orderBy('nombre', 'ASC')->findAll();
        return view('admin/categorias/index', ['categorias' => $categorias]);
    }

    public function guardar()
    {
        $reglas = ['nombre' => 'required|min_length[3]|max_length[100]|is_unique[categorias.nombre]'];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoriaModel->insert(['nombre' => $this->request->getPost('nombre')]);

        session()->setFlashdata('success', 'Categoría creada.');
        return redirect()->to('/admin/categorias');
    }

    public function actualizar($id)
    {
        $reglas = ['nombre' => "required|min_length[3]|max_length[100]|is_unique[categorias.nombre,id,{$id}]"];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoriaModel->update($id, ['nombre' => $this->request->getPost('nombre')]);

        session()->setFlashdata('success', 'Categoría actualizada.');
        return redirect()->to('/admin/categorias');
    }

    public function eliminar($id)
    {
        $db = \Config\Database::connect();

        // Verificamos en las dos tablas que dependen de categorías
        $productosAsociados = $db->table('productos')->where('categoria_id', $id)->countAllResults();
        $ofertasAsociadas    = $db->table('ofertas_proveedores')->where('categoria_id', $id)->countAllResults();

        if ($productosAsociados > 0 || $ofertasAsociadas > 0) {
            session()->setFlashdata('errors', ['categoria' => 'No se puede eliminar: hay productos u ofertas usando esta categoría.']);
            return redirect()->to('/admin/categorias');
        }

        $this->categoriaModel->delete($id);
        session()->setFlashdata('success', 'Categoría eliminada.');
        return redirect()->to('/admin/categorias');
    }
}