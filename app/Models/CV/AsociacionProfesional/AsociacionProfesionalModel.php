<?php
namespace App\Models\CV\AsociacionProfesional;

use CodeIgniter\Model;

class AsociacionProfesionalModel extends Model
{
    protected $table = 'asociacion_profesional';
    protected $primaryKey = 'id';

    protected $allowedFields
        = [
            "id",
            "id_usuario",
            "nombre",
            "tipo",
            "fecha_inicio",
            "fecha_final",
        ];

    public function findAsociacionesProfesionalesById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }

}