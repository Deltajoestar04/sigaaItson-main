<?php

namespace App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class DocenciaModel extends Model
{

    protected $table = 'docencia';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_usuario',
        'libro',
        'manual_practica',
        'material_didactico'
    ];

    public function getDocenciaById($id_usuario)
    {
        return $this->asArray()
            ->where(['id_usuario' => $id_usuario])
            ->findAll();
    }

}