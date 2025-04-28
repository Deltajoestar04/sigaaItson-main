<?php  

namespace App\Models\CV\DatosGenerales;

use CodeIgniter\Model;

class DomicilioModel extends Model{

    protected $table = 'domicilio';
    protected $primaryKey = 'id';
    protected $allowedFields = [

        'calle',
        'no_exterior',
        'no_interior',
        'colonia',
        'id_usuario',
        'id_ubicacion'
    ];

public function findDomiciliosByIdUsuario($id)
{
    return $this->where('id_usuario', $id)->findAll();
}
    public function deleteByUserId($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->delete();
    }

    public function findDomicilioById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }
}