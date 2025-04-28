<?php

namespace App\Controllers;

use App\Models\CapacitacionModel;
use App\Models\UsuarioModel;

class Capacitacion extends BaseController
{

  private $CapacitacionModel;
  private $UsuarioModel;

  function __construct()
  {
    $session = session();
    $_SESSION["menu"] = true;
    $this->CapacitacionModel = new CapacitacionModel();
    $this->UsuarioModel = new UsuarioModel();
  }
  public function index()
  { 
    if (isset($_SESSION["id"])) {
      
      $capacitaciones = $this->CapacitacionModel->where('id_usuario', $_SESSION["id"])->findAll();
      $horas = $this->CapacitacionModel->findHoursById(1);
      $usuario = $this->UsuarioModel->find($_SESSION["id"]);

      if (isset($horas[0]["duracion_horas"])) {

        $hora["docente"] = $horas[0]["duracion_horas"];
      } else {
        $hora["docente"] = 0;
      }

      if (isset($horas[1]["duracion_horas"])) {

        $hora["disciplinar"] = $horas[1]["duracion_horas"];
      } else {
        $hora["disciplinar"] = 0;
      }


      $data = [
        "capacitaciones" => $capacitaciones,
        "horas" => $hora,
        "usuario" => $usuario

      ];

      return view('/Capacitaciones/index', $data);
    } else {
        return redirect()->to("/");

    }

  }


  public function show($slug)
  {
      if (isset($_SESSION["id"])) {
   
          $capacitacion = $this->CapacitacionModel->where('slug', $slug)->first();
          
          if (!$capacitacion) {
              return redirect()->back()->with('error', 'Capacitación no encontrada');
          }
  
  
          $usuario = $this->UsuarioModel->find($capacitacion['id_usuario']);
  
          if (!$usuario) {
              return redirect()->back()->with('error', 'Usuario no encontrado');
          }
  
          $data = [
              "capacitacion" => $capacitacion,

              "correo_maestro" => $usuario['correo'],
              "nombre_maestro" => $usuario['nombre'],
              "apellido_paterno" => $usuario['apellido_paterno'],
              "apellido_materno" => $usuario['apellido_materno'],
                "usuario" => $usuario
          ];
  
          return view('/Capacitaciones/mostrar', $data);
      } else {
          return redirect()->to("/");
      }
  }
  
  //funcion para mostrar las horas de capacitacion
  public function capacitaciones($slug)
  {
      if (isset($_SESSION["id"])) {

          $usuario = $this->UsuarioModel->getUserBySlug($slug);
          
          if (!$usuario) {
              return redirect()->back()->with('error', 'Usuario no encontrado');
          }
  
 
          $capacitaciones = $this->CapacitacionModel->findCapacitacionesById($usuario['id']);
          $horas = $this->CapacitacionModel->findHoursById($usuario['id']);
  
    
          $hora = [
              "docente" => isset($horas[0]["duracion_horas"]) ? $horas[0]["duracion_horas"] : 0,
              "disciplinar" => isset($horas[1]["duracion_horas"]) ? $horas[1]["duracion_horas"] : 0
          ];
  
          $data = [
              "usuario" => $usuario,
              "capacitaciones" => $capacitaciones,
              "horas" => $hora
          ];
  
          return view('/Capacitaciones/index', $data);
      } else {
          return view("Home/login");
      }
  }
  
  

  public function form()
  {
    $session = session();
    $usuario = $this->UsuarioModel->find($session->get('id'));

    if (!$usuario) {
      return redirect()->to("Home/login")->with('error', 'Usuario no encontrado');
    }

    $data = [
      'usuario' => $usuario
    ];

    return view('/Capacitaciones/agregar', $data);
  }




