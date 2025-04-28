<?php

namespace App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class ExperienciaDocenteModel extends Model
{
    protected $table = 'experiencia_docente';
    protected $primaryKey = 'id';
    protected $allowedFields =
        [
            'id_usuario',
            'puesto_area',
            'institucion',
            'mes_inicio',
            'anio_inicio',
            'mes_fin',
            'anio_fin',
            'actualmente'
        ];

    public function findExperienciaDocenteById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }

}