<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id'; 
    protected $allowedFields = [
        "nombre",
        "apellido_paterno",
        "apellido_materno",
        "correo",
        "correo_adicional",
        "telefono",
        "contrasena",
        "id_campus",
        "rol",
        "matricula",
        "reset_token", 
        "reset_expiry",
        "slug"
       
    ];

    

    public function findByMatricula($matricula)
    {
        return $this->where('matricula', $matricula)->first();
    }

    public function findHoursById($id)
    {
        $db = db_connect();
        $query = $db->query('SELECT sum(capacitacion.duracion_horas) FROM capacitacion INNER JOIN usuario on id_usuario = usuario.id WHERE usuario.id = ' . $id);
        $result = $query->getResult();
        return $result;
    }

    public function findUserdByRol($rol)
    {
        return $this->asArray()->where(['rol' => $rol])->findAll();
    }

    public function search($query)
    {
        return $this->like('nombre', $query)->findAll();
    }

    public function find($id = null)
    {
        return $this->where('id', $id)->first();
    }
    
    public function getUsuarioData($id) {
        $this->select('usuario.*, datos_generales.*, domicilio.*, experiencia_laboral.*, experiencia_docente.*, proyecto.*, capacitacion.*, vinculacion.*, evento_academico.*, investigacion.*, asociacion_profesional.*, logro.*, premio.*');
        $this->join('datos_generales', 'datos_generales.id_usuario = usuario.id', 'left');
        $this->join('domicilio', 'domicilio.id_usuario = usuario.id', 'left');
        $this->join('experiencia_laboral', 'experiencia_laboral.id_usuario = usuario.id', 'left');
        $this->join('experiencia_docente', 'experiencia_docente.id_usuario = usuario.id', 'left');
        $this->join('proyecto', 'proyecto.id_usuario = usuario.id', 'left');
        $this->join('capacitacion', 'capacitacion.id_usuario = usuario.id', 'left');
        $this->join('vinculacion', 'vinculacion.id_usuario = usuario.id', 'left');
        $this->join('evento_academico', 'evento_academico.id_usuario = usuario.id', 'left');
        $this->join('investigacion', 'investigacion.id_usuario = usuario.id', 'left');
        $this->join('asociacion_profesional', 'asociacion_profesional.id_usuario = usuario.id', 'left');
        $this->join('logro', 'logro.id_usuario = usuario.id', 'left');
        $this->join('premio', 'premio.id_usuario = usuario.id', 'left');
        
        return $this->where('usuario.id', $id)->first();
    }
    public function getUserBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    // Generar un slug aleatorio único
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
