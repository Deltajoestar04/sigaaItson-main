<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\IndicadorModel;
use CodeIgniter\Controller;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);;

use CodeIgniter\HTTP\RequestInterface;

class Indicador extends Controller
{
    protected $usuarioModel;
    protected $indicadorModel;
    protected $request;

    public function __construct()
    {
        helper(['form']);
        $this->usuarioModel = new UsuarioModel();
       // $this->indicadorModel = new IndicadorModel();
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

        // Definir menú activo
        $session->set([
            'menu' => true,
            'menu_indicador' => true,
            'menu_usuario' => false,
            'menu_rol' => false,
            'menu_rol_usuario' => false,
        ]);

        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to(base_url('/login'))->with('error', 'Usuario no encontrado');
        }

        //$indicadores = $this->indicadorModel->findIndicadoresPorUsuario($id) ?? [];

        $data = [
            'usuario' => $usuario,
            //'Indicador' => $indicadores,
            'id_usuario' => $id_usuario,
            'id_rol' => $id_rol,
            'id' => $id,
            'menu' => $session->get('menu'),
            'menu_indicador' => $session->get('menu_indicador'),
            'menu_usuario' => $session->get('menu_usuario'),
            'menu_rol' => $session->get('menu_rol'),
            'menu_rol_usuario' => $session->get('menu_rol_usuario'),
        ];

        return view('Indicador/index', $data);
    }

    public function guardar()
    {
        $session = session();
        $id_usuario = $session->get('id');

        if (!$id_usuario) {
            return redirect()->to(base_url('/login'))->with('error', 'Sesión no válida');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'Indicador'   => 'required|min_length[3]|max_length[255]',
            'Resultado'   => 'required|max_length[100]',
            'Comentarios' => 'required|max_length[500]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        $data = [
            'Indicador'   => $this->request->getPost('Indicador'),
            'Resultado'   => $this->request->getPost('Resultado'),
            'Comentarios' => $this->request->getPost('Comentarios'),
            'id_usuario'  => $id_usuario,
        ];

        $id_indicador = $this->request->getPost('id_indicador');

        if ($id_indicador) {
            $this->indicadorModel->actualizarIndicador($id_indicador, $data);
        } else {
            $this->indicadorModel->guardarIndicador($data);
        }

        return redirect()->to(base_url('/Indicador'))->with('success', 'Indicador guardado correctamente');
    }

    public function eliminar($id = null)
    {
        $session = session();
        $id_usuario = $session->get('id');

        if (!$id_usuario) {
            return redirect()->to(base_url('/login'))->with('error', 'Sesión no válida');
        }

        if ($id) {
            $this->indicadorModel->eliminarIndicador($id);
        }

        return redirect()->to(base_url('/Indicador'))->with('success', 'Indicador eliminado correctamente');
    }
    
}


