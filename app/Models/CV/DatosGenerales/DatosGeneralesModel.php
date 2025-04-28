<?php 

namespace App\Models\CV\DatosGenerales;

use CodeIgniter\Model;

class DatosGeneralesModel extends Model{

    protected $table = 'datos_generales';
    protected $primaryKey = 'id';
    protected $allowedFields = [

        'fecha_nacimiento',
        'edad',
        'genero',
        'no_celular',
        'foto_personal',
        'id_usuario'
    ];

    public function findDatosGeneralesById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->first();
    }

    public function deleteByUserId($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->delete();
    }

}