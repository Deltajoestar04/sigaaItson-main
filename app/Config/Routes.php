<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Usuarios
$routes->get('/usuarios/agregar', 'Usuario::form', ['filter' => 'authentication']);
$routes->get('/usuario/perfil', 'Usuario::perfil', ['filter' => 'authentication']);
$routes->get('/usuario/perfil/(:num)', 'Usuario::perfil/$1', ['filter' => 'authentication']);
$routes->get('/usuarios', 'Usuario::index', ['filter' => 'authentication']);
$routes->get('/usuarios/editar/(:segment)', 'Usuario::edit/$1', ['filter' => 'authentication']);
$routes->delete('/usuarios/eliminar/(:num)', 'Usuario::delete/$1', ['filter' => 'authentication']);
$routes->get("/contrasena_olvidada", "Usuario::contrasena_olvidada");
$routes->post("/recuperacion_contrasena", "Usuario::recuperacion_contrasena");
$routes->get("/restablecer_contrasena/(:any)", "Usuario::restablecer_contrasena/$1");

// Home (inicio)
$routes->get('/', 'Home::index');
$routes->post('/iniciar-sesion', 'Home::iniciarSesion');
$routes->get("/proximo", "Home::proximo", ['filter' => 'authentication']);
$routes->get("/reporte", "Home::reporte", ['filter' => 'authentication']);
$routes->get('/exito', 'Home::success', ['filter' => 'authentication']);
$routes->get('/menu','Home::menu', ['filter' => 'authentication']);
$routes->get('/registrar', 'Home::registro');
$routes->get('/registrar', 'Usuario::registrar');
$routes->post("/reiniciar_contrasena", "Usuario::reiniciar_contrasena");
$routes->get("/reportes", "Home::reporte",  ['filter' => 'authentication']);
$routes->get("/salir", "Home::logout");

// Capacitaciones
$routes->get('/capacitaciones', 'Capacitacion::index', ['filter' => 'authentication']);
$routes->get('/capacitaciones/agregar', 'Capacitacion::form', ['filter' => 'authentication']);
$routes->get('/capacitaciones/editar/(:segment)', 'Capacitacion::edit/$1', ['filter' => 'authentication']);
$routes->get('/capacitaciones/(:segment)', 'Capacitacion::capacitaciones/$1', ['filter' => 'authentication']);
$routes->get('/capacitaciones/horas/(:num)', 'Capacitacion::verHoras/$1', ['filter' => 'authentication']);
$routes->get('/capacitaciones/eliminar/(:num)', 'Capacitacion::delete/$1', ['filter' => 'authentication']);
$routes->get('/capacitaciones/mostrar/(:segment)', 'Capacitacion::show/$1', ['filter' => 'authentication']);
$routes->get('/capacitaciones/estado/(:num)/(:alphanum)', 'Capacitacion::updateStatus/$1/$2', ['filter' => 'authentication']);
$routes->get("/capacitaciones/motivo_correo/(:num)/(:segment)", "Capacitacion::motivo_correo/$1/$2", ['filter' => 'authentication']);
$routes->get("/capacitaciones/aviso_correo/(:num)", "Capacitacion::aviso_correo/$1", ['filter' => 'authentication']);
$routes->get('capacitaciones/(:num)', 'Capacitacion::capacitacionesMaestro/$1', ['filter' => 'authentication']);

// Cv


// CV
$routes->get('/cv', 'CV\Admin::index', ['filter' => 'authentication']);
$routes->get('/admin/ver_cv/(:segment)', 'CV\Admin::verCV/$1', ['filter' => 'authentication']);
$routes->get('/cv/Admin/getClases/(:num)', 'CV\Admin::getClases/$1',['filter' => 'authentication']);



// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// DatosGenerales
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice
$routes->get('/cv/datosgenerales', 'CV\DatosGenerales::index', ['filter' => 'authentication']);
// Ruta para editar
$routes->get('/cv/datosgenerales/editarInformacion', 'CV\DatosGenerales::editInformation', ['filter' => 'authentication']);

