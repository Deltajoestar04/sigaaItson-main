<?php

namespace App\Models\CV\Logros;

use CodeIgniter\Model;

class LogroModel extends Model
{
    protected $table = 'logro';
    protected $primaryKey = 'id';
    protected $allowedFields =
        [
            'id_usuario',
            'tipo',
            'descripcion'
        ];

    public function findLogroById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }

}