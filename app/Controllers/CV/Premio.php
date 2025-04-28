<?php
namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\Premios\PremioModel;
use App\Models\UsuarioModel;

class Premio extends BaseController
{
    protected $premioModel;
    protected $usuarioModel;

    public function __construct() {
        $this->premioModel = new PremioModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index() {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['id'])) {
            $id_usuario = $_SESSION['id'];
            $premios = $this->premioModel->where('id_usuario', $id_usuario)->findAll();
            $data = [
                'premios' => $premios
            ];
            return view('Cvs/Premios/index', $data);
        } else {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión para ver sus premios.');
        }
    }

    public function save() {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success'=> false, 'message' => 'No se ha iniciado sesión']);
        }
    
        $validation = service('validation');
        $validation->setRules([
            'anio' => 'required',
            'descripcion' => 'required',
            'organismo' => 'required',
            'pais' => 'required'
        ],
        [
            'anio' => [
                'required' => 'El año es requerido'
            ],
            'descripcion' => [
                'required' => 'La descripción es requerida'
            ],
            'organismo' => [
                'required' => 'El organismo es requerido'
            ],
            'pais' => [
                'required' => 'El país es requerido'
            ]
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success'=> false, 'errors' => $validation->getErrors()]);
        }
    
        $idPremio = $this->request->getPost('id_premio');
    
        $premio = [
            'id_usuario' => $id,
            'anio' => $this->request->getPost('anio'),
            'descripcion' => $this->request->getPost('descripcion'),
            'organismo' => $this->request->getPost('organismo'),
            'pais' => $this->request->getPost('pais')
        ];
    
        try {
            if ($idPremio) {
                $this->premioModel->update($idPremio, $premio);
                return $this->response->setJSON(['success'=> true, 'message' => 'Premio actualizado correctamente']);
            } else {
                $this->premioModel->insert($premio);
                return $this->response->setJSON(['success'=> true, 'message' => 'Premio guardado correctamente']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success'=> false, 'message' => 'Error al guardar el premio: ' . $e->getMessage()]);
        }
    }
    

    public function delete($id) {
       
        try{
            if($this->premioModel->delete($id)){
                return $this->response->setJSON(['success'=> true, 'message' => 'Premio eliminado correctamente']);
            }else{
                return $this->response->setJSON(['success'=> false, 'message' => 'No se pudo eliminar el premio']);
            }
        }catch (\Exception $e){
            return $this->response->setJSON(['success'=> false, 'message' => 'Error al eliminar el premio']);
        }
   
     
    }
}
