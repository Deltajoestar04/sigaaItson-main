<?php

namespace App\Models\CV\DatosGenerales;

use CodeIgniter\Model;

class UbicacionModel extends Model
{

    protected $table = 'ubicacion';
    protected $primaryKey = 'id';
    protected $allowedFields = [

        'estado',
        'ciudad',
        'pais',
        'codigo_postal'
    ];

    public function findUbicacionById($idUbicacion)
    {
        return $this->asArray()->where(['id' => $idUbicacion])->first();
    }



}