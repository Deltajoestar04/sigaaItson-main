<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CapacitacionModel;
use App\Models\CV\DatosGenerales\DatosGeneralesModel;
use App\Models\CV\DatosGenerales\DomicilioModel;
use App\Models\CampusModel;
use Exception;

class Usuario extends BaseController
{
  protected $helpers = ['form'];
  private $UsuarioModel;
  private $CapacitacionModel;
  private $DatosGeneralesModel;
  private $DomicilioModel;

  private $CampusModel;
  function __construct()
  {
    $session = session();
    $_SESSION["menu"] = true;
    $this->UsuarioModel = new UsuarioModel();
    $this->CapacitacionModel = new CapacitacionModel();
    $this->DatosGeneralesModel = new DatosGeneralesModel();
    $this->DomicilioModel = new DomicilioModel();
    $this->CampusModel = new CampusModel();
  }
  public function index()
  {
      $rol = "Maestro";
      $estadoCapacitacionSeleccionado = $this->request->getGet('estado_capacitacion') ?? 'Todos';
  
      $usuarios = $this->UsuarioModel->findUserdByRol($rol);
      $estadosCapacitacion = ['Todos', 'Terminado', 'En Proceso', 'Sin Revisar', 'Sin Envio'];
      $campus = $this->CampusModel->findAll();
  
      $ordenEstados = [
          'Terminado' => 1,
          'En Proceso' => 2,
          'Sin Revisar' => 3,
          'Sin Envio' => 4
      ];
  
      foreach ($usuarios as &$usuario) {
          $capacitaciones = $this->CapacitacionModel->findCapacitacionesById($usuario['id']);
          $estadoCapacitacion = $this->getStatus($capacitaciones);
          $usuario['estadoCapacitacion'] = $estadoCapacitacion['status'];
          $usuario['iconoEstado'] = $estadoCapacitacion['icon'];
          $usuario['ordenEstado'] = $ordenEstados[$estadoCapacitacion['status']];
      }
  
      $data = [
          "usuarios" => $usuarios,
          "estadosCapacitacion" => $estadosCapacitacion,
          "estadoCapacitacionSeleccionado" => $estadoCapacitacionSeleccionado,
          "campus" => $campus
      ];
  
      return view('Usuarios/index', $data);
  }
  