$routes->post('/cv/datosgenerales/updateInformation/(:num)', 'CV\DatosGenerales::updateInformation/$1', ['filter' => 'authentication']);


// Domicilio
$routes->post('/cv/datosgenerales/saveAddress', 'CV\DatosGenerales::saveAddress', ['filter' => 'authentication']);
$routes->post('/cv/datosgenerales/deleteAddress/(:num)', 'CV\DatosGenerales::deleteAddress/$1', ['filter' => 'authentication']);
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// GradosAcademicos
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice
$routes->get('/cv/gradosacademicos', 'CV\GradosAcademicos::index', ['filter' => 'authentication']);
// Ruta para guardar
$routes->post('/cv/gradosacademicos/save', 'CV\GradosAcademicos::save', ['filter' => 'authentication']);
// Ruta para eliminar
$routes->post('/cv/gradosacademicos/delete/(:num)', 'CV\GradosAcademicos::delete/$1', ['filter' => 'authentication']);


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ExperienciaLaboral
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice
$routes->get('/cv/experiencialaboral', 'CV\ExperienciaLaboral::index', ['filter' => 'authentication']);
// Ruta para guardar
$routes->post('/cv/experiencialaboral/save', 'CV\ExperienciaLaboral::save', ['filter' => 'authentication']);
// Ruta para eliminar
$routes->post('/cv/experiencialaboral/delete/(:num)', 'CV\ExperienciaLaboral::delete/$1', ['filter' => 'authentication']);



// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ExperienciaDocente
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice
$routes->get('/cv/experienciadocente', 'CV\ExperienciaDocente::index', ['filter' => 'authentication']);
// Ruta para guardar experienca docente
$routes->post('/cv/experienciadocente/save', 'CV\ExperienciaDocente::save', ['filter' => 'authentication']);
// Ruta para eliminar experiencia docente
$routes->post('/cv/experienciadocente/delete/(:num)', 'CV\ExperienciaDocente::delete/$1', ['filter' => 'authentication']);

$routes->get('/cv/experienciadocente/manageClasses/(:num)', 'CV\ExperienciaDocente::manageClasses/$1',['filter' => 'authentication']);

//Ruta para guardar proyecto
$routes->post('/cv/experienciadocente/saveProject', 'CV\ExperienciaDocente::saveProject', ['filter' => 'authentication']);
//Ruta para eliminar el proyecto
$routes->post('/cv/experienciadocente/deleteProject/(:num)', 'CV\ExperienciaDocente::deleteProject/$1', ['filter' => 'authentication']);




//Ruta para guardar docencia
$routes->post('/cv/experienciadocente/saveDocencia', 'CV\ExperienciaDocente::saveDocencia', ['filter' => 'authentication']);
//Ruta para eliminar el docencia
$routes->post('/cv/experienciadocente/deleteDocencia/(:num)', 'CV\ExperienciaDocente::deleteDocencia/$1', ['filter' => 'authentication']);

//Ruta para guardar investigacion
$routes->post('/cv/experienciadocente/saveInvestigacion', 'CV\ExperienciaDocente::saveInvestigacion', ['filter' => 'authentication']);
//Ruta para eliminar la investigacion
$routes->post('/cv/experienciadocente/deleteInvestigacion/(:num)', 'CV\ExperienciaDocente::deleteInvestigacion/$1', ['filter' => 'authentication']);


//Ruta para guardar vinculacion
$routes->post('/cv/experienciadocente/saveVinculacion', 'CV\ExperienciaDocente::saveVinculacion', ['filter' => 'authentication']);
//Ruta para eliminar la vinculacion
$routes->post('/cv/experienciadocente/deleteVinculacion/(:num)', 'CV\ExperienciaDocente::deleteVinculacion/$1', ['filter' => 'authentication']);

