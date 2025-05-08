<?php

namespace App\Models;

use CodeIgniter\Model;

class IndicadorModel extends Model
{
    protected $table = 'Indicador_tb';
    protected $DBGroup = 'default';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $useTimestamps = true;
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_usuario',
        'OBJ. PARTICULAR',
        'DESCRIPCION',
        'CANT. MINIMA',
        'TOTAL OBTENIDO',
        'META',
        'RESULTADO',
        'INDICADOR',
        'COMENTARIOS',
        'Acciones y/o Estrategias para lograr semáforo verde',
    ];

    protected $validationRules = [
        'id_usuario'  => 'required|is_natural_no_zero',
        'OBJ. PARTICULAR' => 'permit_empty',
        'DESCRIPCION'     => 'permit_empty',
        'CANT. MINIMA'    => 'permit_empty|integer',
        'TOTAL OBTENIDO'  => 'permit_empty|integer',
        'META'            => 'permit_empty|max_length[100]',
        'RESULTADO'       => 'permit_empty|max_length[100]',
        'INDICADOR'       => 'required|min_length[3]',
        'COMENTARIOS'     => 'permit_empty',
        'Acciones y/o Estrategias para lograr semáforo verde' => 'permit_empty',
    ];

    public function findIndicadoresPorUsuario($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->findAll();
    }
}
