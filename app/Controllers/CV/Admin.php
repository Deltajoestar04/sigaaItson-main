<?php 

namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\CV\DatosGenerales\DatosGeneralesModel;
use App\Models\CV\DatosGenerales\DomicilioModel;
use App\Models\CV\DatosGenerales\UbicacionModel;
use App\Models\CV\ExperienciaLaboral\ExperienciaLaboralModel;
use App\Models\CV\ExperienciaDocente\ExperienciaDocenteModel;
use App\Models\CV\ExperienciaDocente\ProyectoModel;
use App\Models\CV\ExperienciaDocente\DocenciaModel;
use App\Models\CapacitacionModel;
use App\Models\CV\ExperienciaDocente\VinculacionModel;
use App\Models\CV\ExperienciaDocente\EventoAcademicoModel;
use App\Models\CV\ExperienciaDocente\InvestigacionModel;
use App\Models\CV\AsociacionProfesional\AsociacionProfesionalModel;
use App\Models\CV\Logros\LogroModel;
use App\Models\CV\Premios\PremioModel;
use App\Models\CV\ExperieciaDocente\CalificacionModel;
use App\Models\CV\ExperienciaDocente\ClaseImpartidaModel;
use Mpdf\Mpdf;


class Admin extends BaseController
{
    private $UsuarioModel;
    private $DatosGeneralesModel;
    private $DomicilioModel;
    private $UbicacionModel;
    private $ExperienciaLaboralModel;
    private $ExperienciaDocenteModel;
    private $ProyectoModel;
    private $CapacitacionModel;
    private $VinculacionModel;
    private $EventoAcademicoModel;
    private $InvestigacionModel;
    private $AsociacionProfesionalModel;
    private $CalificacionModel;
    private $LogroModel;
    private $PremioModel;
    private $DocenciaModel;
    private $ClaseImpartidaModel;


    public function __construct()
    {
        $this->UsuarioModel = new UsuarioModel();
        $this->DatosGeneralesModel = new DatosGeneralesModel();
        $this->DomicilioModel = new DomicilioModel();
        $this->UbicacionModel = new UbicacionModel();
        $this->ExperienciaLaboralModel = new ExperienciaLaboralModel();
        $this->ExperienciaDocenteModel = new ExperienciaDocenteModel();
        $this->ProyectoModel = new ProyectoModel();
        $this->CapacitacionModel = new CapacitacionModel();
        $this->VinculacionModel = new VinculacionModel();
        $this->EventoAcademicoModel = new EventoAcademicoModel();
        $this->InvestigacionModel = new InvestigacionModel();
        $this->AsociacionProfesionalModel = new AsociacionProfesionalModel();
        $this->CalificacionModel = new CalificacionModel();
        $this->LogroModel = new LogroModel();
        $this->PremioModel = new PremioModel();
        $this->DocenciaModel = new DocenciaModel();
        $this->ClaseImpartidaModel = new ClaseImpartidaModel();


    }

    public function index()
    {
        $rol = "Maestro";
        $usuarios = $this->UsuarioModel->findUserdByRol($rol);

        $data = [
            'usuarios' => $usuarios
        ];

        return view('Cvs/admin/index', $data);
    }

    public function verCV($slug)
    {
        // Obtener el usuario por el slug
        $usuario = $this->UsuarioModel->getUserBySlug($slug);
    
        if ($usuario) {
            $id = $usuario['id']; // Obtener el ID del usuario desde el slug
            
            // Obtener datos generales
            $datosGenerales = $this->DatosGeneralesModel->findDatosGeneralesById($id);
            
            // Obtener domicilios   
            $domicilios = $this->DomicilioModel->findDomiciliosByIdUsuario($id);
    
            // Obtener experiencias laborales
            $experienciasLaborales = $this->ExperienciaLaboralModel->where('id_usuario', $id)->findAll();
            
            // Obtener experiencias docentes
            $experienciasDocente = $this->ExperienciaDocenteModel->where('id_usuario', $id)->findAll();
            
            // Obtener proyectos
            $proyectos = $this->ProyectoModel->where('id_usuario', $id)->findAll();
            
            // Obtener capacitaciones seleccionadas
            $capacitacionesSeleccionadas = $this->CapacitacionModel->where('id_usuario', $id)->where('mostrar_cv', 1)->findAll();
            
            // Obtener todas las capacitaciones
            $todasLasCapacitaciones = $this->CapacitacionModel->where('id_usuario', $id)->where('estado', 'aceptado')->findAll();
            
            // Obtener vinculaciones
            $vinculaciones = $this->VinculacionModel->where('id_usuario', $id)->findAll();
            
            // Obtener eventos académicos
            $eventosAcademicos = $this->EventoAcademicoModel->where('id_usuario', $id)->findAll();
            
            // Obtener investigaciones con autores
            $investigaciones = $this->InvestigacionModel->findInvestigacionWithAuthorsById($id); 
    
            // Obtener Asociación Profesional
            $asociacionProfesional = $this->AsociacionProfesionalModel->where('id_usuario', $id)->findAll();
    
            //obtener calificacion del docente
            $calificacion = $this->CalificacionModel->where('id_usuario', $id)->findAll();

            // Obtener Logros
            $logros = $this->LogroModel->where('id_usuario', $id)->findAll();
    
            // Obtener Premios
            $premios = $this->PremioModel->where('id_usuario', $id)->findAll();
    
            // Obtener Docencia
            $docencias = $this->DocenciaModel->where('id_usuario', $id)->findAll();
            
            // Combinar datos de domicilio y ubicación
            foreach ($domicilios as &$domicilio) {
                $ubicacion = $this->UbicacionModel->find($domicilio['id_ubicacion']);
                if ($ubicacion) {
                    $domicilio = array_merge($domicilio, $ubicacion);
                }
            }
            
            $data = [
                'usuario' => $usuario,
                'datosGenerales' => $datosGenerales,
                'domicilios' => $domicilios,
                'experienciasLaborales' => $experienciasLaborales,
                'experienciasDocente' => $experienciasDocente,
                'proyectos' => $proyectos,
                'capacitacionesSeleccionadas' => $capacitacionesSeleccionadas,
                'todasLasCapacitaciones' => $todasLasCapacitaciones,
                'investigaciones' => $investigaciones,
                'vinculaciones' => $vinculaciones,
                'eventosAcademicos' => $eventosAcademicos,
                'asociacionProfesional' => $asociacionProfesional,
                'calificacion'=> $calificacion,
                'logros' => $logros,
                'premios' => $premios,
                'docencias' => $docencias
            ];
    
            return view('Cvs/admin/ver_cv', $data);
        } else {
            return redirect()->to('/cv')->with('error', 'Usuario no encontrado');
        }
    }
    
    
    public function getClases($experienciaId)
    {
     
        $clases = $this->ClaseImpartidaModel->getClasesByExperienciaId($experienciaId);
    
  
        return $this->response->setJSON($clases);
    }

    

}