 // Función para guardar capacitación
 public function save()
 {
     $capacitacionModel = new CapacitacionModel();
     $slug = $capacitacionModel->generateUniqueSlug();
 
     // Validación de los campos
     $validation = service('validation');
     $validation->setRules(
         [
             'titulo' => 'required',
             'tipo' => 'required',
             'lugar' => 'required',
             'fecha_inicial' => 'required',
             'fecha_final' => 'required',
             'institucion' => 'required',
             'modalidad' => 'required',
             'duracion_horas' => 'required|greater_than[0]',
             'nombre_instructor' => 'required',
             'rol' => 'required',
             'evidencia' => [
                 'uploaded[evidencia]',
                 'mime_in[evidencia,application/pdf,image/jpg,image/jpeg,image/png]',
                 'max_size[evidencia,5120]'
             ]
         ],
         [ // Mensajes de error 
             'titulo' => [
                 'required' => "El campo de nombre es requerido"
             ],
             'tipo' => [
                 'required' => "El campo tipo es requerido"
             ],
             'lugar' => [
                 'required' => "El campo de lugar es requerido"
             ],
             'fecha_inicial' => [
                 'required' => "El campo de fecha de inicio es requerido"
             ],
             'fecha_final' => [
                 'required' => "El campo de fecha final es requerido"
             ],
             'institucion' => [
                 'required' => "El campo de institución es requerido"
             ],
             'modalidad' => [
                 'required' => "El campo de modalidad es requerido"
             ],
             'duracion_horas' => [
                 'required' => "El campo de duración es requerido",
                  'greater_than' => "Las horas registradas deben ser mayores a 0"
             ],
             'nombre_instructor' => [
                 'required' => "El campo de instructor es requerido"
             ],
             'rol' => [
                 'required' => "El campo de rol es requerido"
             ],
             'evidencia' => [
                 'uploaded' => "El campo de evidencia es requerido",
                 'mime_in' => "El archivo de evidencia debe ser PDF, JPG o PNG",
                 'max_size' => "El tamaño del archivo de evidencia no puede exceder 5MB"
             ]
         ]
     );
 
     if (!$validation->withRequest($this->request)->run()) {
         return redirect()->back()->withInput()->with('errors', $validation->getErrors());
     }
 
     $file = $this->request->getFile('evidencia');
     $fileName = null;
     if ($file->isValid() && !$file->hasMoved()) {
         $fileName = $file->getRandomName();
         $file->move('evidencias/', $fileName);
     }
 
     $capacitacionData = [
         'titulo' => $this->request->getPost("titulo"),
         'tipo' => $this->request->getPost("tipo"),
         'lugar' => $this->request->getPost("lugar"),
         'fecha_inicial' => $this->request->getPost("fecha_inicial"),
         'fecha_final' => $this->request->getPost("fecha_final"),
         'institucion' => $this->request->getPost("institucion"),
         'modalidad' => $this->request->getPost("modalidad"),
         'duracion_horas' => $this->request->getPost("duracion_horas"),
         'evidencia' => $fileName,
         'nombre_instructor' => $this->request->getPost("nombre_instructor"),
         'id_usuario' => $_SESSION["id"],
         'estado' => "Enviado",
         'rol' => $this->request->getPost("rol"),
            'slug' => $slug
     ];
 
     $capacitacionModel->insert($capacitacionData);
 
     return redirect()->to("capacitaciones")->with('msg', 'Capacitación añadida correctamente');
 }
 
 //funcion para editar capacitacion
 public function edit($slug)
 {
     $session = session();

     $capacitacion = $this->CapacitacionModel->where('slug', $slug)->first();
 
     if (!$capacitacion) {
         return redirect()->to('/capacitaciones')->with('error', 'Capacitación no encontrada');
     }
 
    
     $id = $capacitacion['id'];
 
     if ($session->get('rol') == 'admin') {
         $usuario = $this->UsuarioModel->find($capacitacion['id_usuario']);
         $data['maestro_id'] = $capacitacion['id_usuario'];
     } else {
         $usuario = $this->UsuarioModel->find($session->get('id'));
         $data['maestro_id'] = $session->get('id');
     }
 
     $data["capacitacion"] = $capacitacion;
     $data["usuario"] = $usuario;
 
     return view("/Capacitaciones/editar", $data);
 }
 

 //funcion para mostrar capacitacion por maestro
 public function capacitacionesMaestro($id)
 {
     if (session()->get('rol') != 'admin') {
         return redirect()->to('/capacitaciones');
     }
 
     $capacitaciones = $this->CapacitacionModel->where('id_usuario', $id)->findAll();
     $usuario = $this->UsuarioModel->find($id);
 
     $data = [
         "capacitaciones" => $capacitaciones,
         "usuario" => $usuario
     ];
 
     return view('/Capacitaciones/index', $data);
 }
 