  //Función para guardar un usuario
  public function save()
  {
  

    $slug = $this->UsuarioModel->generateUniqueSlug();
    // Validación de los campos
    $validation = service('validation');
    $validation->setRules([
      'nombre' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
      'apellido_paterno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
      'apellido_materno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
      'correo' => 'required|is_unique[usuario.correo]|valid_email',
      'telefono' => 'permit_empty|is_unique[usuario.telefono]|numeric|min_length[10]',
      'contrasena' => 'required|min_length[8]',
      'confirmar_contrasena' => 'required|min_length[8]|matches[contrasena]',
      'id_campus' => 'required',
      'rol' => 'required',
      'matricula' => 'required|is_unique[usuario.matricula]|numeric|exact_length[11]',
    ], [
      // Mensajes de error
      'nombre' => [
        'required' => 'El campo nombre es requerido',
        'regex_match' => 'El campo nombre solo puede contener letras y espacios'
      ],
      'apellido_paterno' => [
        'required' => 'El campo apellido paterno es requerido',
        'regex_match' => 'El campo apellido paterno solo puede contener letras y espacios'
      ],
      'apellido_materno' => [
        'required' => 'El campo apellido materno es requerido',
        'regex_match' => 'El campo apellido materno solo puede contener letras y espacios'
      ],
      'correo' => [
        'required' => "El correo es requerido",
        'is_unique' => "El correo debe ser único",
        'valid_email' => "El campo de correo debe de ser llenado con un correo válido",
      ],
      'telefono' => [
        'is_unique' => "El número telefónico debe ser único",
        'numeric' => "El campo de teléfono sólo puede tener números",
        'min_length[10]' => "El número telefónico debe de tener un mínimo de 10 caracteres",
      ],
      'contrasena' => [
        'required' => "La contraseña es obligatoria",
        'min_length' => "La contraseña tiene que tener un mínimo de 8 caracteres",
      ],
      'confirmar_contrasena' => [
        'required' => "La contraseña es obligatoria",
        'min_length[8]' => "La contraseña tiene un mínimo de 8 caracteres",
        'matches' => "Las contraseñas no coinciden"
      ],
      'id_campus' => [
        'required' => "El campus es requerido",
      ],
      'rol' => [
        'required' => "El campo de rol es requerido",
      ],
      'matricula' => [
        'required' => "El campo de matrícula es requerido",
        'is_unique' => "ID existente",
        'numeric' => "El campo de matrícula sólo puede tener números",
        'exact_length' => "La matrícula debe tener exactamente 11 caracteres",
      ],
    ]);

    if (!$validation->withRequest($this->request)->run()) {
      return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }


    try {
      $usuarioData = [
        'nombre' => $this->request->getPost("nombre"),
        'apellido_paterno' => $this->request->getPost("apellido_paterno"),
        'apellido_materno' => $this->request->getPost("apellido_materno"),
        'correo' => $this->request->getPost("correo"),
        'telefono' => $this->request->getPost("telefono"),
        'contrasena' => password_hash($this->request->getPost("contrasena"), PASSWORD_DEFAULT),
        'id_campus' => $this->request->getPost("id_campus"),
        'rol' => $this->request->getPost("rol"),
        'matricula' => $this->request->getPost("matricula"),
        'slug' => $slug
      ];
      $this->UsuarioModel->insert($usuarioData);
    } catch (Exception $e) {
      echo 'Excepción al guardar usuario: ', $e->getMessage(), "\n";
    }

    return redirect()->to("usuarios")->with('msg', 'Usuario registrado correctamente');
  }


