<?php 

namespace App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class VinculacionModel extends Model
{
    protected $table      = 'vinculacion';
    protected $primaryKey = 'id';


    protected $allowedFields = ['id_usuario', 
    'id_docente', 
    'patente',
    'convenio_industrial',
    'servicio_industrial'
];


public function getVinculacionById($id_usuario)
{
    return $this->asArray()
        ->where(['id_usuario' => $id_usuario])
        ->findAll();
}

}