<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReporteModel;

class ReporteController extends BaseController
{
    protected $reporteModel;

    public function __construct()
    {
        $this->reporteModel = new ReporteModel();
    }

    public function index()
    {
        $reportes = $this->reporteModel->conDetalles()->findAll();
        return view('admin/reportes/index', ['reportes' => $reportes]);
    }

    public function marcarRevisado($id)
    {
        $this->reporteModel->update($id, ['estado' => 'revisado']);
        session()->setFlashdata('success', 'Reporte marcado como revisado.');
        return redirect()->to('/admin/reportes');
    }
}