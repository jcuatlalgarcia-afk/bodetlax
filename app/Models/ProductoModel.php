<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'publicado_por',
        'oferta_origen_id',
        'categoria_id',
        'nombre',
        'descripcion',
        'unidad_medida',
        'precio',
        'precio_descuento',
        'stock',
        'imagen_principal',
        'estado',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'categoria_id'  => 'required|integer',
        'nombre'        => 'required|min_length[3]|max_length[150]',
        'unidad_medida' => 'required|max_length[20]',
        'precio'        => 'required|decimal|greater_than[0]',
        'stock'         => 'required|integer|greater_than_equal_to[0]',
    ];

    public function activos()
    {
        return $this->where('estado', 'activo');
    }

    public function buscarYFiltrar(array $filtros)
    {
        $builder = $this->activos();

        if (! empty($filtros['palabra'])) {
            $builder->groupStart()
                ->like('nombre', $filtros['palabra'])
                ->orLike('descripcion', $filtros['palabra'])
                ->groupEnd();
        }

        if (! empty($filtros['categoria_id'])) {
            $builder->where('categoria_id', $filtros['categoria_id']);
        }

        if (! empty($filtros['precio_min'])) {
            $builder->where('precio >=', $filtros['precio_min']);
        }

        if (! empty($filtros['precio_max'])) {
            $builder->where('precio <=', $filtros['precio_max']);
        }

        if (! empty($filtros['disponibilidad']) && $filtros['disponibilidad'] === 'disponible') {
            $builder->where('stock >', 0);
        }

        return $builder;
    }

    public function porCategoria(int $categoriaId)
    {
        return $this->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id')
            ->where('productos.categoria_id', $categoriaId)
            ->orderBy('productos.nombre', 'ASC')
            ->findAll();
    }
}