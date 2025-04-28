<?php 

namespace App\Models\CV\ExperienciaDocente;

use CodeIgniter\Model;

class InvestigacionModel extends Model
{
    protected $AutoresModel;

    protected $table = 'investigacion';
    protected $primaryKey = 'id';
    protected $allowedFields =
        [
            'id_usuario',
            'titulo',
            'anio',
            'fuente',
            'url_doi',
            'editorial',
            'indiz',
            'tipo'
        ];
        public function __construct()
        {
            parent::__construct();
            $this->AutoresModel = new \App\Models\CV\ExperienciaDocente\AutoresModel();
        }
        public function findInvestigacionWithAuthorsById($id)
        {
            $investigations = $this->asArray()->where(['id_usuario' => $id])->findAll();
            
            $autoresModel = new AutoresModel();
            
            foreach ($investigations as &$investigation) {
                $investigation['autores'] = $autoresModel->findAutoresById($investigation['id']);
            }
            
            return $investigations;
        }
        public function saveInvestigacionWithAutores($investigacionData, $autores, $idInvestigacion = null)
        {
            $db = \Config\Database::connect();
            $db->transStart();
        
            try {
                if ($idInvestigacion) {
                 
                    $this->update($idInvestigacion, $investigacionData);
        
                    $existingAutores = $this->AutoresModel->where('id_investigacion', $idInvestigacion)->findAll();
        
                    // Crea un array con los IDs de los autores existentes y sus nombres
                    $existingAutorNames = array_column($existingAutores, 'nombre');
                    $existingAutorIds = array_column($existingAutores, 'id');
        
                    // Identifica los nombres de autores a eliminar
                    $authorsToDelete = array_diff($existingAutorNames, $autores);
                    
                    // Identifica los nuevos autores a agregar
                    $newAutores = array_diff($autores, $existingAutorNames);
        
                    // Elimina los autores que ya no están en la lista
                    if (!empty($authorsToDelete)) {
                        $this->AutoresModel->where('id_investigacion', $idInvestigacion)
                                           ->whereIn('nombre', $authorsToDelete)
                                           ->delete();
                    }
        
                    // Inserta los nuevos autores
                    foreach ($newAutores as $newAutor) {
                        if (!empty($newAutor)) {
                            $this->AutoresModel->insert([
                                'nombre' => $newAutor,
                                'id_investigacion' => $idInvestigacion
                            ]);
                        }
                    }
        
                    $message = 'Investigación actualizada correctamente';
                } else {
                    // Inserta una nueva investigación
                    $idInvestigacion = $this->insert($investigacionData);
        
                    // Inserta los autores asociados a la nueva investigación
                    foreach ($autores as $autor) {
                        if (!empty($autor)) {
                            $this->AutoresModel->insert([
                                'nombre' => $autor,
                                'id_investigacion' => $idInvestigacion
                            ]);
                        }
                    }
        
                    $message = 'Investigación guardada correctamente';
                }
        
                $db->transComplete();
        
                if ($db->transStatus() === false) {
                    throw new \Exception('Error en la transacción de la base de datos');
                }
        
                return ['success' => true, 'message' => $message];
            } catch (\Exception $e) {
                $db->transRollback();
                log_message('error', $e->getMessage());
                return ['success' => false, 'message' => 'Ocurrió un error al guardar la investigación: ' . $e->getMessage()];
            }
        }
        
        
        
}

