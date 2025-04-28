<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/viewCv.css') ?>">

<div class="cv-section datos-generales">
    <h2 class="section-title"><i class="fa fa-id-card"></i> Datos Generales</h2>

    <!-- Información Personal -->
    <div class="personal-info-container">
        <div class="personal-info-content">

        <div class="photo-container">
    <?php if (!empty($datosGenerales['foto_personal'])): ?>
        <img src="<?= base_url('uploads/fotos_personales/' . $datosGenerales['foto_personal']) ?>" alt="Foto Personal" class="profile-photo">
    <?php else: ?>
        <img src="<?= base_url('fotodefecto.png') ?>" alt="Foto Personal" class="profile-photo">
    <?php endif; ?>
</div>

            <div class="info-container">
                <h1 class="card-title">
                    <?= esc($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']) ?>
                </h1>
                <p class="section-description">
                    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
                    En esta sección se muestra la información personal del usuario, incluyendo:
                    <br>
                    <span style="display: inline-block; margin-top: 5px;">
                        • Fecha de nacimiento • Edad • Género • Teléfono • Número de celular • Correo electrónico
                    </span>
                </p>
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-birthday-cake" aria-hidden="true"></i>
                        <span>
                            <?= !empty($datosGenerales['fecha_nacimiento'])
                                ? esc(date('d/m/Y', strtotime($datosGenerales['fecha_nacimiento'])))
                                : 'No disponible' ?>
                        </span>

                    </div>
                    <div class="info-item">
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <span><?= esc($datosGenerales['edad'] ?? 'No disponible') ?> años</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-venus-mars" aria-hidden="true"></i>
                        <span><?= esc($datosGenerales['genero'] ?? 'No disponible') ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <span><?= esc($usuario['telefono'] ?? 'No disponible') ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                        <span><?= esc(!empty($datosGenerales['no_celular']) ? $datosGenerales['no_celular'] : 'No disponible') ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <span><?= esc($usuario['correo'] ?? 'No disponible') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Domicilios -->
    <div>
        <h3 class="section-title"><i class="fas fa-map-marked-alt"></i> Domicilios</h3>
        <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver los domicilios del maestro, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Calle • Colonia • Número exterior e interior • Ciudad • Estado • País • Código postal
    </span>
</p>


        <div class="cv-cards-container">
            <?php if (!empty($domicilios)): ?>
                <?php foreach ($domicilios as $domicilio): ?>
                    <div class="cv-card">
                        <h4 class="card-title"><i class="fas fa-home"></i> <?= esc($domicilio['calle']) ?></h4>
                        <div class="domicilio-info">
                            <p><i class="fas fa-map-pin"></i> <?= esc($domicilio['colonia']) ?></p>
                            <p><i class="fas fa-building"></i> Ext: <?= esc($domicilio['no_exterior']) ?>, Int:
                                <?= esc($domicilio['no_interior']) ?></p>
                            <p><i class="fas fa-city"></i> <?= esc($domicilio['ciudad']) ?>, <?= esc($domicilio['estado']) ?>
                            </p>
                            <p><i class="fas fa-globe"></i> <?= esc($domicilio['pais']) ?></p>
                            <p><i class="fas fa-mail-bulk"></i> CP: <?= esc($domicilio['codigo_postal']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-records">
                    <i class="fa fa-exclamation-circle"></i>
                    <p>No hay domicilios registrados.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>

<!-- Experiencia Laboral -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-briefcase"></i> Experiencia Laboral</h2>

    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver la experiencia laboral del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Puesto • Empresa • Fecha de inicio y fin • Estado actual
    </span>
</p>

    <div class="cv-cards-container">
        <?php if (!empty($experienciasLaborales)): ?>
            <?php foreach ($experienciasLaborales as $experienciaLaboral): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($experienciaLaboral['actividad_puesto']) ?></h3>
                    <p class="general-info">
                        <i class="fas fa-building"></i> <?= esc($experienciaLaboral['empresa']) ?>
                    </p>
                    <p class="general-info">
                        <i class="fas fa-calendar-alt"></i>
                        <?= esc($experienciaLaboral['mes_inicio']) . ' - ' . esc($experienciaLaboral['anio_inicio']) ?>
                        <?php if ($experienciaLaboral['actualmente'] == 1): ?>
                            - <span class="current-job"> Actualmente</span>
                        <?php elseif (!empty($experienciaLaboral['mes_fin']) && !empty($experienciaLaboral['anio_fin'])): ?>
                            - <?= esc($experienciaLaboral['mes_fin']) . ' - ' . esc($experienciaLaboral['anio_fin']) ?>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay experiencia laboral registrada.</p>
            </div>
        <?php endif; ?>
    </div>
</div>



<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>

<!-- Experiencia Docente -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-chalkboard-teacher"></i> Experiencia Docente</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver la experiencia docente del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Puesto • Institución • Fecha de inicio y fin • Estado actual • Clases impartidas
    </span>
</p>

    <div class="cv-cards-container"> 
        <?php if (!empty($experienciasDocente)): ?>
            <?php foreach ($experienciasDocente as $experienciaDocente): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($experienciaDocente['puesto_area']) ?></h3>
                    <p class="general-info"><i class="fas fa-university"></i> <?= esc($experienciaDocente['institucion']) ?></p>
                    <p class="general-info">
                        <i class="fas fa-calendar-alt"></i>
                        <?= esc($experienciaDocente['mes_inicio']) . ' - ' . esc($experienciaDocente['anio_inicio']) ?>
                        <?php if ($experienciaDocente['actualmente'] == 1): ?>
                            - <span class="current-job">Actualmente</span>
                        <?php elseif (!empty($experienciaDocente['mes_fin']) && !empty($experienciaDocente['anio_fin'])): ?>
                            - <?= esc($experienciaDocente['mes_fin']) . ' - ' . esc($experienciaDocente['anio_fin']) ?>
                        <?php endif; ?>
                    </p>
                    <a href="#" class="btn btn-primary btn-ver-clases" data-id="<?= esc($experienciaDocente['id']) ?>" data-toggle="modal" data-target="#classesModal">Ver Clases</a>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay registros disponibles en esta sección.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="classesModal" tabindex="-1" role="dialog" aria-labelledby="classesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classesModalLabel">Clases Impartidas del puesto  <?= esc($experienciaDocente['puesto_area'] ?? 'No disponible') ?>   </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="classesContent" class="card-container">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>

<!-- Proyectos de Investigación y Desarrollo -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-flask"></i> Proyectos de Investigación y Desarrollo</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver los proyectos de investigación y desarrollo, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Nombre del proyecto • Tipo • Tipo de financiamiento • Fechas de inicio y fin • Nombre del organismo externo (si aplica)
    </span>
</p>

    <div class="cv-cards-container">
        <?php if (!empty($proyectos)): ?>
            <?php foreach ($proyectos as $proyecto): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($proyecto['nombre']) ?></h3>
                    <p class="general-info"><i class="fas fa-tag"></i> <?= esc($proyecto['tipo']) ?></p>
                    <p class="general-info"><i class="fas fa-money-bill-wave"></i> <?= esc($proyecto['tipo_financiamiento']) ?>
                    </p>
                    <?php if (!empty($proyecto['nombre_organismo_externo'])): ?>
                        <p class="general-info"><i class="fas fa-building"></i> <?= esc($proyecto['nombre_organismo_externo']) ?>
                        </p>
                    <?php endif; ?>
                    <p class="general-info">
                        <i class="fas fa-calendar-alt"></i>
                        <?= date("d-m-Y", strtotime($proyecto["fecha_inicio"])) ?> -
                        <?= date("d-m-Y", strtotime($proyecto["fecha_fin"])) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay registros disponibles en esta sección.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>

<!-- Docencia -->
<div class="cv-section docencia-section">
    <h2 class="section-title"><i class="fa fa-chalkboard-teacher"></i> Docencia</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver los materiales de docencia, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Libro • Manual de práctica • Material didáctico
    </span>
</p>

    <div class="docencia-cards-container">
        <?php
        $hasLibro = false;
        $hasManual = false;
        $hasMaterial = false;

        if (!empty($docencias)):
            foreach ($docencias as $docencia):
                if (!empty($docencia['libro'])) {
                    $hasLibro = true;
                }
                if (!empty($docencia['manual_practica'])) {
                    $hasManual = true;
                }
                if (!empty($docencia['material_didactico'])) {
                    $hasMaterial = true;
                }
            endforeach;
        endif;
        ?>

        <?php if ($hasLibro): ?>
            <div class="docencia-row">
                <?php foreach ($docencias as $docencia): ?>
                    <?php if (!empty($docencia['libro'])): ?>
                        <div class="docencia-card libro-card">
                            <h3 class="card-title">Libro</h3>
                            <p class="general-info"><i class="fa fa-book"></i> <?= esc($docencia['libro']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($hasManual): ?>
            <div class="docencia-row">
                <?php foreach ($docencias as $docencia): ?>
                    <?php if (!empty($docencia['manual_practica'])): ?>
                        <div class="docencia-card manual-card">
                            <h3 class="card-title">Manual de Práctica</h3>
                            <p class="general-info"><i class="fa fa-file-alt"></i> <?= esc($docencia['manual_practica']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($hasMaterial): ?>
            <div class="docencia-row">
                <?php foreach ($docencias as $docencia): ?>
                    <?php if (!empty($docencia['material_didactico'])): ?>
                        <div class="docencia-card material-card">
                            <h3 class="card-title">Material Didáctico</h3>
                            <p class="general-info"><i class="fa fa-chalkboard"></i> <?= esc($docencia['material_didactico']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!$hasLibro && !$hasManual && !$hasMaterial): ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay registros disponibles en esta sección.</p>
            </div>
        <?php endif; ?>
    </div>
</div>




<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>


<!-- Investigación -->
<div class="cv-section">
    <div class="section-container">
        <h2 class="section-title"><i class="fa fa-flask"></i> Investigación</h2>

        <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver las investigaciones del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Título • Autores • Año • Fuente • URL • DOI • Editorial • Índice • Tipos: Artículo de Revista, Artículo de Divulgación, Capítulo de Libro
    </span>
</p>

        <?php
        $tipos = ['Articulo de Revista', 'Articulo de Divulgacion', 'Capitulo de libro'];
        foreach ($tipos as $index => $tipo):
            ?>
            <div class="investigacion-type-container">
                <h3 class="large-black-title"><i class="fa fa-book"></i> <?= esc($tipo) ?></h3>
                <div class="investigacion-type-cards">
                    <?php
                    $hayDatos = false;
                    foreach ($investigaciones as $investigacion):
                        if ($investigacion['tipo'] == $tipo):
                            $hayDatos = true;
                            ?>
                            <div class="investigacion-card">
                                <h3 class="card-title"><?= esc($investigacion['titulo']) ?></h3>
                                <p class="general-info"><i class="fa fa-user"></i>
                                    <?= isset($investigacion['autores']) && is_array($investigacion['autores']) ? esc(implode(', ', array_column($investigacion['autores'], 'nombre'))) : 'N/A' ?>
                                </p>
                                <p class="general-info"><i class="fa fa-calendar"></i> <?= esc($investigacion['anio']) ?></p>
                                <p class="general-info"><i class="fa fa-file-alt"></i> <?= esc($investigacion['fuente']) ?></p>
                                <p class="general-info"><i class="fa fa-link"></i> <?= esc($investigacion['url_doi']) ?></p>
                                <p class="general-info"><i class="fa fa-building"></i> <?= esc($investigacion['editorial']) ?></p>
                                <p class="general-info"><i class="fa fa-list"></i> <?= esc($investigacion['indiz']) ?></p>
                            </div>
                            <?php
                        endif;
                    endforeach;
                    if (!$hayDatos):
                        echo '<div class="no-records"><i class="fa fa-exclamation-circle"></i><p>No hay investigaciones registradas para este tipo.</p></div>';
                    endif;
                    ?>
                </div>
            </div>
            <?php if ($index < count($tipos) - 1): ?>
                <hr class="section-divider">
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>

<!-- Vinculación -->
<div class="cv-section vinculacion-section">
    <h2 class="section-title"><i class="fas fa-link"></i> Vinculación</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver los detalles de vinculación del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Patente • Convenio industrial • Servicio industrial
    </span>
</p>

    <div class="vinculacion-cards-container">
        <?php
        $hasPatente = false;
        $hasConvenio = false;
        $hasServicio = false;

        if (!empty($vinculaciones)):
            foreach ($vinculaciones as $vinculacion):
                if (!empty($vinculacion['patente'])) {
                    $hasPatente = true;
                }
                if (!empty($vinculacion['convenio_industrial'])) {
                    $hasConvenio = true;
                }
                if (!empty($vinculacion['servicio_industrial'])) {
                    $hasServicio = true;
                }
            endforeach;
        endif;
        ?>

        <?php if ($hasPatente): ?>
            <div class="vinculacion-row">
                <?php foreach ($vinculaciones as $vinculacion): ?>
                    <?php if (!empty($vinculacion['patente'])): ?>
                        <div class="vinculacion-card patente-card">
                            <h3 class="card-title">Patente</h3>
                            <p class="general-info"><i class="fas fa-tag"></i> <?= esc($vinculacion['patente']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($hasConvenio): ?>
            <div class="vinculacion-row">
                <?php foreach ($vinculaciones as $vinculacion): ?>
                    <?php if (!empty($vinculacion['convenio_industrial'])): ?>
                        <div class="vinculacion-card convenio-card">
                            <h3 class="card-title">Convenio Industrial</h3>
                            <p class="general-info"><i class="fas fa-building"></i> <?= esc($vinculacion['convenio_industrial']) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($hasServicio): ?>
            <div class="vinculacion-row">
                <?php foreach ($vinculaciones as $vinculacion): ?>
                    <?php if (!empty($vinculacion['servicio_industrial'])): ?>
                        <div class="vinculacion-card servicio-card">
                            <h3 class="card-title">Servicio Industrial</h3>
                            <p class="general-info"><i class="fas fa-tools"></i> <?= esc($vinculacion['servicio_industrial']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!$hasPatente && !$hasConvenio && !$hasServicio): ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay registros disponibles en esta sección.</p>
            </div>
        <?php endif; ?>
    </div>
</div>



<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>

<!-- Eventos Académicos -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Eventos Académicos</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver los eventos académicos registrados, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Nombre de la ponencia • Nombre del evento • Lugar • Fecha • País
    </span>
</p>

    <div class="cv-cards-container">
        <?php if (!empty($eventosAcademicos)): ?>
            <?php foreach ($eventosAcademicos as $eventoAcademico): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($eventoAcademico['nombre_ponencia']) ?></h3>
                    <p class="general-info"><i class="fas fa-bullhorn"></i> <?= esc($eventoAcademico['nombre_evento']) ?></p>
                    <p class="general-info"><i class="fas fa-map-marker-alt"></i> <?= esc($eventoAcademico['lugar']) ?></p>
                    <p class="general-info"><i class="fas fa-calendar-alt"></i> <?= esc($eventoAcademico['fecha']) ?></p>
                    <p class="general-info"><i class="fas fa-flag"></i> <?= esc($eventoAcademico['pais']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay eventos académicos registrados.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>


<!-- Capacitaciones Seleccionadas -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Capacitaciones Seleccionadas</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver las capacitaciones seleccionadas del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Título • Tipo 
    </span>
</p>

    <div class="cv-cards-container">
        <?php if (!empty($capacitacionesSeleccionadas)): ?>
            <?php foreach ($capacitacionesSeleccionadas as $capacitacion): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($capacitacion['titulo']) ?></h3>
                    <p class="general-info"><i class="fas fa-tag"></i> <?= esc($capacitacion['tipo']) ?></p>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay capacitaciones seleccionadas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>


<!-- Logros -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-trophy"></i> Logros Registrados</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver los logros del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Tipo • Descripción breve
    </span>
</p>


    <div class="cv-cards-container">
        <?php if (!empty($logros)): ?>
            <?php foreach ($logros as $logro): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($logro['tipo']) ?></h3>
                    <p class="general-info"><i class="fas fa-tag"></i> <?= esc($logro['descripcion']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay logros registrados.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>

<!-- Premios y Distinciones -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-award"></i> Premios y Distinciones Registradas</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver los premios y distinciones del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Descripción • Año • Organismo • País
    </span>
</p>
    <div class="cv-cards-container">
        <?php if (!empty($premios)): ?>
            <?php foreach ($premios as $premio): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($premio['descripcion']) ?></h3>
                    <p class="general-info"><i class="fas fa-calendar-alt"></i> <?= esc($premio['anio']) ?></p>
                    <p class="general-info"><i class="fas fa-building"></i> <?= esc($premio['organismo']) ?></p>
                    <p class="general-info"><i class="fas fa-flag"></i> <?= esc($premio['pais']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay premios o distinciones registradas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="section-divider">
    <i class="fas fa-tachometer-alt"></i>
</div>


<!-- Asociaciones Profesionales -->
<div class="cv-section">
    <h2 class="section-title"><i class="fas fa-handshake"></i> Asociaciones Profesionales Registradas</h2>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver las asociaciones profesionales del usuario, incluyendo:
    <br>
    <span style="display: inline-block; margin-top: 5px;">
        • Nombre • Tipo • Fecha de inicio y fin
    </span>
</p>

    <div class="cv-cards-container">
        <?php if (!empty($asociaciones)): ?>
            <?php foreach ($asociaciones as $asociacion): ?>
                <div class="cv-card">
                    <h3 class="card-title"><?= esc($asociacion['nombre']) ?></h3>
                    <p class="general-info"><i class="fas fa-tag"></i> <?= esc($asociacion['tipo']) ?></p>
                    <p class="general-info><i class=" fas fa-calendar-day"></i> <?= esc($asociacion['fecha_inicio']) ?></p>
                    <p class="general-info"><i class="fas fa-calendar-check"></i> <?= esc($asociacion['fecha_final']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-records">
                <i class="fa fa-exclamation-circle"></i>
                <p>No hay asociaciones profesionales registradas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>



<a href="<?= base_url('/cv') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Regresar</a>


<?php $this->endSection(); ?>