<?php
namespace App\Models\CV\Premios;

use CodeIgniter\Model;

class PremioModel extends Model
{
    protected $table = 'premio';
    protected $primaryKey = 'id';

    protected $allowedFields
        = [
            "id",
            "id_usuario",
            "anio",
            "descripcion",
            "organismo",
            "pais"
        ];

    public function findPremiosById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }

}