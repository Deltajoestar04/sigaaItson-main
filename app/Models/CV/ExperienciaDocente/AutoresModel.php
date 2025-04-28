<?php

namespace App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class AutoresModel extends Model
{
    protected $table = 'investigacion_autores';
    protected $primaryKey = 'id';
    protected $allowedFields =
        [
        
            'nombre',
            'id_investigacion'
        ];

    public function findAutoresById($id)
    {
        return $this->asArray()->where(['id_investigacion' => $id])->findAll();
    }

}