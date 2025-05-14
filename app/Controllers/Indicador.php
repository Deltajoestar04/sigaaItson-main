<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\IndicadorModel;
use App\Models\ProgramaEducativoModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Indicador extends BaseController
{
    protected $usuarioModel;
    protected $indicadorModel;
    protected $programaModel;
    protected $request;

    public function __construct()
    {
        helper(['form']);
        $this->usuarioModel = new UsuarioModel();
        $this->indicadorModel = new IndicadorModel();
        $this->programaModel = new ProgramaEducativoModel();
        $this->request = \Config\Services::request();
    }

    public function index()
    {
        $session = session();
        $id = $session->get('id');
        $id_usuario = $session->get('id_usuario');
        $id_rol = $session->get('id_rol');
    
        if (!$id) {
            return redirect()->to(base_url('/login'))->with('error', 'Sesión no válida');
        }
    
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to(base_url('/login'))->with('error', 'Usuario no encontrado');
        }
    
        $prog_edu_id = $this->request->getVar('prog_edu_id');
    
        if ($prog_edu_id) {
            $indicadores = $this->indicadorModel->obtenerPorPrograma($prog_edu_id, $id_usuario);
        } else {
            $indicadores = $this->indicadorModel->findIndicadoresPorUsuario($id_usuario);
        }
    
        $programas = $this->programaModel->obtenerTodos();
    
        // Definir menú activo
        $session->set([
            'menu' => true,
            'menu_indicador' => true,
            'menu_usuario' => false,
            'menu_rol' => false,
            'menu_rol_usuario' => false,
        ]);
    
        $data = [
            'usuario' => $usuario,
            'indicadores' => $indicadores,
            'id_usuario' => $id_usuario,
            'id_rol' => $id_rol,
            'id' => $id,
            'menu' => $session->get('menu'),
            'menu_indicador' => $session->get('menu_indicador'),
            'menu_usuario' => $session->get('menu_usuario'),
            'menu_rol' => $session->get('menu_rol'),
            'menu_rol_usuario' => $session->get('menu_rol_usuario'),
            'programas' => $programas,
        ];

        return view('Indicador/index', $data);
    }
   
    
   
   public function guardar()
{
    $session = session();
    
    // Verificar sesión primero
    if (!$session->has('id')) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Sesión no válida'
        ]);
    }

    // Obtener id_usuario de la sesión
    $id_usuario = $session->get('id_usuario') ?? $session->get('id');
    
    if (!$id_usuario) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Usuario no autenticado'
        ]);
    }

    // Validación
    $rules = [
        'obj_particular' => 'permit_empty',
        'descripcion' => 'permit_empty',
        'cant_minima' => 'permit_empty|numeric',
        'total_obtenido' => 'permit_empty|numeric',
        'meta' => 'permit_empty|numeric',
        'prog_edu_id' => 'permit_empty|numeric'
    ];

    if (!$this->validate($rules)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Datos inválidos',
            'errors' => $this->validator->getErrors()
        ]);
    }

   

    // Calcular resultado
    $cant_minima = (float)$this->request->getPost('cant_minima');
    $total_obtenido = (float)$this->request->getPost('total_obtenido');
    $resultado = ($cant_minima > 0) ? ($total_obtenido / $cant_minima) * 100 : 0;

    $data = [
        'id_usuario' => $id_usuario,
        'obj_particular' => $this->request->getPost('obj_particular'),
        'descripcion' => $this->request->getPost('descripcion'),
        'prog_edu_id' => $this->request->getPost('prog_edu_id'),
        'cant_minima' => $cant_minima,
        'total_obtenido' => $total_obtenido,
        'meta' => $this->request->getPost('meta'),
        'resultado' => $resultado,
        'indicador' => $this->request->getPost('indicador'),
        'comentarios' => $this->request->getPost('comentarios'),
        'estrategias_semaforo_verde' => $this->request->getPost('estrategias_semaforo_verde'),
    ];

    if ($this->indicadorModel->save($data)) {
        return $this->response->setJSON([
            'status' => 'ok',
            'message' => 'Indicador guardado correctamente',
            'id' => $this->indicadorModel->getInsertID()
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Error al guardar el indicador',
            'errors' => $this->indicadorModel->errors()
        ]);
    }
}

