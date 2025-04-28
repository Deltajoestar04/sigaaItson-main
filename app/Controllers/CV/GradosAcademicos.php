<?php
namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\GradosAcademicos\GradoAcademicoModel;
use App\Models\CV\GradosAcademicos\ProdepModel;
use App\Models\CV\GradosAcademicos\SNIModel;
use App\Models\UsuarioModel;




class GradosAcademicos extends BaseController
{
    protected $GradoAcademicoModel;
    protected $ProdepModel;
    protected $SniModel;
    protected $UsuarioModel;

    public function __construct()
    {

        $this->GradoAcademicoModel = new GradoAcademicoModel();
        $this->ProdepModel = new ProdepModel();
        $this->SniModel = new SNIModel();
        $this->UsuarioModel = new UsuarioModel();
    }
    public function index()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $grados = $this->GradoAcademicoModel->where('id_usuario', $id)->findAll();

            foreach ($grados as &$grado) {
                $prodep = $this->ProdepModel->where('id_grado_academico', $grado['id'])->first();
                $grado['fecha_comienzo'] = $prodep['fecha_comienzo'] ?? null;
                $grado['fecha_termino'] = $prodep['fecha_termino'] ?? null;

                $sni = $this->SniModel->where('id_grado_academico', $grado['id'])->first();
                $grado['nivel'] = $sni['nivel'] ?? null;
            }

