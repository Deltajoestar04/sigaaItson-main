<?php

namespace App\Models;

use CodeIgniter\Model;

class IndicadorModel extends Model
{
    protected $table = 'indicador_tb';
    protected $DBGroup = 'default';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;

    protected $protectFields = true;
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
        'prog_edu_id',
    ];

    protected $validationRules = [
        'id_usuario' => 'required|is_natural_no_zero',
        'obj_particular' => 'permit_empty',
        'descripcion' => 'permit_empty',
        'cant_minima' => 'permit_empty|integer',
        'total_obtenido' => 'permit_empty|integer',
        'meta' => 'permit_empty|max_length[100]',
        'resultado' => 'permit_empty|max_length[100]',
        'indicador' => 'required|min_length[3]',
        'comentarios' => 'permit_empty',
        'estrategias_semaforo_verde' => 'permit_empty',
        'prog_edu_id' => 'permit_empty|is_natural_no_zero',
    ];

   
    public function findIndicadoresPorUsuario($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->findAll();
    }

   
    public function obtenerIndicadoresConPrograma($id_usuario)
    {
        return $this->select('indicador_tb.*, programas_educativos.nombre AS nombre_programa')
                    ->join('programas_educativos', 'programas_educativos.id = indicador_tb.prog_edu_id', 'left')
                    ->where('indicador_tb.id_usuario', $id_usuario)
                    ->findAll();
    }

  
    public function obtenerPorPrograma($prog_edu_id, $id_usuario)
    {
        return $this->where('prog_edu_id', $prog_edu_id)
                    ->where('id_usuario', $id_usuario)
                    ->findAll();
    }
}
