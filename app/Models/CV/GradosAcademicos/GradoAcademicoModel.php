<?php

namespace App\Models\CV\GradosAcademicos;

use CodeIgniter\Model;

class GradoAcademicoModel extends Model 
{
    protected $table = 'grado_academico'; 

    protected $primaryKey = 'id'; 

    protected $allowedFields = [

        "id_usuario",
        "nombre_grado",
        "institucion",
        "fecha_inicio",
        "fecha_final",
        "fecha_titulacion",
        "pais",
        "no_cedula",
        "tipo_cedula",

        
       
    ];

    public function findGradosAcademicosById($id)
    {
return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }
}