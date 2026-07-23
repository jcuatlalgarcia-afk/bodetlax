<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class GeneradorPDF
{
    protected Dompdf $dompdf;

    public function __construct()
    {
        $opciones = new Options();
        $opciones->set('isHtml5ParserEnabled', true);
        $opciones->set('isRemoteEnabled', true);
        $opciones->set('defaultFont', 'DejaVu Sans');

        $this->dompdf = new Dompdf($opciones);
    }

    /**
     * Genera el PDF y lo envía al navegador (descarga o vista previa)
     */
    public function mostrar(string $html, string $nombreArchivo = 'documento.pdf', bool $descargar = false)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('letter', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream($nombreArchivo, ['Attachment' => $descargar]);
    }

    /**
     * Genera el PDF y lo guarda en disco (útil para adjuntar a un correo)
     */
    public function guardar(string $html, string $rutaCompleta): void
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('letter', 'portrait');
        $this->dompdf->render();

        file_put_contents($rutaCompleta, $this->dompdf->output());
    }
}