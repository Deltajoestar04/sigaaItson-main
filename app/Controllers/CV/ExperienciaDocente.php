<?php

namespace App\Controllers\CV;

use App\Controllers\BaseController;

use App\Models\UsuarioModel;
use App\Models\CV\ExperienciaDocente\ExperienciaDocenteModel;
use App\Models\CV\ExperienciaDocente\ClaseImpartidaModel;
use App\Models\CV\ExperienciaDocente\ProyectoModel;
use App\Models\CV\ExperienciaDocente\InvestigacionModel;
use App\Models\CV\ExperienciaDocente\AutoresModel;
use App\Models\CV\ExperienciaDocente\DocenciaModel;
use App\Models\CV\ExperienciaDocente\VinculacionModel;
use App\Models\CV\ExperienciaDocente\EventoAcademicoModel;
use App\Models\CapacitacionModel;

class ExperienciaDocente extends BaseController
{

    private $UsuarioModel;
    private $ExperienciaDocenteModel;
    private $ClaseImpartidaModel;
    private $ProyectoModel;
    private $InvestigacionModel;
    private $AutoresModel;
    private $DocenciaModel;
    private $VinculacionModel;
    private $EventoAcademicoModel;

    private $CapacitacionModel;

    public function __construct()
    {

        $this->UsuarioModel = new UsuarioModel();
        $this->ExperienciaDocenteModel = new ExperienciaDocenteModel();
        $this->ClaseImpartidaModel = new ClaseImpartidaModel();
        $this->ProyectoModel = new ProyectoModel();
        $this->InvestigacionModel = new InvestigacionModel();
        $this->AutoresModel = new AutoresModel();
        $this->CapacitacionModel = new CapacitacionModel();
        $this->VinculacionModel = new VinculacionModel();
        $this->DocenciaModel = new DocenciaModel();
        $this->EventoAcademicoModel = new EventoAcademicoModel();

    }



    //Muestra la página principal de experiencia docente

    public function index()
    {
        $id = session()->get('id');

        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        // Obtener datos de los modelos
        $experienciasDocente = $this->ExperienciaDocenteModel->where('id_usuario', $id)->findAll();
        $proyectos = $this->ProyectoModel->where('id_usuario', $id)->findAll();
        $capacitacionesSeleccionadas = $this->CapacitacionModel->where('id_usuario', $id)->where('mostrar_cv', 1)->findAll();
        $todasLasCapacitaciones = $this->CapacitacionModel->where('id_usuario', $id)->where('estado', 'aceptado')->findAll();
        $vinculaciones = $this->VinculacionModel->where('id_usuario', $id)->findAll();
        $eventosAcademicos = $this->EventoAcademicoModel->where('id_usuario', $id)->findAll();

        // Usar el nuevo método para obtener investigaciones con autores
        $investigaciones = $this->InvestigacionModel->findInvestigacionWithAuthorsById($id);

        $docencias = $this->DocenciaModel->where('id_usuario', $id)->findAll();
        $data = [
            'experienciasDocente' => $experienciasDocente,
            'proyectos' => $proyectos,
            'capacitacionesSeleccionadas' => $capacitacionesSeleccionadas,
            'todasLasCapacitaciones' => $todasLasCapacitaciones,
            'investigaciones' => $investigaciones,
            'docencias' => $docencias,
            'vinculaciones' => $vinculaciones,
            'eventosAcademicos' => $eventosAcademicos
        ];

        return view('Cvs/ExperienciasDocentes/index', $data);
    }


    //Funciones de Experiencia Docente

    //Guarda o actualiza una experiencia docente

