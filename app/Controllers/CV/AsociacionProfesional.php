<?php
namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\AsociacionProfesional\AsociacionProfesionalModel;

use App\Models\UsuarioModel;

class AsociacionProfesional extends BaseController
{
    protected $AsociacionProfesionalModel;
    protected $UsuarioModel;

    public function __construct()
    {
        $this->AsociacionProfesionalModel = new AsociacionProfesionalModel();
        $this->UsuarioModel = new UsuarioModel();
    }

    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['id'])) {
            $id_usuario = $_SESSION['id'];
            $asociaciones = $this->AsociacionProfesionalModel->where('id_usuario', $id_usuario)->findAll();
            $data = [
                'asociaciones' => $asociaciones
            ];
            return view('Cvs/AsociacionesProfesionales/index', $data);
        } else {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión para ver sus asociaciones profesionales.');
        }
    }

    public function save()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No se ha iniciado sesión']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'nombre' => 'required',
                'tipo' => 'required',
                'fecha_inicio' => 'required',
                'fecha_final' => 'required'
            ],
            [
                'nombre' => [
                    'required' => 'El nombre es requerido'
                ],
                'tipo' => [
                    'required' => 'El tipo es requerido'
                ],
                'fecha_inicio' => [
                    'required' => 'La fecha de inicio es requerida'
                ],
                'fecha_final' => [
                    'required' => 'La fecha de final es requerida'
                ]
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $idAsociacion = esc($this->request->getPost('id_asociacion_profesional'));

        $asociacionData = [
            'id_usuario' => $id,
            'nombre' => esc($this->request->getPost('nombre')),
            'tipo' => esc($this->request->getPost('tipo')),
            'fecha_inicio' => esc($this->request->getPost('fecha_inicio')),
            'fecha_final' => esc($this->request->getPost('fecha_final')),
        ];

        try {
            if ($idAsociacion) {
                $this->AsociacionProfesionalModel->update($idAsociacion, $asociacionData);
                $message = 'Asociación profesional actualizada correctamente';
            } else {
                $this->AsociacionProfesionalModel->insert($asociacionData);
                $message = 'Asociación profesional guardada correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar la asociación profesional: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al guardar la asociación profesional']);
        }
        
    }


    public function delete($id)
    {
        try {
            $this->AsociacionProfesionalModel->delete($id);
            return $this->response->setJSON(['success' => true, 'message' => 'Asociación profesional eliminada correctamente']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al eliminar la asociación profesional']);
        }
    }


}
