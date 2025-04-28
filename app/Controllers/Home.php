<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CampusModel;

class Home extends BaseController
{
  private $UsuarioModel;
  private $CampusModel;
  function __construct()
  {
    $session = session();
    $_SESSION["menu"] = false;
    $this->CampusModel = new CampusModel();
  }
  public function proximo()
  {

    return view('Home/trabajando');
  }
  public function reporte()
  {

    return view('Home/power');
  }
  public function index()
  {
    return view('Home/login');
  }
  public function success()
  {
    return view('Home/success');
  }
  public function menu()
  {
    return view('Home/menu');
  }

  public function iniciarSesion()
{
    $validation = \Config\Services::validation();
    $validation->setRules(
        [
            'matricula' => 'required|numeric|is_not_unique[usuario.matricula]',
            'password' => 'required'
        ],
        [   // Mensajes personalizados
            'matricula' => [
                'required' => 'El campo matrícula es obligatorio.',
                'numeric' => 'El campo matrícula debe contener solo números.',
                'is_not_unique' => 'La matrícula no existe en nuestra base de datos.'
            ],
            'password' => [
                'required' => 'El campo contraseña es obligatorio.'
            ]
        ]
    );

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $matricula = $this->request->getPost("matricula");
    $password = $this->request->getPost("password");
    $UsuarioModel = new UsuarioModel();
    $datosUsuario = $UsuarioModel->where('matricula', $matricula)->first();

    if ($datosUsuario) {
        if (password_verify($password, $datosUsuario['contrasena'])) {
            if ($datosUsuario['id'] > 0) {
                $data = [
                    "id" => $datosUsuario['id'],
                    "nombre" => $datosUsuario['nombre'],
                    "correo" => $datosUsuario['correo'],
                    "correo_adicional" => $datosUsuario['correo_adicional'],
                    "telefono" => $datosUsuario['telefono'],
                    "id_campus" => $datosUsuario['id_campus'],
                    "rol" => $datosUsuario['rol'],
                    "matricula" => $datosUsuario['matricula'],
                    "slug" => $datosUsuario['slug']
                ];

                $session = session();
                $session->set($data);

                return redirect()->to('/menu');
            }
        } else {
            return redirect()->back()->withInput()->with('errors', ['password' => 'La contraseña es incorrecta.']);
        }
    } else {
        return redirect()->back()->withInput()->with('errors', ['matricula' => 'La matrícula no existe en nuestra base de datos.']);
    }
}


  public function registro()
  {
    $campus = $this->CampusModel->findAll();
    $data = [
        'campus' => $campus
    ];
    return view('/Home/registrar', $data);
  }


  public function logout()
  {
      $session = session();
      $session->destroy();
      return redirect()->to('/?logout=true');
  }
}
