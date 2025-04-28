<?php

namespace App\Models\CV\GradosAcademicos;

use CodeIgniter\Model;

class ProdepModel extends Model 
{
    protected $table = 'prodep'; 

    protected $primaryKey = 'id'; 

    protected $allowedFields = [

        "id_grado_academico",
        "fecha_comienzo",
        "fecha_termino",
      
       
    ];

    public function findByGradosProdepId($idGrado)
    {
        return $this->where('id_grado_academico', $idGrado)
                    ->findAll();
    }
    
}