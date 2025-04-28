<?php 

namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\ExperienciaLaboral\ExperienciaLaboralModel;
use App\Models\UsuarioModel;

class ExperienciaLaboral extends BaseController
{
    private $ExperienciaLaboralModel;
    private $UsuarioModel;

    public function __construct()
    {
        $this->ExperienciaLaboralModel = new ExperienciaLaboralModel();
        $this->UsuarioModel = new UsuarioModel();
    }
//Metodo para mostrar la vista de experiencias laborales
    public function index()
    {
        $id = session()->get('id');

        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        if(isset($_SESSION['id'])){
            $id_usuario = $_SESSION['id'];
            $experiencias = $this->ExperienciaLaboralModel->where('id_usuario', $id_usuario)->findAll();
            $data = [
                'experiencias' => $experiencias
            ];
            return view('Cvs/ExperienciasLaborales/index', $data);
        }
    }

    public function save()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }
    
        $validation = \Config\Services::validation();
        $validation->setRules(
            [
            'empresa' => 'required|string|max_length[100]',
            'actividad_puesto' => 'required|string|max_length[100]',
            'mes_inicio' => 'required',
            'anio_inicio' => 'required',
            'mes_fin' => 'permit_empty',
            'anio_fin' => 'permit_empty',
            'actualmente' => 'permit_empty|in_list[0,1]'
        ],
        [
            'empresa' => [
                'required' => 'El campo empresa es obligatorio',
                'string' => 'El campo empresa debe ser una cadena de texto',
                'max_length' => 'El campo empresa no debe exceder 100 caracteres'
            ],
            'actividad_puesto' => [
                'required' => 'El campo actividad/puesto es obligatorio',
                'string' => 'El campo actividad/puesto debe ser una cadena de texto',
                'max_length' => 'El campo actividad/puesto no debe exceder 100 caracteres'
            ],
            'mes_inicio' => [
                'required' => 'El campo mes de inicio es obligatorio',
            ],
            'anio_inicio' => [
                'required' => 'El campo año de inicio es obligatorio',
            ],
            'mes_fin' => [
                'permit_empty' => 'El campo mes de fin es obligatorio',
            ],
            'anio_fin' => [
                'permit_empty' => 'El campo año de fin es obligatorio',
            ],
            'actualmente' => [
                'in_list' => 'El campo actualmente debe ser 0 o 1'
            ]
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
      
        $idExperiencia = $this->request->getPost('id_experiencia_laboral');
    
        $data = [
            'id_usuario' => $id,
            'empresa' => $this->request->getPost('empresa'),
            'actividad_puesto' => $this->request->getPost('actividad_puesto'),
            'mes_inicio' => $this->request->getPost('mes_inicio'),
            'anio_inicio' => $this->request->getPost('anio_inicio'),
            'actualmente' => $this->request->getPost('actualmente') == '1' ? 1 : 0
        ];
    
        if ($data['actualmente'] == 0) {
            $data['mes_fin'] = $this->request->getPost('mes_fin');
            $data['anio_fin'] = $this->request->getPost('anio_fin');
        } else {
            $data['mes_fin'] = null;
            $data['anio_fin'] = null;
        }
    
        try {
            if ($idExperiencia) {
                $this->ExperienciaLaboralModel->update($idExperiencia, $data);
                $message = 'Experiencia laboral editada correctamente';
            } else {
                $this->ExperienciaLaboralModel->insert($data);
                $message = 'Experiencia laboral guardada correctamente';
            }
    
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error durante la actualización: ' . $e->getMessage()]);
        }
    }
    

    public function delete($id)
{
    try {
        if ($this->ExperienciaLaboralModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Experiencia laboral eliminada correctamente']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo eliminar la experiencia laboral']);
        }
    } catch (\Exception $e) {
        return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al eliminar la experiencia laboral: ' . $e->getMessage()]);
    }
}

    }
