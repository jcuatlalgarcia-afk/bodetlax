<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoImagenModel extends Model
{
    protected $table            = 'producto_imagenes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = ['producto_id', 'ruta_imagen'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}
