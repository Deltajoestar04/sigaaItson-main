<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface as ConnectionInterfaceAlias;       
use CodeIgniter\Database\BaseConnection as BaseConnectionAlias;
use CodeIgniter\Database\ResultInterface;
use CodeIgniter\Database\ResultInterface as ResultInterfaceAlias;
 


class IndicadorModel extends Model
{
    protected $table = 'Indicador_tb';
    protected $DBGroup = 'default';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_usuario',
        'Indicador',
        'Resultado',
        'Comentarios',
        'Objetivo',
        'Descripcion',
        'Cant_min',
        'Total',
        'Meta',
        'Acciones'
    ];

    protected $validationRules = [
        'id_usuario'  => 'required|is_natural_no_zero',
        'Indicador'   => 'required|min_length[3]',
        'Resultado'   => 'permit_empty|max_length[100]',
        'Comentarios' => 'permit_empty',
        'Objetivo'    => 'permit_empty',
        'Descripcion' => 'permit_empty',
        'Cant_min'    => 'permit_empty|integer',
        'Total'       => 'permit_empty|integer',
        'Meta'        => 'permit_empty|max_length[100]',
        'Acciones'    => 'permit_empty'
    ];

    public function findIndicadoresPorUsuario($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->findAll();
    }
}
