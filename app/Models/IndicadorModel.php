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
        'obj_particular',
        'descripcion',
        'cant_minima',
        'total_obtenido',
        'meta',
        'resultado',
        'indicador',
        'comentarios',
        'estrategias_semaforo_verde',
    ];

    protected $validationRules = [
        'id_usuario'           => 'required|is_natural_no_zero',
        'obj_particular'       => 'permit_empty',
        'descripcion'          => 'permit_empty',
        'cant_minima'          => 'permit_empty|integer',
        'total_obtenido'       => 'permit_empty|integer',
        'meta'                 => 'permit_empty|max_length[100]',
        'resultado'            => 'permit_empty|max_length[100]',
        'indicador'            => 'required|min_length[3]',
        'comentarios'          => 'permit_empty',
        'estrategias_semaforo_verde' => 'permit_empty',
    ];

 
    public function findIndicadoresPorUsuario($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->findAll();
       // echo "<pre>"; print_r($data); echo "</pre>"; exit;
    }
}