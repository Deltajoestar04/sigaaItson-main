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
        
        if (!$session->has('id')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sesión no válida'
            ]);
        }

        $id_usuario = $session->get('id_usuario') ?? $session->get('id');
        
        if (!$id_usuario) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuario no autenticado'
            ]);
        }

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

    public function eliminar($id)
    {
        $session = session();
        
        if (!$session->has('id')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sesión no válida'
            ]);
        }

        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Solicitud no válida'
            ]);
        }

        $indicador = $this->indicadorModel->find($id);
        $id_usuario = $session->get('id_usuario') ?? $session->get('id');
        
        if (!$indicador || $indicador['id_usuario'] != $id_usuario) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Indicador no encontrado o no tienes permisos'
            ]);
        }

        try {
            if ($this->indicadorModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'ok',
                    'message' => 'Indicador eliminado correctamente'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al eliminar el indicador: ' . $e->getMessage()
            ]);

            return rederict()->back ->with('error', 'Error al eliminar el indicador: ' . $e->getMessage());
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

    public function editarCampo()
{
    if ($this->request->isAJAX()) {
        $data = $this->request->getJSON(true);
        $id = $data['id'] ?? null;
        $campo = $data['campo'] ?? null;
        $valor = $data['valor'] ?? null;

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

        // Obtener el indicador actual
        $indicador = $this->indicadorModel->find($id);
        if (!$indicador) {
            return $this->response->setJSON(['success' => false, 'message' => 'Indicador no encontrado']);
        }

        $updateData = [$campo => $valor];
        
        // Si se edita cant_minima o total_obtenido, recalcular resultado
        if ($campo === 'cant_minima' || $campo === 'total_obtenido') {
            $cant_minima = $campo === 'cant_minima' ? $valor : $indicador['cant_minima'];
            $total_obtenido = $campo === 'total_obtenido' ? $valor : $indicador['total_obtenido'];
            $resultado = ($cant_minima > 0) ? ($total_obtenido / $cant_minima) * 100 : 0;
            $updateData['resultado'] = $resultado;
        }

        if ($this->indicadorModel->update($id, $updateData)) {
            $response = ['success' => true];
            
            // Si se calculó un nuevo resultado, devolverlo formateado
            if (isset($resultado)) {
                $formattedResult = $resultado % 1 === 0 ? $resultado : number_format($resultado, 2);
                $response['resultado'] = $formattedResult . '%';
            }
            
            return $this->response->setJSON($response);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar']);
        }
    }

    throw new \CodeIgniter\Exceptions\PageNotFoundException();
}
}