<?php

namespace App\Models\CV\GradosAcademicos;

use CodeIgniter\Model;

class SNIModel extends Model 
{
    protected $table = 'sistema_nacional_investigadores'; 

    protected $primaryKey = 'id'; 

    protected $allowedFields = [

        "id_grado_academico",
        "nivel"
    ];

    public function findByGradosSniId($idGrado)
    {
        return $this->where('id_grado_academico', $idGrado)
                    ->findAll();
    }
}