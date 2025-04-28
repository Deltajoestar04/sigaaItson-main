<?php

namespace App\Models\CV\ExperienciaLaboral;

use CodeIgniter\Model;

class ExperienciaLaboralModel extends Model
{
    protected $table = 'experiencia_laboral';
    protected $primaryKey = 'id';
    protected $allowedFields =
        [
            'id_usuario',
            'actividad_puesto',
            'empresa',
            'mes_inicio',
            'anio_inicio',
            'mes_fin',
            'anio_fin',
            'actualmente'
        ];

    public function findExperienciaLaboralById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }


}