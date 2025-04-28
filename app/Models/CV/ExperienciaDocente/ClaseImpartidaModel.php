<?php

namespace App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class ClaseImpartidaModel extends Model
{
    protected $table = 'clase_impartida';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_experiencia_docente',
        'nombre_clase',
        'programa_educativo',
        'numero_horas'
    ];

    public function getClasesByExperienciaId($experienciaId)
    {
        return $this->where('id_experiencia_docente', $experienciaId)->findAll();
    }
}