 //funcion para actualizar capacitacion
 public function update($id)
 {
     $capacitacionModel = new CapacitacionModel();
 
     // Validación de los campos
     $validation = service('validation');
     $validation->setRules(
         [
             'titulo' => 'required',
             'tipo' => 'required',
             'lugar' => 'required',
             'fecha_inicial' => 'required',
             'fecha_final' => 'required',
             'institucion' => 'required',
             'modalidad' => 'required',
             'duracion_horas' => 'required|greater_than[0]',
             'nombre_instructor' => 'required',
             'rol' => 'required'
         ],
         [ // Mensajes de error 
             'titulo' => [
                 'required' => "El campo de nombre es requerido"
             ],
             'tipo' => [
                 'required' => "El campo tipo es requerido"
             ],
             'lugar' => [
                 'required' => "El campo de lugar es requerido"
             ],
             'fecha_inicial' => [
                 'required' => "El campo de fecha de inicio es requerido"
             ],
             'fecha_final' => [
                 'required' => "El campo de fecha final es requerido"
             ],
             'modalidad' => [
                 'required' => "El campo de modalidad es requerido"
             ],
             'duracion_horas' => [
                 'required' => "El campo de duración es requerido",
                 'greater_than' => "Las horas registradas deben ser mayores a 0"
             ],
             'nombre_instructor' => [
                 'required' => "El campo de instructor es requerido"
             ],
             'rol' => [
                 'required' => "El campo de rol es requerido"
             ]
         ]
     );
 
     if (!$validation->withRequest($this->request)->run()) {
         return redirect()->back()->withInput()->with('errors', $validation->getErrors());
     }
 
     $titulo = $this->request->getPost("titulo");
     $nombreInstructor = $this->request->getPost("nombre_instructor");
 
     if (strlen(trim($titulo, " '\"")) === 0) {
         return redirect()->back()->withInput()->with('tit', 'El campo de nombre no puede estar vacío o contener solo comillas');
     }
 
     if (strlen(trim($nombreInstructor, " '\"")) === 0) {
         return redirect()->back()->withInput()->with('nom', 'El nombre del instructor no puede estar vacío o contener solo comillas');
     }
 
     if ($this->request->getPost('fecha_inicial') > $this->request->getPost('fecha_final')) {
         return redirect()->back()->withInput()->with('fec', 'La fecha inicial no puede ser después de la fecha final');
     }
 
   
     $capacitacion = [
         'titulo' => $titulo,
         'tipo' => $this->request->getPost("tipo"),
         'lugar' => $this->request->getPost("lugar"),
         'fecha_inicial' => $this->request->getPost("fecha_inicial"),
         'fecha_final' => $this->request->getPost("fecha_final"),
         'institucion' => $this->request->getPost("institucion"),
         'modalidad' => $this->request->getPost("modalidad"),
         'duracion_horas' => $this->request->getPost("duracion_horas"),
         'nombre_instructor' => $nombreInstructor,
         'estado' => "Enviado",
         'rol' => $this->request->getPost("rol")
     ];
 

     $capacitacionModel->update($id, $capacitacion);
 

     $file = $this->request->getFile('evidencia');
     if ($file->isValid() && !$file->hasMoved()) {
      
         $existingCapacitacion = $capacitacionModel->find($id);
 
         if (isset($existingCapacitacion['evidencia'])) {
             $ruta = 'evidencias/' . $existingCapacitacion['evidencia'];
             if (file_exists($ruta)) {
                 unlink($ruta);
             }
         }
 
      
         $fileName = $file->getRandomName();
         $file->move('evidencias/', $fileName);
 
         
         $capacitacionModel->update($id, ['evidencia' => $fileName]);
     }
 
  
     $capacitacion = $capacitacionModel->find($id);
     return redirect()->to("/capacitaciones/mostrar/" . $capacitacion['slug'])->with('msg', 'Capacitación editada correctamente');
 }
 
  
  //funcion para actualizar el estado de la capacitacion
  public function updateStatus($id, $estado)
  {
    $capacitacion = [
      'estado' => $estado
    ];
    $this->CapacitacionModel->update($id, $capacitacion);

    return redirect()->to("/capacitaciones/mostrar/$id")->with('msg', 'Estado de capacitacion correctamente actualizado');
  }