public function checkSession()
{
    $session = session();
    return $this->response->setJSON([
        'valid' => $session->has('id'),
        'id_usuario' => $session->get('id_usuario') ?? $session->get('id')
    ]);
}
    
    /*public function guardarIndicador()
    {
        $data = $this->input->post();
    
        // Asegúrate de que los datos sean válidos antes de insertarlos
        if (empty($data['obj_particular']) || empty($data['descripcion']) || empty($data['cant_minima']) || empty($data['total_obtenido'])) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
            return;
        }
    
        // Insertar en la base de datos
        $indicadorData = [
            'obj_particular' => $data['obj_particular'],
            'descripcion' => $data['descripcion'],
            'cant_minima' => $data['cant_minima'],
            'total_obtenido' => $data['total_obtenido'],
            'meta' => $data['meta'],
            'resultado' => $data['resultado'],
            'indicador' => $data['indicador'],
            'comentarios' => $data['comentarios'],
            'estrategias_semaforo_verde' => $data['estrategias_semaforo_verde'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    
        // Insertar el nuevo indicador
        $this->db->insert('indicador_tb', $indicadorData);
    
        // Responder con éxito
        echo json_encode(['status' => 'ok']);
    }*/
    
    
    

    public function eliminar($id = null)
    {
        $session = session();
        $id_usuario = $session->get('id_usuario');
        $id_rol = $session->get('id_rol');


        if (!$id_usuario) {
            return redirect()->to(base_url('/login'))->with('error', 'Sesión no válida');
        }

        if ($id) {
            $this->indicadorModel->delete($id);
        }

        return redirect()->to(base_url('/Indicador'))->with('success', 'Indicador eliminado correctamente');
    }

    public function obtenerIndicadoresPorPrograma()
    {
        $prog_edu_id = $this->request->getGet('prog_edu_id');
        $session = session();
        $id_usuario = $session->get('id');
    
        if (!$prog_edu_id || !$id_usuario) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Parámetros faltantes']);
        }
    
        $indicadores = $this->indicadorModel->obtenerPorPrograma($prog_edu_id, $id_usuario);
    
        return $this->response->setJSON($indicadores);
    }

    public function actualizar()
{
    $data = $this->request->getJSON(true);

    if (!$data || !isset($data['id']) || !isset($data['campo']) || !isset($data['valor'])) {
        return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
    }

    $id = $data['id'];
    $campo = $data['campo'];
    $valor = $data['valor'];

    // Validar que el campo esté permitido
    $camposPermitidos = ['meta', 'anio', 'observaciones'];
    if (!in_array($campo, $camposPermitidos)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Campo no permitido']);
    }

    $model = new IndicadorModel();
    $updated = $model->update($id, [$campo => $valor]);

    if ($updated) {
        return $this->response->setJSON(['success' => true, 'message' => 'Actualizado']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar']);
    }
}


    public function editarCampo()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getJSON(true);
            $id = $data['id'] ?? null;
            $campo = $data['campo'] ?? null;
            $valor = $data['valor'] ?? null;
    
            // Lista blanca de campos editables
            $camposPermitidos = [
                'descripcion',
                'cant_minima',
                'total_obtenido',
                'meta',
                'indicador',
                'comentarios',
                'estrategias_semaforo_verde',
                'obj_particular'
            ];
    
            if (!$id || !$campo || $valor === null) {
                return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
            }
    
            if (!in_array($campo, $camposPermitidos)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Campo no permitido']);
            }
    
            if ($this->indicadorModel->update($id, [$campo => $valor])) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar']);
            }
        }
    
        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
}
