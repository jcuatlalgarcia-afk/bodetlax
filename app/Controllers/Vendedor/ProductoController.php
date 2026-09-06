<?php

namespace App\Controllers\Vendedor;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\ProductoImagenModel;
use App\Models\OfertaProveedorModel;
use App\Models\CategoriaModel;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $imagenModel;
    protected $ofertaModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel  = new ProductoModel();
        $this->imagenModel    = new ProductoImagenModel();
        $this->ofertaModel    = new OfertaProveedorModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $productos = $this->productoModel->orderBy('created_at', 'DESC')->findAll();
        return view('vendedor/productos/index', ['productos' => $productos]);
    }

    public function ofertasDisponibles()
    {
        $ofertas = $this->ofertaModel->aceptadasSinPublicar()->findAll();
        return view('vendedor/productos/ofertas_disponibles', ['ofertas' => $ofertas]);
    }

    public function publicarDesdeOferta($ofertaId)
    {
        $oferta = $this->ofertaModel
            ->select('ofertas_proveedores.*, usuarios.nombre_completo as proveedor_nombre, categorias.nombre as categoria_nombre')
            ->join('usuarios', 'usuarios.id = ofertas_proveedores.proveedor_id')
            ->join('categorias', 'categorias.id = ofertas_proveedores.categoria_id')
            ->find($ofertaId);

        if (! $oferta || $oferta['estado'] !== 'aceptada') {
            return redirect()->to('/vendedor/ofertas-disponibles')->with('errors', ['oferta' => 'Oferta no disponible.']);
        }

        $categorias = $this->categoriaModel->findAll();

        return view('vendedor/productos/publicar', [
            'oferta'     => $oferta,
            'categorias' => $categorias,
        ]);
    }

    public function crear()
    {
        $categorias = $this->categoriaModel->findAll();
        return view('vendedor/productos/crear', ['categorias' => $categorias]);
    }

    public function guardar()
    {
        $ofertaId = $this->request->getPost('oferta_origen_id');

        $reglas = [
            'categoria_id'  => 'required|integer',
            'nombre'        => 'required|min_length[3]|max_length[150]',
            'descripcion'   => 'permit_empty|max_length[2000]',
            'unidad_medida' => 'required|max_length[20]',
            'precio'        => 'required|decimal|greater_than[0]',
            'stock'         => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $ofertaId) {
            $reglas['imagen_principal'] = 'uploaded[imagen_principal]|max_size[imagen_principal,2048]|is_image[imagen_principal]';
        } else {
            $reglas['imagen_principal'] = 'permit_empty|max_size[imagen_principal,2048]|is_image[imagen_principal]';
        }

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rutaImagen = null;
        $archivoImagen = $this->request->getFile('imagen_principal');

        if ($archivoImagen && $archivoImagen->isValid()) {
            $nombreImagen = $archivoImagen->getRandomName();
            $archivoImagen->move(WRITEPATH . '../public/uploads/productos', $nombreImagen);
            $rutaImagen = 'uploads/productos/' . $nombreImagen;
        } elseif ($ofertaId) {
            $oferta = $this->ofertaModel->find($ofertaId);
            $rutaImagen = $oferta['imagen'] ?? null;
        }

        $productoId = $this->productoModel->insert([
            'publicado_por'    => session()->get('usuario_id'),
            'oferta_origen_id' => $ofertaId ?: null,
            'categoria_id'     => $this->request->getPost('categoria_id'),
            'nombre'           => $this->request->getPost('nombre'),
            'descripcion'      => $this->request->getPost('descripcion'),
            'unidad_medida'    => $this->request->getPost('unidad_medida'),
            'precio'           => $this->request->getPost('precio'),
            'stock'            => $this->request->getPost('stock'),
            'imagen_principal' => $rutaImagen,
            'estado'           => 'activo',
        ]);

        if ($ofertaId) {
            $this->ofertaModel->update($ofertaId, ['estado' => 'publicada']);
        }

        session()->setFlashdata('success', 'Producto publicado en el catálogo.');
        return redirect()->to('/vendedor/productos');
    }

    public function editar($id)
    {
        $producto = $this->productoModel->find($id);

        if (! $producto) {
            return redirect()->to('/vendedor/productos')->with('errors', ['producto' => 'Producto no encontrado.']);
        }

        $categorias = $this->categoriaModel->findAll();

        return view('vendedor/productos/editar', [
            'producto'   => $producto,
            'categorias' => $categorias,
        ]);
    }

    public function actualizar($id)
    {
        $reglas = [
            'categoria_id'  => 'required|integer',
            'nombre'        => 'required|min_length[3]|max_length[150]',
            'unidad_medida' => 'required|max_length[20]',
            'precio'        => 'required|decimal|greater_than[0]',
            'stock'         => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productoModel->update($id, [
            'categoria_id'  => $this->request->getPost('categoria_id'),
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'unidad_medida' => $this->request->getPost('unidad_medida'),
            'precio'        => $this->request->getPost('precio'),
            'stock'         => $this->request->getPost('stock'),
        ]);

        session()->setFlashdata('success', 'Producto actualizado.');
        return redirect()->to('/vendedor/productos');
    }

    public function eliminar($id)
    {
        $this->productoModel->update($id, ['estado' => 'inactivo']);
        session()->setFlashdata('success', 'Producto dado de baja del catálogo.');
        return redirect()->to('/vendedor/productos');
    }

    public function eliminarDefinitivo($id)
    {
        $producto = $this->productoModel->find($id);

        if (! $producto) {
            return redirect()->to('/vendedor/productos')->with('errors', ['producto' => 'Producto no encontrado.']);
        }

        if ($producto['estado'] !== 'inactivo') {
            return redirect()->to('/vendedor/productos')->with('errors', ['producto' => 'Solo se pueden eliminar productos que ya estén dados de baja.']);
        }

        try {
            $this->productoModel->delete($id);
            session()->setFlashdata('success', 'Producto eliminado permanentemente.');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('errors', ['producto' => 'No se puede eliminar: este producto ya tiene pedidos registrados en el historial.']);
        }

        return redirect()->to('/vendedor/productos');
    }

    public function reactivar($id)
{
    $producto = $this->productoModel->find($id);

    if (! $producto) {
        return redirect()->to('/vendedor/productos')->with('errors', ['producto' => 'Producto no encontrado.']);
    }

    $this->productoModel->update($id, ['estado' => 'activo']);

    session()->setFlashdata('success', 'Producto reactivado en el catálogo.');
    return redirect()->to('/vendedor/productos');
}

}