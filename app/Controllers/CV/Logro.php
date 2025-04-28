<?php

namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\Logros\LogroModel;
use App\Models\UsuarioModel;

class Logro extends BaseController{

private $LogroModel;
private $UsuarioModel;

public function __construct()
{
    $this->LogroModel = new LogroModel();
    $this->UsuarioModel = new UsuarioModel();
}

public function index(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if(isset($_SESSION['id'])){
        $id_usuario = $_SESSION['id'];
        $logros = $this->LogroModel->where('id_usuario', $id_usuario)->findAll();
        $data = [
            'logros' => $logros
        ];
        return view('Cvs/Logros/index', $data);
    }
}

public function save()
{
    // Obtener el ID de sesión
    $id = session()->get('id');
    if (empty($id)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
    }
    
    // Configuración de validación
    $validation = service('validation');    
    $validation->setRules([
        'descripcion' => 'required|max_length[255]',
        'tipo' => 'required'
    ],
    [
        'descripcion' => [
            'required' => 'El campo descripción es obligatorio',
            'max_length' => 'La descripción no puede superar los 255 caracteres'
        ],
        'tipo' => [
            'required' => 'El campo tipo es obligatorio',
        ]
    ]);

    // Ejecutar la validación
    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
    }

    $idLogro = $this->request->getPost('id_logro');
    $logro = [
        'id_usuario' => $id,
        'descripcion' => $this->request->getPost('descripcion'),
        'tipo' => $this->request->getPost('tipo')
    ];

    try {
        if ($idLogro) {
            $this->LogroModel->update($idLogro, $logro);
            $message = 'Logro actualizado correctamente';
        } else {
            $this->LogroModel->insert($logro);
            $message = 'Logro guardado correctamente';
        }
        
        return $this->response->setJSON(['success' => true, 'message' => $message]);
    } catch (\Exception $e) {
        return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar el logro: ' . $e->getMessage()]);
    }
}


public function delete($id){
    try{
      if($this->LogroModel->delete($id)){
            return $this->response->setJSON(['success' => true, 'message' => 'Logro eliminado correctamente']);
      }else{
            return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar el logro']);
      }

    }catch(\Exception $e){
        return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar el logro']);
    }
}
}
