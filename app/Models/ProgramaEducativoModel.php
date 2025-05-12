<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramaEducativoModel extends Model
{
    protected $table = 'programa_educativo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre']; 

    public function obtenerTodos()
    {
        return $this->findAll();
    }
}