  public function update($id)
  {
    
    // Validación de los campos
    $validation = service('validation');
    $validation->setRules([
      'nombre' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
      'apellido_paterno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
      'apellido_materno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
      'correo' => "required|is_unique[usuario.correo,id,{$id}]|valid_email",
      'correo_adicional' => "permit_empty|is_unique[usuario.correo_adicional,id,{$id}]|valid_email",
      'telefono' => "permit_empty|is_unique[usuario.telefono,id,{$id}]|numeric|min_length[10]",
      'id_campus' => 'required',
    ], [
      'nombre' => [
        'required' => 'El campo nombre es requerido',
        'regex_match' => 'El campo nombre solo puede contener letras y espacios'
      ],
      'apellido_paterno' => [
        'required' => 'El campo apellido paterno es requerido',
        'regex_match' => 'El campo apellido paterno solo puede contener letras y espacios'
      ],
      'apellido_materno' => [
        'required' => 'El campo apellido materno es requerido',
        'regex_match' => 'El campo apellido materno solo puede contener letras y espacios'
      ],
      'correo' => [
        'required' => "El correo es requerido",
        'is_unique' => "El correo debe ser único",
        'valid_email' => "El campo de correo debe de ser llenado con un correo válido",
      ],
      'correo_adicional' => [
        'is_unique' => "El correo debe ser único",
        'valid_email' => "El campo de correo debe de ser llenado con un correo válido",
      ],
      'telefono' => [
        'is_unique' => "El número telefónico debe ser único",
        'numeric' => "El campo de teléfono sólo puede tener números",
        'min_length[10]' => "El número telefónico debe de tener un mínimo de 10 caracteres",
      ],
      'id_campus' => [
        'required' => "El campus es requerido",
      ],
    ]);

    if (!$validation->withRequest($this->request)->run()) {
      return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    try {
      $datos = [];

      if (isset($_POST["nombre"]) && !empty($_POST["nombre"])) {
        $datos["nombre"] = $this->request->getPost("nombre");
      }
      if (isset($_POST["apellido_paterno"]) && !empty($_POST["apellido_paterno"])) {
        $datos["apellido_paterno"] = $this->request->getPost("apellido_paterno");
      }
      if (isset($_POST["apellido_materno"]) && !empty($_POST["apellido_materno"])) {
        $datos["apellido_materno"] = $this->request->getPost("apellido_materno");
      }
      if (isset($_POST["correo"]) && !empty($_POST["correo"])) {
        $datos["correo"] = $this->request->getPost("correo");
      }
      if (isset($_POST["correo_adicional"]) && !empty($_POST["correo_adicional"])) {
        $datos["correo_adicional"] = $this->request->getPost("correo_adicional");
      }
      if (isset($_POST["telefono"]) && !empty($_POST["telefono"])) {
        $datos["telefono"] = $this->request->getPost("telefono");
      }
      if (isset($_POST["id_campus"]) && !empty($_POST["id_campus"])) {
        $datos["id_campus"] = $this->request->getPost("id_campus");
      }

      $this->UsuarioModel->update($id, $datos);
    } catch (Exception $e) {
      echo 'Excepción al actualizar usuario: ', $e->getMessage(), "\n";
    }

    return redirect()->to("/usuario/perfil/$id")->with('msg', 'Usuario actualizado correctamente');
  }



  public function edit($slug)
  {
      if ($slug === null) {
          throw new \CodeIgniter\Exceptions\PageNotFoundException('El usuario no se encuentra.');
      }

      // Buscar usuario por slug
      $usuario = $this->UsuarioModel->where('slug', $slug)->first();

      if (!$usuario) {
          throw new \CodeIgniter\Exceptions\PageNotFoundException('El usuario no se encuentra.');
      }

      $campus = $this->CampusModel->findAll();
      $data = [
          "usuario" => $usuario,
          "campus" => $campus
      ];
      return view("Usuarios/editar", $data);
  }
  

  // En el controlador de Usuario
  public function delete($id)
  {

    $this->CapacitacionModel->deleteByUserId($id);

    $this->DatosGeneralesModel->deleteByUserId($id);
    $this->DomicilioModel->deleteByUserId($id);
  


    $this->UsuarioModel->delete($id);
    return redirect()->to("usuarios")->with('msg', 'Usuario eliminado correctamente');
  }

  public function form()
  {
    $campus = $this->CampusModel->findAll();
    $data = [
      'campus' => $campus
    ];

    return view("Usuarios/agregar", $data);
  }

  public function perfil()
  {
      $session = session();
      $idUsuarioSesion = $session->get('id');
  
      $idSolicitado = $this->request->getVar('id');
  
      $idAMostrar = $idSolicitado ?? $idUsuarioSesion;
  
      if (!$this->puedeVerPerfil($idUsuarioSesion, $idAMostrar)) {
          return redirect()->to('/usuario/perfil')->with('error', 'No tienes permiso para ver este perfil.');
      }
  
      $usuario = $this->UsuarioModel->find($idAMostrar);
      
      if ($usuario === null) {
          return redirect()->to('/')->with('error', 'Usuario no encontrado.');
      }
  
      $nombreCampus = '';
  
      if (isset($usuario['id_campus']) && $usuario['id_campus'] !== null) {
          $campus = $this->CampusModel->find($usuario['id_campus']);
      
          if ($campus && isset($campus['nombre'])) {
              $nombreCampus = $campus['nombre'];
          }
      }
  
      $data = [
          "usuario" => $usuario,
          "nombreCampus" => $nombreCampus
      ];
  
      return view('Usuarios/perfil', $data);
  }
  
  private function puedeVerPerfil($idUsuarioSesion, $idSolicitado)
  {
      if ($idUsuarioSesion == $idSolicitado) {
          return true;
      }
  
      $usuarioActual = $this->UsuarioModel->find($idUsuarioSesion);
  
      if (isset($usuarioActual['rol']) && $usuarioActual['rol'] == 'admin') {
          return true;
      }
  
      return false;
  }

  // Registro usuario
  public function registrar()
  {

    
    $slug = $this->UsuarioModel->generateUniqueSlug();
    // Validación de los campos
    $validation = service('validation');
    $validation->setRules(
      [
        'nombre' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
        'apellido_paterno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
        'apellido_materno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
        'correo' => 'required|is_unique[usuario.correo]|valid_email',
        'telefono' => 'permit_empty|is_unique[usuario.telefono]|numeric|min_length[10]',
        'contrasena' => 'required|min_length[8]',
        'confirmar_contrasena' => 'required|min_length[8]|matches[contrasena]',
        'id_campus' => 'required',
        'rol' => 'required',
        'matricula' => 'required|is_unique[usuario.matricula]|numeric|exact_length[11]',
      ],
      [ // Mensajes de error 
        'nombre' => [
          'required' => 'El campo nombre es requerido',
          'regex_match' => 'El campo nombre solo puede contener letras y espacios'
        ],
        'apellido_paterno' => [
          'required' => 'El campo apellido paterno es requerido',
          'regex_match' => 'El campo apellido paterno solo puede contener letras y espacios'
        ],
        'apellido_materno' => [
          'required' => 'El campo apellido materno es requerido',
          'regex_match' => 'El campo apellido materno solo puede contener letras y espacios'
        ],
        'correo' => [
          'required' => "El correo es requerido",
          'is_unique' => "El correo debe ser único",
          'valid_email' => "El campo de correo debe de ser llenado con un correo válido",
        ],
        'telefono' => [
          'is_unique' => "El número telefónico debe ser único",
          'numeric' => "El campo de teléfono sólo puede tener números",
          'min_length[10]' => "El número telefónico debe de tener un mínimo de 10 caracteres",
        ],
        'contrasena' => [
          'required' => "La contraseña es obligatoria",
          'min_length' => "La contraseña tiene que tener un mínimo de 8 caracteres",
        ],
        'confirmar_contrasena' => [
          'required' => "La contraseña es obligatoria",
          'min_length[8]' => "La contraseña tiene un mínimo de 8 caracteres",
          'matches' => "Las contraseñas no coinciden"
        ],
        'id_campus' => [
          'required' => "El campus es requerido",
        ],
        'rol' => [
          'required' => "El campo de rol es requerido",
        ],
        'matricula' => [
          'required' => "El campo de matrícula es requerido",
          'is_unique' => "ID existente",
          'numeric' => "El campo de matrícula sólo puede tener números",
        ],
      ]
    );

    if (!$validation->withRequest($this->request)->run()) {
      return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/", $this->request->getPost('nombre'))) {
      return redirect()->back()->withInput()->with('nom', 'El campo de nombre solo lleva letras y espacios');
    }
    if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/", $this->request->getPost('apellido_paterno'))) {
      return redirect()->back()->withInput()->with('nom', 'El campo de apellido paterno solo lleva letras y espacios');
    }
    if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/", $this->request->getPost('apellido_materno'))) {
      return redirect()->back()->withInput()->with('nom', 'El campo de apellido materno solo lleva letras y espacios');
    }


