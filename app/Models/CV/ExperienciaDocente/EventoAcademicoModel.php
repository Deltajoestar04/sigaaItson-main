<?php 

namespace   App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class EventoAcademicoModel extends Model
{
    protected $table      = 'evento_academico';
        protected $primaryKey = 'id';

        protected $allowedFields = ['id_usuario',
        'nombre_ponencia',
        'nombre_evento',
        'lugar',
        'fecha',
        'pais'
];

public function getEventoAcademicoById($id_usuario)
{
    return $this->asArray()
        ->where(['id_usuario' => $id_usuario])
        ->findAll();

}
}