//Ruta para guardar eventos academicos
$routes->post('/cv/experienciadocente/saveEventoAcademico', 'CV\ExperienciaDocente::saveEventoAcademico', ['filter' => 'authentication']);
//Ruta para eliminar la investigacion
$routes->post('/cv/experienciadocente/deleteEventoAcademico/(:num)', 'CV\ExperienciaDocente::deleteEventoAcademico/$1', ['filter' => 'authentication']);


//$routes->post('/cv/experienciadocente/getCapacitacionesSeleccionadas', 'CV\ExperienciaDocente::getCapacitacionesSeleccionadas', ['filter' => 'authentication']);
$routes->post('/cv/experienciadocente/actualizarCapacitaciones', 'CV\ExperienciaDocente::actualizarCapacitaciones', ['filter' => 'authentication']);
$routes->post('/cv/experienciadocente/quitarCapacitacion', 'CV\ExperienciaDocente::quitarCapacitacion', ['filter' => 'authentication']);

// Clases Impartidas
//Ruta para ver las clases impartidas
$routes->get('/cv/experienciadocente/getClases/(:num)', 'CV\ExperienciaDocente::getClases/$1');
//Ruta para guardar una clase impartida
$routes->post('/cv/experienciadocente/saveClass', 'CV\ExperienciaDocente::saveClass');
//Ruta para eliminar una clase impartida
$routes->post('/cv/experienciadocente/deleteClass/(:num)', 'CV\ExperienciaDocente::deleteClass/$1');

$routes->get('/cv/experienciadocente/manageClasses/(:num)', 'Cv\ExperienciaDocente::manageClasses/$1');


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Indicadores
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice

$routes->get('/Indicador', 'Indicador::index');

$routes->post('indicador/actualizar', 'Indicador::actualizar');

//Guardar
$routes->post('indicador/guardar', 'Indicador::guardar');
//Ruta para ver los indicadores
$routes->get('/Indicador/(:num)', 'Indicador::verIndicadores/$1');
//Ruta para ver los indicadores por programa educativo
$routes->get('/Indicador/indicadoresPorPrograma/(:num)', 'Indicador::verIndicadoresPorPrograma/$1');
//Ruta para ver los indicadores por usuario
$routes->get('/Indicador/indicadoresPorUsuario/(:num)', 'Indicador::verIndicadoresPorUsuario/$1');
//Ruta para ver los indicadores por usuario y programa educativo
$routes->get('/Indicador/indicadoresPorUsuarioYPrograma/(:num)/(:num)', 'Indicador::verIndicadoresPorUsuarioYPrograma/$1/$2');
//Editar
$routes->get('/Indicador/editar/(:num)', 'Indicador::editar/$1');

//eliminar
$routes->get('/Indicador/eliminar/(:num)', 'Indicador::eliminar/$1');

 





// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Premios
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice
$routes->get('/cv/premios', 'CV\Premio::index', ['filter' => 'authentication']);
// Ruta para guardar
$routes->post('/cv/premios/save', 'CV\Premio::save', ['filter' => 'authentication']);
// Ruta para eliminar
$routes->post('/cv/premios/delete/(:num)', 'CV\Premio::delete/$1', ['filter' => 'authentication']);


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Logros
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice
$routes->get('/cv/logros', 'CV\Logro::index', ['filter' => 'authentication']);
// Ruta para guardar
$routes->post('/cv/logros/save', 'CV\Logro::save', ['filter' => 'authentication']);    
// Ruta para eliminar
$routes->post('/cv/logros/delete/(:num)', 'CV\Logro::delete/$1', ['filter' => 'authentication']);

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// AsociacionesProfesionales
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Ruta para el índice
$routes->get('/cv/asociaciones', 'CV\AsociacionProfesional::index', ['filter' => 'authentication']);
// Ruta para guardar
$routes->post('/cv/asociaciones/save', 'CV\AsociacionProfesional::save', ['filter' => 'authentication']);
// Ruta para eliminar
$routes->post('/cv/asociaciones/delete/(:num)', 'CV\AsociacionProfesional::delete/$1', ['filter' => 'authentication']);




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