    public function save()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'institucion' => 'required|string|max_length[100]',
                'puesto_area' => 'required|string|max_length[100]',
                'mes_inicio' => 'required',
                'anio_inicio' => 'required',
                'mes_fin' => 'permit_empty',
                'anio_fin' => 'permit_empty',
                'actualmente' => 'permit_empty|in_list[0,1]'
            ],
            [
                'institucion' => [
                    'required' => 'El campo institución es obligatorio',
                    'string' => 'El campo institución debe ser una cadena de texto',
                    'max_length' => 'El campo institución no debe exceder 100 caracteres'
                ],
                'puesto_area' => [
                    'required' => 'El campo puesto/área es obligatorio',
                    'string' => 'El campo puesto/área debe ser una cadena de texto',
                    'max_length' => 'El campo puesto/área no debe exceder 100 caracteres'
                ],
                'mes_inicio' => [
                    'required' => 'El campo mes de inicio es obligatorio'
                ],
                'anio_inicio' => [
                    'required' => 'El campo año de inicio es obligatorio'
                ]
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $idExperienciaDocente = esc($this->request->getPost('id_experiencia_docente'));

        $ExperienciaDocenteData = [
            'id_usuario' => esc($id),
            'institucion' => esc($this->request->getPost('institucion')),
            'puesto_area' => esc($this->request->getPost('puesto_area')),
            'mes_inicio' => esc($this->request->getPost('mes_inicio')),
            'anio_inicio' => esc($this->request->getPost('anio_inicio')),
            'actualmente' => esc($this->request->getPost('actualmente') == '1' ? 1 : 0)
        ];

        if ($ExperienciaDocenteData['actualmente'] == 0) {
            $ExperienciaDocenteData['mes_fin'] = esc($this->request->getPost('mes_fin'));
            $ExperienciaDocenteData['anio_fin'] = esc($this->request->getPost('anio_fin'));
        } else {
            $ExperienciaDocenteData['mes_fin'] = null;
            $ExperienciaDocenteData['anio_fin'] = null;
        }

        try {
            if ($idExperienciaDocente) {
                $this->ExperienciaDocenteModel->update($idExperienciaDocente, $ExperienciaDocenteData);
                $message = 'Experiencia docente actualizada correctamente';
            } else {
                $this->ExperienciaDocenteModel->insert($ExperienciaDocenteData);
                $message = 'Experiencia docente guardada correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }

    // Elimina una experiencia docente
    public function delete($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $experiencia = $this->ExperienciaDocenteModel->where('id', $id)->where('id_usuario', $id_usuario)->first();

            if (!$experiencia) {
                return $this->response->setJSON(['success' => false, 'message' => 'Experiencia docente no encontrada o no autorizada']);
            }

            if ($this->ExperienciaDocenteModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Experiencia docente eliminada correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar la experiencia docente']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar la experiencia docente: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }


    //Funciones de Clases Impartidas

    // Trae las clases impartidas de una experiencia docente


    public function getClasses($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $experiencia = $this->ExperienciaDocenteModel->where('id', $id)->where('id_usuario', $id_usuario)->first();
            if (!$experiencia) {
                return $this->response->setJSON(['success' => false, 'message' => 'Experiencia docente no encontrada o no autorizada']);
            }

            $clases = $this->ClaseImpartidaModel->where('id_experiencia_docente', $id)->findAll();
            return $this->response->setJSON(['success' => true, 'data' => $clases]);
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener las clases: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }

    // Muestra la vista de gestión de clases impartidas
    public function manageClasses($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return redirect()->to('/login')->with('error', 'Sesión no válida');
        }

        $experienciaDocente = $this->ExperienciaDocenteModel->where('id', $id)->where('id_usuario', $id_usuario)->first();
        if (!$experienciaDocente) {
            return redirect()->back()->with('error', 'Experiencia docente no encontrada o no autorizada');
        }

        $clasesImpartidas = $this->ClaseImpartidaModel->where('id_experiencia_docente', $id)->findAll();

        $data = [
            'experienciaDocente' => $experienciaDocente,
            'clasesImpartidas' => $clasesImpartidas
        ];

        return view('Cvs/ExperienciasDocentes/gestionarClases', $data);
    }

    // Guarda o actualiza una clase impartida
    public function saveClass()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'id_experiencia_docente' => 'required',
                'nombre_clase' => 'required|string|max_length[100]',
                'programa_educativo' => 'required|string|max_length[100]',
                'numero_horas' => 'required|integer'
            ],
            [
                'id_experiencia_docente' => [
                    'required' => 'El ID de experiencia docente es obligatorio',
                ],
                'nombre_clase' => [
                    'required' => 'El nombre de la clase es obligatorio',
                    'string' => 'El nombre de la clase debe ser una cadena de texto',
                    'max_length' => 'El nombre de la clase no debe exceder 100 caracteres'
                ],
                'programa_educativo' => [
                    'required' => 'El programa educativo es obligatorio',
                    'string' => 'El programa educativo debe ser una cadena de texto',
                    'max_length' => 'El programa educativo no debe exceder 100 caracteres'
                ],
                'numero_horas' => [
                    'required' => 'El número de horas es obligatorio',
                    'integer' => 'El número de horas debe ser un número entero'
                ]
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $idClaseImpartida = esc($this->request->getPost('id_clase_impartida'));

        $claseData = [
            'id_experiencia_docente' => esc($this->request->getPost('id_experiencia_docente')),
            'nombre_clase' => esc($this->request->getPost('nombre_clase')),
            'programa_educativo' => esc($this->request->getPost('programa_educativo')),
            'numero_horas' => esc($this->request->getPost('numero_horas'))
        ];

        try {
            $experiencia = $this->ExperienciaDocenteModel->where('id', $claseData['id_experiencia_docente'])->where('id_usuario', $id)->first();
            if (!$experiencia) {
                return $this->response->setJSON(['success' => false, 'message' => 'Experiencia docente no encontrada o no autorizada']);
            }

            if ($idClaseImpartida) {
                $this->ClaseImpartidaModel->update($idClaseImpartida, $claseData);
                $message = 'Clase impartida actualizada correctamente';
            } else {
                $this->ClaseImpartidaModel->insert($claseData);
                $message = 'Clase impartida guardada correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar la clase impartida: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }

    // Elimina una clase impartida
    public function deleteClass($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            if ($this->ClaseImpartidaModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Clase impartida eliminada correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar la clase impartida']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar la clase: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error inesperado']);
        }
    }

    //Funciones de Proyectos

    // Guarda o actualiza un proyecto

    public function saveProject()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        $validation = \Config\Services::validation();

        // Define las reglas de validación
        $validationRules = [
            'nombre' => 'required|string|max_length[255]',
            'tipo' => 'required|in_list[Investigacion,Desarrollo,Vinculacion]',
            'tipo_financiamiento' => 'required|in_list[Interno,Externo]',
            'nombre_organismo_externo' => 'max_length[255]',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ];

        // Define los mensajes de validación
        $validationMessages = [
            'nombre' => [
                'required' => 'El nombre del proyecto es obligatorio',
                'string' => 'El nombre del proyecto debe ser una cadena de texto',
                'max_length' => 'El nombre del proyecto no debe exceder 255 caracteres'
            ],
            'tipo' => [
                'required' => 'El tipo de proyecto es obligatorio',
                'in_list' => 'El tipo de proyecto no es válido'
            ],
            'tipo_financiamiento' => [
                'required' => 'El tipo de financiamiento es obligatorio',
                'in_list' => 'El tipo de financiamiento no es válido'
            ],
            'nombre_organismo_externo' => [
                'max_length' => 'El nombre del organismo externo no debe exceder 255 caracteres'
            ],
            'fecha_inicio' => [
                'required' => 'La fecha de inicio es obligatoria'
            ],
            'fecha_fin' => [
                'required' => 'La fecha de fin es obligatoria'
            ]
        ];


        $tipoFinanciamiento = $this->request->getPost('tipo_financiamiento');
        if ($tipoFinanciamiento === 'Externo') {
            $validationRules['nombre_organismo_externo'] = 'required|max_length[255]';
            $validationMessages['nombre_organismo_externo']['required'] = 'El nombre del organismo externo es obligatorio';
        }

        $validation->setRules($validationRules, $validationMessages);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
        $idProyecto = esc($this->request->getPost('id_proyecto'));

        $ProyectoData = [
            'id_usuario' => esc($id),
            'nombre' => esc($this->request->getPost('nombre')),
            'tipo' => esc($this->request->getPost('tipo')),
            'tipo_financiamiento' => esc($this->request->getPost('tipo_financiamiento')),
            'nombre_organismo_externo' => esc($this->request->getPost('nombre_organismo_externo')),
            'fecha_inicio' => esc($this->request->getPost('fecha_inicio')),
            'fecha_fin' => esc($this->request->getPost('fecha_fin'))
        ];


        // Si el tipo de financiamiento es Interno, se debe eliminar el nombre del organismo externo
        if ($ProyectoData['tipo_financiamiento'] == 'Interno') {
            $ProyectoData['nombre_organismo_externo'] = null;
        }

        try {
            if ($idProyecto) {
                $this->ProyectoModel->update($idProyecto, $ProyectoData);
                $message = 'Proyecto actualizado correctamente';
            } else {
                $this->ProyectoModel->insert($ProyectoData);
                $message = 'Proyecto guardado correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }


    // Elimina un proyecto
    public function deleteProject($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $proyecto = $this->ProyectoModel->where('id', $id)->where('id_usuario', $id_usuario)->first();
            if (!$proyecto) {
                return $this->response->setJSON(['success' => false, 'message' => 'Proyecto no encontrado o no autorizado']);
            }

            if ($this->ProyectoModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Proyecto eliminado correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar el proyecto']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar el proyecto: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }

    //Funciones de Capacitación

    // Obtiene las capacitaciones seleccionadas para el CV

    public function getCapacitacionesSeleccionadas()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        $capacitaciones = $this->CapacitacionModel
            ->where('id_usuario', $id)
            ->where('mostrar_cv', 1)
            ->where('estado', 'aceptado')
            ->findAll();

        return $this->response->setJSON(['success' => true, 'data' => $capacitaciones]);
    }

    // Actualiza las capacitaciones seleccionadas para el CV
    public function actualizarCapacitaciones()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        $capacitacionesSeleccionadas = $this->request->getPost('capacitaciones');

        try {
            // Primero, establecemos todas las capacitaciones del usuario a no mostrar en CV
            $this->CapacitacionModel->where('id_usuario', $id)->set(['mostrar_cv' => 0])->update();

            // Luego, actualizamos las capacitaciones seleccionadas
            if (!empty($capacitacionesSeleccionadas)) {
                $this->CapacitacionModel->whereIn('id', $capacitacionesSeleccionadas)->set(['mostrar_cv' => 1])->update();
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Capacitaciones actualizadas con éxito']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar capacitaciones: ' . $e->getMessage()]);
        }
    }


    //Quita una capacitación del CV

    public function quitarCapacitacion()
    {
        $id = $this->request->getPost('id');
        $idUsuario = session()->get('id');

        if (empty($idUsuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $result = $this->CapacitacionModel->where('id', $id)->where('id_usuario', $idUsuario)->set(['mostrar_cv' => 0])->update();

            if ($result) {
                return $this->response->setJSON(['success' => true, 'message' => 'Capacitación quitada con éxito']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'No se pudo quitar la capacitación']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al quitar la capacitación: ' . $e->getMessage()]);
        }
    }


    //Funciones de Investigación

    // Guarda o actualiza una investigación

    public function saveInvestigacion()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'titulo' => 'required',
                'anio' => 'required|integer|exact_length[4]',
                'fuente' => 'required',
                'url_doi' => 'permit_empty|valid_url',
                'editorial' => 'required',
                'indiz' => 'permit_empty',
                'tipo' => 'required',
                'autores' => 'required'
            ],
            [
                'titulo' => ['required' => 'El título es requerido'],
                'anio' => ['required' => 'El año es requerido', 'integer' => 'El año debe ser un número entero', 'exact_length' => 'El año debe tener 4 dígitos'],
                'fuente' => ['required' => 'La fuente es requerida'],
                'url_doi' => ['valid_url' => 'El URL debe ser válido'],
                'editorial' => ['required' => 'La editorial es requerida'],
                'indiz' => ['permit_empty' => 'El índice es opcional'],
                'tipo' => ['required' => 'El tipo es requerido'],
                'autores' => ['required' => 'Debe haber al menos un autor']
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
        $idInvestigacion = esc($this->request->getPost('id_investigacion'));
        $autores = esc($this->request->getPost('autores'));

        $investigacionData = [
            'id_usuario' => esc($id),
            'titulo' => esc($this->request->getPost('titulo')),
            'anio' => esc($this->request->getPost('anio')),
            'fuente' => esc($this->request->getPost('fuente')),
            'url_doi' => esc($this->request->getPost('url_doi')),
            'editorial' => esc($this->request->getPost('editorial')),
            'indiz' => esc($this->request->getPost('indiz')),
            'tipo' => esc($this->request->getPost('tipo'))
        ];


        $result = $this->InvestigacionModel->saveInvestigacionWithAutores($investigacionData, $autores, $idInvestigacion);

        return $this->response->setJSON($result);

    }

    //Elimina una investigación
    public function deleteInvestigacion($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $investigacion = $this->InvestigacionModel->where('id', $id)->where('id_usuario', $id_usuario)->first();
            if (!$investigacion) {
                return $this->response->setJSON(['success' => false, 'message' => 'Investigación no encontrada o no autorizada']);
            }

            if ($this->InvestigacionModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Investigación eliminada correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar la investigación']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar la investigación: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }



    //Funciones de Docencia

    // Guarda o actualiza una docencia

    public function saveDocencia()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        // Reglas de validación
        $validation = \Config\Services::validation();
        $validation->setRules([
            'libro' => 'permit_empty',
            'manual_practica' => 'permit_empty',
            'material_didactico' => 'permit_empty'
        ], [
            'libro' => ['permit_empty' => 'El libro es requerido si se proporciona otro campo'],
            'manual_practica' => ['permit_empty' => 'El manual de práctica es requerido si se proporciona otro campo'],
            'material_didactico' => ['permit_empty' => 'El material didáctico es requerido si se proporciona otro campo']
        ]);

        // Ejecutar validación
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        // Validar que al menos uno de los campos tenga valor
        $libro = $this->request->getPost('libro');
        $manual_practica = $this->request->getPost('manual_practica');
        $material_didactico = $this->request->getPost('material_didactico');

        if (empty($libro) && empty($manual_practica) && empty($material_didactico)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Debe proporcionar al menos uno de los campos: Libro, Manual de Práctica, o Material Didáctico.']);
        }

        $idDocencia = esc($this->request->getPost('id_docencia'));

        $docenciaData = [
            'id_usuario' => esc($id),
            'libro' => esc($libro),
            'manual_practica' => esc($manual_practica),
            'material_didactico' => esc($material_didactico)
        ];

        try {
            if ($idDocencia) {
                $this->DocenciaModel->update($idDocencia, $docenciaData);
                $message = 'Docencia actualizada correctamente';
            } else {
                $this->DocenciaModel->insert($docenciaData);
                $message = 'Docencia guardada correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }


    //Elimina una docencia

    public function deleteDocencia($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $docencia = $this->DocenciaModel->where('id', $id)->where('id_usuario', $id_usuario)->first();
            if (!$docencia) {
                return $this->response->setJSON(['success' => false, 'message' => 'Docencia no encontrada o no autorizada']);
            }

            if ($this->DocenciaModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Docencia eliminada correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar la docencia']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar la docencia: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }

    public function saveVinculacion()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

  
        $patente = $this->request->getPost('patente');
        $convenioIndustrial = $this->request->getPost('convenio_industrial');
        $servicioIndustrial = $this->request->getPost('servicio_industrial');

      
        if (empty($patente) && empty($convenioIndustrial) && empty($servicioIndustrial)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Debe proporcionar al menos uno de los campos: Patente, Convenio Industrial, o Servicio Industrial.']);
        }
        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'patente' => 'required',
                'convenio_industrial' => 'required',
                'servicio_industrial' => 'required'
            ],
            [
                'patente' => ['required' => 'La patente es requerida'],
                'convenio_industrial' => ['required' => 'El convenio industrial es requerido'],
                'servicio_industrial' => ['required' => 'El servicio industrial es requerido']
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $idVinculacion = esc($this->request->getPost('id_vinculacion'));

        $vinculacionData = [
            'id_usuario' => esc($id),
            'patente' => esc($this->request->getPost('patente')),
            'convenio_industrial' => esc($this->request->getPost('convenio_industrial')),
            'servicio_industrial' => esc($this->request->getPost('servicio_industrial'))
        ];


        try {
            if ($idVinculacion) {
                $this->VinculacionModel->update($idVinculacion, $vinculacionData);
                $message = 'Vinculación actualizada correctamente';
            } else {
                $this->VinculacionModel->insert($vinculacionData);
                $message = 'Vinculación guardada correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }

    }

    //Elimina una vinculación
    public function deleteVinculacion($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $vinculacion = $this->VinculacionModel->where('id', $id)->where('id_usuario', $id_usuario)->first();
            if (!$vinculacion) {
                return $this->response->setJSON(['success' => false, 'message' => 'Vinculación no encontrada o no autorizada']);
            }

            if ($this->VinculacionModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Vinculación eliminada correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar la vinculación']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar la vinculación: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);

        }
    }

    //Funciones de eventos academicos
    //Guardar/editar evento academico

    public function saveEventoAcademico()
    {

        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'nombre_ponencia' => 'required|max_length[255]',
                'nombre_evento' => 'required|max_length[255]',
                'lugar' => 'required|max_length[45]',
                'fecha' => 'required',
                'pais' => 'required|max_length[20]'

            ],
            [
                'nombre_ponencia' => [
                    'required' => 'El campo nombre de la ponencia es obligatorio',
                    'max_length' => 'El campo nombre de la ponencia no debe exceder 255 caracteres'
                ],
                'nombre_evento' => [
                    'required' => 'El campo nombre del evento es obligatorio',
                    'max_length' => 'El campo nombre del evento no debe exceder 255 caracteres'
                ],
                'lugar' => [
                    'required' => 'El campo lugar es obligatorio',
                    'max_length' => 'El campo lugar no debe exceder 45 caracteres'
                ],
                'fecha' => [
                    'required' => 'El campo fecha es obligatorio'
                ],
                'pais' => [
                    'required' => 'El campo país es obligatorio',
                    'max_length' => 'El campo país no debe exceder 20 caracteres'
                ]
            ]
        );


        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
        $idEventoAcademico = esc($this->request->getPost('id_evento_academico'));

        $eventoAcademicoData = [
            'id_usuario' => esc($id),
            'nombre_ponencia' => esc($this->request->getPost('nombre_ponencia')),
            'nombre_evento' => esc($this->request->getPost('nombre_evento')),
            'lugar' => esc($this->request->getPost('lugar')),
            'fecha' => esc($this->request->getPost('fecha')),
            'pais' => esc($this->request->getPost('pais'))
        ];


        try {
            if ($idEventoAcademico) {
                $this->EventoAcademicoModel->update($idEventoAcademico, $eventoAcademicoData);
                $message = 'Evento académico actualizado correctamente';
            } else {
                $this->EventoAcademicoModel->insert($eventoAcademicoData);
                $message = 'Evento académico guardado correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }



    }


    //Eliminar evento academico
    public function deleteEventoAcademico($id)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }

        try {
            $eventoAcademico = $this->EventoAcademicoModel->where('id', $id)->where('id_usuario', $id_usuario)->first();
            if (!$eventoAcademico) {
                return $this->response->setJSON(['success' => false, 'message' => 'Evento académico no encontrado o no autorizado']);
            }

            if ($this->EventoAcademicoModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Evento académico eliminado correctamente']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar el evento académico']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar el evento académico: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al procesar la solicitud']);
        }
    }

}