            return view('Cvs/GradosAcademicos/index', ['grados' => $grados]);

        } catch (\Exception $e) {
            log_message('error', 'Error al obtener grados académicos: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error al obtener datos']);
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
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_grado' => 'required|alpha_numeric_space',
            'institucion' => 'required|alpha_space',
            'fecha_inicio' => 'required|valid_date',
            'fecha_final' => 'required|valid_date',
            'fecha_titulacion' => 'required|numeric|exact_length[4]',
            'pais' => 'required|alpha_space',
            'no_cedula' => 'required|numeric',
            'tipo_cedula' => 'required|in_list[Federal,Estatal]',
            'fecha_comienzo' => 'permit_empty|valid_date',
            'fecha_termino' => 'permit_empty|valid_date',
            'sni_nivel' => 'permit_empty|in_list[Candidato,1,2,3]'
        ], [
            'nombre_grado' => [
                'required' => "El campo de nombre es requerido",
                'alpha_numeric_space' => "El campo de nombre solo lleva letras, espacios y números",
            ],
            'institucion' => [
                'required' => "El campo institución es requerido",
                'alpha_space' => "El campo de institución solo lleva letras y espacios"
            ],
            'fecha_inicio' => [
                'required' => "El campo de fecha de inicio es requerido",
                'valid_date' => "Fecha de inicio no válida"
            ],
            'fecha_final' => [
                'required' => "El campo de fecha final es requerido",
                'valid_date' => "Fecha final no válida"
            ],
            'fecha_titulacion' => [
                'required' => "El campo de año de titulación es requerido",
                'numeric' => "El campo de año de titulación solo puede tener números",
                'exact_length' => "El campo tiene que tener 4 dígitos"
            ],
            'pais' => [
                'required' => "El campo de país es requerido",
                'alpha_space' => "El campo de país solo lleva letras y espacios"
            ],
            'no_cedula' => [
                'required' => "El campo de No. de Cédula es requerido",
                'numeric' => "El campo de No. de Cédula solo puede tener números"
            ],
            'tipo_cedula' => [
                'required' => "El campo de Tipo de Cédula es requerido",
                'in_list' => "El tipo de cédula debe ser Federal o Estatal"
            ],
            'fecha_comienzo' => [
                'valid_date' => "Fecha de inicio PRODEP no válida"
            ],
            'fecha_termino' => [
                'valid_date' => "Fecha final PRODEP no válida"
            ],
            'sni_nivel' => [
                'in_list' => "El nivel de SNI debe ser Candidato, 1, 2 o 3"
            ]
        ]);

        // Ejecutar la validación
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
  // Validar que la fecha de inicio sea antes de la fecha final
  if (!empty($fechaInicio) && !empty($fechaFinal)) {
    $inicio = new \DateTime($fechaInicio);
    $final = new \DateTime($fechaFinal);

    if ($final < $inicio) {
        return $this->response->setJSON(['success' => false, 'message' => 'La fecha final no puede ser antes que la fecha de inicio.']);
    }
}


        $idGradoAcademico = esc($this->request->getPost('id_grado_academico'));
        $grados_academicos = [
            'nombre_grado' => esc($this->request->getPost("nombre_grado")),
            'institucion' => esc($this->request->getPost("institucion")),
            'pais' => esc($this->request->getPost("pais")),
            'fecha_inicio' => esc($this->request->getPost("fecha_inicio")),
            'fecha_final' => esc($this->request->getPost("fecha_final")),
            'fecha_titulacion' => esc($this->request->getPost("fecha_titulacion")),
            'no_cedula' => esc($this->request->getPost("no_cedula")),
            'tipo_cedula' => esc($this->request->getPost("tipo_cedula")),
            'id_usuario' => esc($id)
        ];
        try {
            if ($idGradoAcademico) {
                $this->GradoAcademicoModel->update($idGradoAcademico, $grados_academicos);
                $message = 'Grado académico actualizado correctamente';
            } else {
                $idGradoAcademico = $this->GradoAcademicoModel->insert($grados_academicos);
                $message = 'Grado académico guardado correctamente';
            }

            // Manejar PRODEP
            if ($this->request->getPost("prodep_check") == 'on') {
                $prodep = [
                    'id_grado_academico' => $idGradoAcademico,
                    'fecha_comienzo' => $this->request->getPost("fecha_comienzo"),
                    'fecha_termino' => $this->request->getPost("fecha_termino")
                ];
                $existingProdep = $this->ProdepModel->where('id_grado_academico', $idGradoAcademico)->first();
                if ($existingProdep) {
                    $this->ProdepModel->update($existingProdep['id'], $prodep);
                } else {
                    $this->ProdepModel->insert($prodep);
                }
            } else {
                // Si el checkbox no está marcado, eliminar el registro PRODEP si existe
                $this->ProdepModel->where('id_grado_academico', $idGradoAcademico)->delete();
            }

            // Manejar SNI
            if ($this->request->getPost("sni_check") == 'on') {
                $sni = [
                    'id_grado_academico' => $idGradoAcademico,
                    'nivel' => $this->request->getPost("sni_nivel")
                ];
                $existingSni = $this->SniModel->where('id_grado_academico', $idGradoAcademico)->first();
                if ($existingSni) {
                    $this->SniModel->update($existingSni['id'], $sni);
                } else {
                    $this->SniModel->insert($sni);
                }
            } else {
                // Si el checkbox no está marcado, eliminar el registro SNI si existe
                $this->SniModel->where('id_grado_academico', $idGradoAcademico)->delete();
            }

            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar el grado académico: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        // Get the logged-in user's ID from the session
        $id_usuario = session()->get('id');

        // Check if the user is logged in
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            // Find the grado académico record for the logged-in user
            $gradoAcademico = $this->GradoAcademicoModel->where('id', $id)
                ->where('id_usuario', $id_usuario) // Adjust this if the field name is different
                ->first();

            // Check if the record exists and is associated with the logged-in user
            if (!$gradoAcademico) {
                return $this->response->setJSON(['success' => false, 'message' => 'Grado académico no encontrado o no autorizado']);
            }

            // Delete the grado académico record
            if ($this->GradoAcademicoModel->delete($id)) {
                // Delete associated PRODEP records
                $this->ProdepModel->where('id_grado_academico', $id)->delete();

                // Delete associated SNI records
                $this->SniModel->where('id_grado_academico', $id)->delete();

                return $this->response->setJSON(['success' => true, 'message' => 'Grado académico eliminado correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar el grado académico']);
            }
        } catch (\Exception $e) {
            // Log the error message
            log_message('error', 'Error al eliminar el grado académico: ' . $e->getMessage());

            // Return a JSON response indicating an error
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }


}