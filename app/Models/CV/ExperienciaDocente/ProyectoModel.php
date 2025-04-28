<?php

namespace App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $table = 'proyecto';
    protected $primaryKey = 'id';


    protected $allowedFields =
        [
            'id',
            'nombre',
            'tipo',
            'tipo_financiamiento',
            'nombre_organismo_externo',
            'fecha_inicio',
            'fecha_fin',
            'id_usuario'
        ];

    public function getProyectosById($id_usuario)
    {
        return $this->asArray()
            ->where(['id_usuario' => $id_usuario])
            ->findAll();
    }

}