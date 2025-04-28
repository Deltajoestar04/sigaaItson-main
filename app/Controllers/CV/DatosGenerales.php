<?php
namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\CvModel;
use App\Models\CV\DatosGenerales\DatosGeneralesModel;
use App\Models\CV\DatosGenerales\DomicilioModel;
use App\Models\CV\DatosGenerales\UbicacionModel;

class DatosGenerales extends BaseController
{
    private $UsuarioModel;
    private $CvModel;
    private $DatosGeneralesModel;
    private $DomicilioModel;
    private $UbicacionModel;


    function __construct()
    {
        $session = session();
        $_SESSION["menu"] = true;
        $this->UsuarioModel = new UsuarioModel();
        $this->CvModel = new CvModel();
        $this->DatosGeneralesModel = new DatosGeneralesModel();
        $this->DomicilioModel = new DomicilioModel();
        $this->UbicacionModel = new UbicacionModel();
    }

         
    // Función para mostrar la información de datos generales
    public function index()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        if (isset($_SESSION["id"])) {
            try {
                $datosGenerales = $this->DatosGeneralesModel->findDatosGeneralesById($_SESSION["id"]);
                $usuario = $this->UsuarioModel->find($_SESSION["id"]);
                $domicilios = $this->DomicilioModel->findDomicilioById($_SESSION["id"]);
            


                foreach ($domicilios as &$domicilio) {
                    $idUbicacion = $domicilio['id_ubicacion'];
                    $ubicacion = $this->UbicacionModel->findUbicacionById($idUbicacion);
                    $domicilio = array_merge($domicilio, $ubicacion);


                }

            } catch (\Exception $e) {
                $datosGenerales = null;
                $usuario = null;
                $domicilios = null;
               
            }

            $data = [
                "datosGenerales" => $datosGenerales ?? [],
                "usuario" => $usuario ?? [],
                "domicilios" => $domicilios ?? []
            ];

            return view('Cvs/DatosGenerales/index', $data);
        } else {
            return redirect()->to('/Home/login');
        }
    }


                    //----------------------------------------------------------
                                     // Datos personales
                    //----------------------------------------------------------
                    
    // Función para editar la información de datos personales

    public function editInformation()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return redirect()->to('/login');
        }

        $datosGenerales = $this->DatosGeneralesModel->findDatosGeneralesById($id);
        $usuario = $this->UsuarioModel->find($id);


        $data = [
            "datosGenerales" => $datosGenerales ?? [],
            "usuario" => $usuario ?? []
        ];

        return view('Cvs/DatosGenerales/editar', $data);
    }

    // Función para actualizar la información de datos personales
    public function updateInformation($id)
{
    $validation = service('validation');    
    $validation->setRules([
        'nombre' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
        'apellido_paterno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
        'apellido_materno' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
        'telefono' => 'permit_empty|numeric|max_length[10]',
        'correo' => 'required|valid_email',
        'correo_adicional' => 'permit_empty|valid_email',
        'fecha_nacimiento' => 'required',
        'edad' => 'required',
        'genero' => 'required',
        'no_celular' => 'permit_empty|numeric|max_length[10]',
        'foto_personal' => 'max_size[foto_personal,1024]|is_image[foto_personal]|ext_in[foto_personal,jpg,jpeg,png]|permit_empty'
    ],
    // Mensajes de error personalizados
    [
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
        'telefono' => [
            'numeric' => 'El campo teléfono solo puede contener números',
            'max_length' => 'El campo teléfono solo puede contener 10 dígitos'
        ],
        'correo' => [
            'required' => 'El campo correo es requerido',
            'valid_email' => 'El campo correo debe ser un correo válido'
        ],
        'correo_adicional' => [
            'valid_email' => 'El campo correo adicional debe ser un correo válido'
        ],
        'fecha_nacimiento' => [
            'required' => 'El campo fecha de nacimiento es requerido'
        ],
        'edad' => [
            'required' => 'El campo edad es requerido',
        ],
        'genero' => [
            'required' => 'El campo género es requerido'
        ],
        'no_celular' => [
            'numeric' => 'El campo número de celular solo puede contener números',
            'max_length' => 'El campo número de celular solo puede contener 10 dígitos'
        ],
        'foto_personal' => [
            'max_size' => 'La foto no debe pesar más de 1MB',
            'is_image' => 'El archivo seleccionado no es una imagen',
            'ext_in' => 'La imagen solo puede ser de tipo jpg, jpeg o png'
        ]
    ]);
    
    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }
    

    try {
        $datosGeneralesModel = new DatosGeneralesModel();
        $datosGeneralesRecord = $datosGeneralesModel->findDatosGeneralesById($id);

        $foto = $this->request->getFile('foto_personal');
        if ($foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('./uploads/fotos_personales', $newName);

            if (!empty($datosGeneralesRecord['foto_personal'])) {
                unlink('./uploads/fotos_personales/' . $datosGeneralesRecord['foto_personal']);
            }
        } else {
            $newName = $datosGeneralesRecord['foto_personal'] ?? null;
        }

        $datosGeneralesData = [
            'fecha_nacimiento' => esc($this->request->getPost("fecha_nacimiento")),
            'edad' => esc($this->request->getPost("edad")),
            'genero' => esc($this->request->getPost("genero")),
            'no_celular' => esc($this->request->getPost("no_celular")) ?? null,
            'foto_personal' => esc($newName),
            'id_usuario' => esc($id)
        ];
        
        if (empty($datosGeneralesRecord)) {
            $datosGeneralesModel->insert($datosGeneralesData);
        } else {
            $datosGeneralesModel->update(esc($datosGeneralesRecord['id']), $datosGeneralesData);
        }
        
        $usuario = [
            'nombre' => esc($this->request->getPost("nombre")),
            'apellido_paterno' => esc($this->request->getPost("apellido_paterno")),
            'apellido_materno' => esc($this->request->getPost("apellido_materno")),
            'telefono' => esc($this->request->getPost("telefono")),
            'correo' => esc($this->request->getPost("correo")),
            'correo_adicional' => esc($this->request->getPost("correo_adicional")) ?? null
        ];
        
        $this->UsuarioModel->update($id, $usuario);

        return redirect()->to("cv/datosgenerales/")->with('msg', 'Información personaal actualizada correctamente');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Ocurrió un error durante la actualización: ' . $e->getMessage());
    }
}

    // Función para eliminar la foto personal

           //----------------------------------------------------------
                                     // Domicilio
            //----------------------------------------------------------
                    
    // Función para guardar la dirección
    
    public function saveAddress() {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No se ha iniciado sesión']);
        }
        
        // Validación y sanitización de los datos
        $validation = service('validation');    
        $validation->setRules([
            'pais' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{2,50}$/]',
            'estado' => 'required|alpha_space|min_length[2]|max_length[50]',
            'ciudad' => 'required|alpha_space|min_length[2]|max_length[50]',
            'codigo_postal' => 'required|numeric|min_length[5]|max_length[5]',
            'calle' => 'required|string|max_length[100]',
            'no_exterior' => 'permit_empty|numeric|max_length[10]',
            'no_interior' => 'permit_empty|numeric|max_length[10]',
            'colonia' => 'required|string|max_length[100]'
        ],
        [
            'pais' => [
                'required' => 'El campo país es requerido',
                'regex_match' => 'El campo país solo puede contener letras, espacios y acentos'
            ],
            'estado' => [
                'required' => 'El campo estado es requerido',
                'alpha_space' => 'El campo estado solo puede contener letras y espacios',
            ],
            'ciudad' => [
                'required' => 'El campo ciudad es requerido',
                'alpha_space' => 'El campo ciudad solo puede contener letras y espacios',
            ],
            'codigo_postal' => [
                'required' => 'El campo código postal es requerido',
                'numeric' => 'El campo código postal solo puede contener números',
                'min_length' => 'El campo código postal debe tener 5 dígitos',
                'max_length' => 'El campo código postal debe tener 5 dígitos'
            ],
            'calle' => [
                'required' => 'El campo calle es requerido',
                'string' => 'El campo calle debe ser una cadena de texto',
                'max_length' => 'El campo calle no debe exceder 100 caracteres'
            ],
            'no_exterior' => [
                'permit_empty' => 'El campo número exterior es opcional',
                'numeric' => 'El campo número exterior solo puede contener números',
                'max_length' => 'El campo número exterior no debe exceder 10 caracteres'
            ],
            'no_interior' => [
                'permit_empty' => 'El campo número interior es opcional',
                'numeric' => 'El campo número interior solo puede contener números',
                'max_length' => 'El campo número interior no debe exceder 10 caracteres'
            ],
            'colonia' => [
                'required' => 'El campo colonia es requerido',
                'string' => 'El campo colonia debe ser una cadena de texto',
                'max_length' => 'El campo colonia no debe exceder 100 caracteres'
            ]
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
    
        $idDomicilio = esc($this->request->getPost('id_domicilio'));

    
        $ubicacionData = [
            'pais' => esc($this->request->getPost('pais')),
            'estado' => esc($this->request->getPost('estado')),
            'ciudad' => esc($this->request->getPost('ciudad')),
            'codigo_postal' => esc($this->request->getPost('codigo_postal'))
        ];
        
        $domicilioData = [
            'calle' => esc($this->request->getPost('calle')),
            'no_exterior' => esc($this->request->getPost('no_exterior')),
            'no_interior' => esc($this->request->getPost('no_interior')),
            'colonia' => esc($this->request->getPost('colonia')),
            'id_usuario' => $id
        ];
    
        try {
            if ($idDomicilio) {
                $existeDomicilio = $this->DomicilioModel->find($idDomicilio);
                if (!$existeDomicilio || $existeDomicilio['id_usuario'] !== $id) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Domicilio no encontrado o no autorizado']);
                }
                $this->UbicacionModel->update($existeDomicilio['id_ubicacion'], $ubicacionData);
                $this->DomicilioModel->update($idDomicilio, $domicilioData);
                $message = 'Domicilio editado correctamente';
            } else {
                $idUbicacion = $this->UbicacionModel->insert($ubicacionData);
                $domicilioData['id_ubicacion'] = $idUbicacion;
                $this->DomicilioModel->insert($domicilioData);
                $message = 'Domicilio guardado correctamente';
            }
    
            return $this->response->setJSON(['success' => true, 'message' => $message],);
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar el domicilio: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error durante la actualización.']);
        }
    }
    
    
// Función para eliminar la dirección
public function deleteAddress($id)
{
    $domicilio = $this->DomicilioModel->find($id);
    if ($domicilio) {
        try {
            $this->UbicacionModel->delete($domicilio['id_ubicacion']);
            $this->DomicilioModel->delete($id);
            return $this->response->setJSON(['success' => true, 'message' => 'Domicilio eliminado correctamente']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error durante la eliminación: ' . $e->getMessage()]);
        }
    }
    return $this->response->setJSON(['success' => false, 'message' => 'No se pudo encontrar el domicilio a eliminar']);
}
   
   

    
}