  //funcion para eliminar capacitacion
  public function delete($id)
  {

    $capacitacion = $this->CapacitacionModel->find($id);

    $rute = ('../public/evidencias/' . $capacitacion['evidencia']);
    unlink($rute);

    if ($file = $this->request->getFile('evidencia')) {
      $newFile = $file->getRandomName();
      $file->move('../public/evidencia/', $newFile);
    }

    $this->CapacitacionModel->delete($id);

    return redirect()->to('/capacitaciones')->with('msg', 'Capacitacion elimada correctamente');
  }
  //funcion para enviar correo
  public function enviar_correo($correo, $asunto, $cuerpo)
  {
    $email = \Config\Services::email();
    $email->setTo($correo);
    $email->setFrom(config('Email')->SMTPUser, 'SIGAA');
    $email->setSubject($asunto);
    $email->setMessage($cuerpo);
    $email->send();


  }

  //funcion para enviar correo de rechazo de capacitacion
  public function motivo_correo($id, $estado)
  {
      $motivo = urldecode($this->request->getGet('motivo'));
      $correoMaestro = urldecode($this->request->getGet('correo'));
      $nombreMaestro = urldecode($this->request->getGet('nombre'));
      $apellidoPaterno = urldecode($this->request->getGet('apellido_paterno'));
      $apellidoMaterno = urldecode($this->request->getGet('apellido_materno'));
  
      $nombreCompletoMaestro = $nombreMaestro . ' ' . $apellidoPaterno . ' ' . $apellidoMaterno;
  
      $capacitacion = $this->CapacitacionModel->find($id);
      if (!$capacitacion) {
          return redirect()->back()->with('error', 'Capacitación no encontrada');
      }
  
      $tituloCapacitacion = $capacitacion['titulo'];
  
      if ($estado == 'Rechazado' && $motivo) {
          $asunto = "SIGAA - Su capacitación ha sido rechazada";
          $cuerpo = "Hola maestro, $nombreCompletoMaestro. <br><br>Su capacitación '{$tituloCapacitacion}' ha sido rechazada por el siguiente motivo:<br><br>$motivo";
          $this->enviar_correo($correoMaestro, $asunto, $cuerpo);
          $this->CapacitacionModel->updateMotivo($id, $motivo);
      }
  
      $this->updatestatus($id, $estado);
  
      return redirect()->to("/capacitaciones/mostrar/$id")->with('msg', 'Correo enviado correctamente');
  }
  
  // Funcion para enviar aviso al maestro
  public function aviso_correo($id)
  {
      $motivo = urldecode($this->request->getGet('motivo'));
      $correoMaestro = urldecode($this->request->getGet('correo'));
      $nombreMaestro = urldecode($this->request->getGet('nombre'));
      $apellidoPaterno = urldecode($this->request->getGet('apellido_paterno'));
      $apellidoMaterno = urldecode($this->request->getGet('apellido_materno'));
  
      $nombreCompletoMaestro = $nombreMaestro . ' ' . $apellidoPaterno . ' ' . $apellidoMaterno;
  
      $capacitacion = $this->CapacitacionModel->find($id);
      if (!$capacitacion) {
          return redirect()->back()->with('error', 'Capacitación no encontrada');
      }
  
      $tituloCapacitacion = $capacitacion['titulo'];
  
      if ($motivo) {
          $asunto = "SIGAA - Aviso Importante sobre la capacitación: {$tituloCapacitacion}";
          $cuerpo = "Hola maestro, $nombreCompletoMaestro. <br><br>Le enviamos el siguiente aviso sobre la capacitación '{$tituloCapacitacion}':<br><br>$motivo";
          $this->enviar_correo($correoMaestro, $asunto, $cuerpo);
      }
  
      return redirect()->to("/capacitaciones/mostrar/$id")->with('msg', 'Aviso enviado correctamente');
  }
  

}