    try {
      $usuarioData = [
        'nombre' => $this->request->getPost("nombre"),
        'apellido_paterno' => $this->request->getPost("apellido_paterno"),
        'apellido_materno' => $this->request->getPost("apellido_materno"),
        'correo' => $this->request->getPost("correo"),
        'telefono' => $this->request->getPost("telefono"),
        'contrasena' => password_hash($this->request->getPost("contrasena"), PASSWORD_DEFAULT),
        'id_campus' => $this->request->getPost("id_campus"),
        'rol' => $this->request->getPost("rol"),
        'matricula' => $this->request->getPost("matricula"),
        'slug' => $slug
      ];
      $this->UsuarioModel->insert($usuarioData);
    } catch (Exception $e) {
      echo 'Excepción al guardar usuario: ', $e->getMessage(), "\n";
    }

    return redirect()->to("/")->with('msg', 'Usuario registrado correctamente');
  }


  //Restablecer contraseña
  public function contrasena_olvidada()
  {
    return view('Home/contrasena_olvidada');
  }
  //Funcion para enviar el correo
  public function enviar_correo($correo, $asunto, $cuerpo)
  {
    $email = \Config\Services::email();
    $email->setTo($correo);
    $email->setFrom(config('Email')->SMTPUser, 'SIGAA');
    $email->setSubject($asunto);
    $email->setMessage($cuerpo);
    $email->send();
  }
  //Funcion para enviar el link por correo
  public function recuperacion_contrasena()
  {
    $matricula = $this->request->getPost("matricula");
    $usuario = $this->UsuarioModel->where("matricula", $matricula)->first();

    if ($usuario) {
      $token = bin2hex(random_bytes(50));
      $expiry = date('Y-m-d H:i:s', strtotime('+10 minute'));


      $this->UsuarioModel->update($usuario['id'], ['reset_token' => $token, 'reset_expiry' => $expiry]);

      $asunto = "SIGAA - Recuperar contraseña";
      $cuerpo = "Hola, " . $usuario["nombre"] . ", haga clic en el siguiente enlace para restablecer su contraseña: 
        <a href='" . base_url() . "/restablecer_contrasena/" . $token . "'>Restablecer contraseña</a>";

      $this->enviar_correo($usuario['correo'], $asunto, $cuerpo);

      return redirect()->to("/")->with('msg', 'Se ha enviado un correo con el enlace para restablecer su contraseña');
    } else {
      return redirect()->to("/")->with('msg', 'El usuario no existe');
    }
  }

  //Se restablece la contraseña con el token y verifica si no ha expirado
  public function restablecer_contrasena($token)
  {
    $usuario = $this->UsuarioModel->where('reset_token', $token)->where('reset_expiry >=', date('Y-m-d H:i:s'))->first();

    if (!$usuario) {
      return redirect()->to('/')->with('msg', 'El enlace para restablecer la contraseña es inválido o ha expirado.');
    }

    $data = [
      "token" => $token
    ];
    return view('/Home/restablecer_contrasena', $data);
  }

  //Funcion para actualizar la contraseña
  public function reiniciar_contrasena()
  {
    $validation = service('validation');
    $validation->setRules(
      [
        'contrasena' => 'required|min_length[8]',
        'confirmar_contrasena' => 'required|min_length[8]|matches[contrasena]'
      ],

      [ //mensajes de error 
        'contrasena' => [
          'required' => "La contraseña es obligatoria",
          'min_length' => "La contraseña tiene que tener un mínimo de 8 caracteres",
        ],
        'confirmar_contrasena' => [
          'required' => "La contraseña es obligatoria",
          'min_length' => "La contraseña tiene que tener un mínimo de 8 caracteres",
          'matches' => "Las contraseñas no coinciden"
        ],
      ]
    );

    if (!$validation->withRequest($this->request)->run()) {
      return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $token = $this->request->getPost("token");
    $usuario = $this->UsuarioModel->where('reset_token', $token)->where('reset_expiry >=', date('Y-m-d H:i:s'))->first();

    if ($usuario) {
      $nuevaContrasena = $this->request->getPost("contrasena");
      $hash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);


      $this->UsuarioModel->update($usuario['id'], ['contrasena' => $hash, 'reset_token' => null, 'reset_expiry' => null]);

      return redirect()->to("/")->with('msg', 'Contraseña restablecida correctamente');
    } else {
      return redirect()->to("/")->with('msg', 'El enlace para restablecer la contraseña es inválido o ha expirado.');
    }
  }

  //funcion para el combo box para filtrar los usuarios con sus capacitaciones 
  public function filtrerUsers()
  {
    $estadoCapacitacion = $this->request->getVar('estado_capacitacion') ?? 'Todos';

    $rol = 'Maestro';

    $usuariosFiltrados = [];

    $usuarios = $this->UsuarioModel->findUserdByRol($rol);
    $campus = $this->CampusModel->findAll();

    foreach ($usuarios as $usuario) {
      $capacitaciones = $this->CapacitacionModel->findCapacitacionesById($usuario['id']);
      $estadoConIcono = $this->getStatus($capacitaciones);
      $estado = $estadoConIcono['status'];
      $icono = $estadoConIcono['icon'];

      switch ($estadoCapacitacion) {
        case 'Todos':
          $usuario['estadoCapacitacion'] = $estado;
          $usuario['iconoEstado'] = $icono;
          $usuariosFiltrados[] = $usuario;
          break;
        case 'Terminado':
          if ($estado == 'Terminado') {
            $usuario['estadoCapacitacion'] = $estado;
            $usuario['iconoEstado'] = $icono;
            $usuariosFiltrados[] = $usuario;
          }
          break;
        case 'En Proceso':
          if ($estado == 'En Proceso') {
            $usuario['estadoCapacitacion'] = $estado;
            $usuario['iconoEstado'] = $icono;
            $usuariosFiltrados[] = $usuario;
          }
          break;
        case 'Sin Revisar':
          if ($estado == 'Sin Revisar') {
            $usuario['estadoCapacitacion'] = $estado;
            $usuario['iconoEstado'] = $icono;
            $usuariosFiltrados[] = $usuario;
          }
          break;
        case 'Sin Envio':
          if ($estado == 'Sin Envio') {
            $usuario['estadoCapacitacion'] = $estado;
            $usuario['iconoEstado'] = $icono;
            $usuariosFiltrados[] = $usuario;
          }
          break;
      }
    }

    $data = [
      'usuarios' => $usuariosFiltrados,
      'estadosCapacitacion' => ['Todos', 'Terminado', 'En Proceso', 'Sin Revisar', 'Sin Envio'],
      'estadoCapacitacionSeleccionado' => $estadoCapacitacion,
      'campus' => $campus
    ];

    return view('Usuarios/index', $data);
  }

  //Trae a los usuarios con capacitaciones aceptadas
  private function allTrainingAcceptedUser($trainings)
  {
    foreach ($trainings as $training) {
      if ($training['estado'] !== 'Aceptado') {
        return false;
      }
    }
    return true;

  }
  //Trae a los usuarios con capacitaciones en proceso
  private function trainingsInProcessUser($trainings)
  {
    $totalTrainings = count($trainings);
    if ($totalTrainings === 0) {
      return false;
    }

    $hasAccepted = 0;
    $hasSent = 0;
    $hasRejected = 0;

    foreach ($trainings as $training) {
      if ($training['estado'] === 'Aceptado') {
        $hasAccepted++;
      } elseif ($training['estado'] === 'Enviado') {
        $hasSent++;
      } elseif ($training['estado'] === 'Rechazado') {
        $hasRejected++;
      }
    }

    if (
      ($hasAccepted > 0 && $hasSent > 0) ||
      ($hasAccepted > 0 && $hasRejected > 0) ||
      ($hasSent > 0 && $hasRejected > 0)
    ) {
      return true;
    }

    if ($hasAccepted === $totalTrainings || $hasSent === $totalTrainings) {
      return false;
    }

    return true;
  }

  //Trae a los usuarios con capacitaciones sin revisar
  private function trainingUnreviewedUser($capacitaciones)
  {
    foreach ($capacitaciones as $capacitacion) {
      if ($capacitacion['estado'] !== 'Enviado') {
        return false;
      }
    }

    return count($capacitaciones) > 0;
  }
  // Función para obtener el estado de las capacitaciones de un usuario con su icono
  function getStatus($capacitaciones)
  {
    if (empty($capacitaciones)) {
      return ['status' => 'Sin Envio', 'icon' => 'bi bi-circle'];
    }

    if ($this->allTrainingAcceptedUser($capacitaciones)) {
      return ['status' => 'Terminado', 'icon' => 'bi bi-check-circle-fill text-success'];
    }

    if ($this->trainingsInProcessUser($capacitaciones)) {
      return ['status' => 'En Proceso', 'icon' => 'bi bi-clock-history text-primary '];
    }

    if ($this->trainingUnreviewedUser($capacitaciones)) {
      return ['status' => 'Sin Revisar', 'icon' => 'bi bi-exclamation-diamond-fill text-danger'];
    }

    return ['status' => 'Desconocido', 'icon' => 'fa fa-question-circle'];
  }





}

