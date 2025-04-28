<?php

namespace App\Models;

use CodeIgniter\Model;

class CapacitacionModel extends Model
{

  protected $table = 'capacitacion';
  protected $primarykey = 'id';
  protected $allowedFields = [
    "titulo",
    "tipo",
    "lugar",
    "fecha_inicial",
    "fecha_final",
    "institucion",
    "modalidad",
    "duracion_horas",
    "nombre_instructor",
    "id_usuario",
    "evidencia",
    "estado",
    "rol",
    "motivo",
    "mostrar_cv",
    "slug"
    
  ];

  public function findCapacitacionesById($id)
  {

    return $this->asArray()->where(['id_usuario' => $id])->findAll();
  }

  public function findHoursById($id)
  {

    $db = db_connect();
    $query = $db->query('SELECT sum(duracion_horas) as "duracion_horas" , tipo FROM usuario INNER JOIN capacitacion on capacitacion.id_usuario= usuario.id WHERE usuario.id = ' . $id . ' AND capacitacion.estado = "Aceptado" group by capacitacion.tipo ');

    return $query->getResultArray();
  }
  public function updateMotivo($id, $motivo)
{
    $datos = [
        'motivo' => $motivo
    ];
    $this->db->table('capacitacion')->update($datos, ['id' => $id]);
}

public function deleteByUserId($id_usuario)
{
    return $this->where('id_usuario', $id_usuario)->delete();
}
public function generateUniqueSlug($length = 32)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $slug = '';
    
    for ($i = 0; $i < $length; $i++) {
        $slug .= $characters[rand(0, $charactersLength - 1)];
    }

    while ($this->where('slug', $slug)->first()) {
        $slug = '';
        for ($i = 0; $i < $length; $i++) {
            $slug .= $characters[rand(0, $charactersLength - 1)];
        }
    }

    return $slug;
}



}
