<?php

namespace App\Controllers\Proveedor;

use App\Controllers\BaseController;
use App\Models\OfertaProveedorModel;
use App\Models\CategoriaModel;
use App\Libraries\Notificador;

class OfertaController extends BaseController
{
    protected $ofertaModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->ofertaModel   = new OfertaProveedorModel();
        $this->categoriaModel = new CategoriaModel();
    }

    // Lista de ofertas enviadas por el proveedor logueado
    public function index()
    {
        $ofertas = $this->ofertaModel
            ->where('proveedor_id', session()->get('usuario_id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('proveedor/ofertas/index', ['ofertas' => $ofertas]);
    }

    public function crear()
    {
        $categorias = $this->categoriaModel->findAll();
        return view('proveedor/ofertas/crear', ['categorias' => $categorias]);
    }

    public function guardar()
    {
        $reglas = [
            'categoria_id'      => 'required|integer',
            'nombre_producto'   => 'required|min_length[3]|max_length[150]',
            'descripcion'       => 'permit_empty|max_length[2000]',
            'unidad_medida'     => 'required|max_length[20]',
            'precio_ofertado'   => 'required|decimal|greater_than[0]',
            'cantidad_ofertada' => 'required|integer|greater_than[0]',
            'imagen'            => 'permit_empty|max_size[imagen,2048]|is_image[imagen]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rutaImagen = null;
        $archivoImagen = $this->request->getFile('imagen');
        if ($archivoImagen && $archivoImagen->isValid()) {
            $nombreImagen = $archivoImagen->getRandomName();
            $archivoImagen->move(WRITEPATH . '../public/uploads/ofertas', $nombreImagen);
            $rutaImagen = 'uploads/ofertas/' . $nombreImagen;
        }

        $this->ofertaModel->insert([
            'proveedor_id'      => session()->get('usuario_id'),
            'categoria_id'      => $this->request->getPost('categoria_id'),
            'nombre_producto'   => $this->request->getPost('nombre_producto'),
            'descripcion'       => $this->request->getPost('descripcion'),
            'unidad_medida'     => $this->request->getPost('unidad_medida'),
            'precio_ofertado'   => $this->request->getPost('precio_ofertado'),
            'cantidad_ofertada' => $this->request->getPost('cantidad_ofertada'),
            'imagen'            => $rutaImagen,
            'estado'            => 'pendiente',
        ]);

        // Notificar a todos los administradores
$db = \Config\Database::connect();
$admins = $db->table('usuarios')
    ->select('usuarios.email')
    ->join('roles', 'roles.id = usuarios.rol_id')
    ->where('roles.nombre', 'administrador')
    ->get()->getResultArray();

$nombreProveedor = session()->get('nombre_completo');
foreach ($admins as $admin) {
    (new Notificador())->nuevaOfertaParaAdmin($admin['email'], $nombreProveedor, $this->request->getPost('nombre_producto'));
}

        session()->setFlashdata('success', 'Oferta enviada. Un administrador la revisará pronto.');
        return redirect()->to('/proveedor/ofertas');
    }
}