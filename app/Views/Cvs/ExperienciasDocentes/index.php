<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">


<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de experiencia docente -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-chalkboard-teacher"></i> Experiencia Docente</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#experienciaDocenteModal"
            id="addExperienciaDocenteBtn">
            <i class="fas fa-plus-circle"></i> Agregar Experiencia Docente
        </button>
    </div>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
  En esta sección puedes visualizar y gestionar tu experiencia docente. Agrega, edita o elimina registros y gestiona las clases asociadas a cada experiencia docente para mantener tu información actualizada.
</p>

    <div class="table-responsive">
        <table id="table_experiencia_docente" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-briefcase"></i> Puesto/Área</th>
                    <th><i class="fas fa-university"></i> Institución</th>
                    <th><i class="fas fa-calendar-alt"></i> Fecha de Inicio</th>
                    <th><i class="fas fa-calendar-check"></i> Fecha de Fin</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($experienciasDocente)): ?>
                    <?php foreach ($experienciasDocente as $experienciaDocente): ?>
                        <tr>
                            <td><?= esc($experienciaDocente['puesto_area']) ?></td>
                            <td><?= esc($experienciaDocente['institucion']) ?></td>
                            <td><?= esc($experienciaDocente['mes_inicio']) . ' - ' . esc($experienciaDocente['anio_inicio']) ?>
                            </td>
                            <td>
                                <?php if ($experienciaDocente['actualmente'] == 1): ?>
                                    Actualmente
                                <?php elseif (!empty($experienciaDocente['mes_fin']) && !empty($experienciaDocente['anio_fin'])): ?>
                                    <?= esc($experienciaDocente['mes_fin']) . ' - ' . esc($experienciaDocente['anio_fin']) ?>
                                <?php else: ?>
                                    No especificado
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-gestionar-clases"
                                    data-id="<?= esc($experienciaDocente['id']) ?>">
                                    <i class="fas fa-tasks"></i> Gestionar Clases
                                </button>

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#experienciaDocenteModal" data-id="<?= esc($experienciaDocente['id']) ?>"
                                    data-puesto_area="<?= esc($experienciaDocente['puesto_area']) ?>"
                                    data-institucion="<?= esc($experienciaDocente['institucion']) ?>"
                                    data-mes_inicio="<?= esc($experienciaDocente['mes_inicio']) ?>"
                                    data-anio_inicio="<?= esc($experienciaDocente['anio_inicio']) ?>"
                                    data-mes_fin="<?= esc($experienciaDocente['mes_fin']) ?>"
                                    data-anio_fin="<?= esc($experienciaDocente['anio_fin']) ?>"
                                    data-actualmente="<?= esc($experienciaDocente['actualmente']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-eliminar-experiencia-docente"
                                    data-id="<?= esc($experienciaDocente['id']) ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- Modal para agregar/editar una experiencia docente-->
<!-- ---------------------------------------- -->
<div class="modal fade" id="experienciaDocenteModal" tabindex="-1" role="dialog"
    aria-labelledby="experienciaDocenteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="experienciaDocenteModalLabel"><strong>Agregar Experiencia Docente</strong>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Cv/experienciadocente/save') ?>" method="post"
                    id="modalFormExperienciaDocente">
                    <input type="hidden" name="id_experiencia_docente" id="id_experiencia_docente">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="puesto_area"><i class="fas fa-briefcase"></i> Puesto/Área</label>
                            <input type="text" class="form-control" id="puesto_area" name="puesto_area">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="institucion"><i class="fas fa-building"></i> Institución</label>
                            <input type="text" class="form-control" id="institucion" name="institucion">
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="mes_inicio"><i class="fas fa-calendar-alt"></i> Mes de Inicio</label>
                            <select class="form-control" id="mes_inicio" name="mes_inicio">
                                <option value="">Seleccione un mes...</option>
                                <?php
                                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                foreach ($meses as $mes):
                                    ?>
                                    <option value="<?= esc($mes) ?>"><?= esc($mes) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="anio_inicio"><i class="fas fa-clock"></i> Año de Inicio</label>
                            <select class="form-control" id="anio_inicio" name="anio_inicio">
                                <option value="">Seleccione un año...</option>
                                <?php for ($i = date("Y"); $i >= 2000; $i--): ?>
                                    <option value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="actualmente" name="actualmente" value="1">
                        <label class="form-check-label" for="actualmente"><i
                                class="fas fa-check-circle"></i>Actualmente</label>
                    </div>

                    <div class="form-row" id="fechaFinContainer">
                        <div class="form-group col-md-6">
                            <label for="mes_fin"><i class="fas fa-calendar-alt"></i> Mes de Fin</label>
                            <select class="form-control" id="mes_fin" name="mes_fin">
                                <option value="">Seleccione un mes...</option>
                                <?php foreach ($meses as $mes): ?>
                                    <option value="<?= esc($mes) ?>"><?= esc($mes) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="anio_fin"><i class="fas fa-calendar-check"></i> Año de Fin</label>
                            <select class="form-control" id="anio_fin" name="anio_fin">
                                <option value="">Seleccione un año...</option>
                                <?php for ($i = date("Y"); $i >= 2000; $i--): ?>
                                    <option value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de proyectos -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fa fa-flask"></i> Proyectos de Investigación y Desarrollo</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#proyectoModal"
            id="addProyectoBtn">
            <i class="fa fa-plus-circle"></i> Agregar Proyecto
        </button>
    </div>
    <p class="section-description">
            <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección puedes visualizar y gestionar tus proyectos. Agrega, edita o elimina registros según sea necesario para mantener tu información actualizada.</p>
</p>

    <div class="table-responsive">
        <table id="table_proyecto" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fa fa-project-diagram"></i> Nombre del Proyecto</th>
                    <th><i class="fa fa-tag"></i> Tipo</th>
                    <th><i class="fa fa-money-bill-wave"></i> Tipo de Financiamiento</th>
                    <th><i class="fa fa-building"></i> Nombre del Organismo Externo</th>
                    <th><i class="fa fa-calendar-alt"></i> Fecha de Inicio</th>
                    <th><i class="fas fa-calendar-check"></i> Fecha de Fin</th>
                    <th><i class="fa fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($proyectos)): ?>
                    <?php foreach ($proyectos as $proyecto): ?>
                        <tr>
                            <td><?= esc($proyecto['nombre']) ?></td>
                            <td><?= esc($proyecto['tipo']) ?></td>
                            <td><?= esc($proyecto['tipo_financiamiento']) ?></td>
                            <td><?= esc($proyecto['nombre_organismo_externo']) ?></td>
                            <td>
                                <?= date("d-m-Y", strtotime($proyecto["fecha_inicio"])); ?>
                            </td>
                            <td>
                                <?= date("d-m-Y", strtotime($proyecto["fecha_fin"])); ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#proyectoModal"
                                    data-id="<?= esc($proyecto['id']) ?>" data-nombre="<?= esc($proyecto['nombre']) ?>"
                                    data-tipo="<?= esc($proyecto['tipo']) ?>"
                                    data-tipo_financiamiento="<?= esc($proyecto['tipo_financiamiento']) ?>"
                                    data-nombre_organismo_externo="<?= esc($proyecto['nombre_organismo_externo']) ?>"
                                    data-fecha_inicio="<?= esc($proyecto['fecha_inicio']) ?>"
                                    data-fecha_fin="<?= esc($proyecto['fecha_fin']) ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-eliminar-proyecto"
                                    data-id="<?= esc($proyecto['id']) ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- ---------------------------------------- -->
<!-- Modal para agregar/editar un proyecto-->
<!-- ---------------------------------------- -->

<div class="modal fade" id="proyectoModal" tabindex="-1" role="dialog" aria-labelledby="proyectoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proyectoModalLabel">Agregar Proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Cv/experienciadocente/saveProject') ?>" method="post"
                    id="modalFormProyecto">
                    <input type="hidden" name="id_proyecto" id="id_proyecto">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre"><i class="fa fa-project-diagram"></i> Nombre del Proyecto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Ingrese el nombre del proyecto">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipo"><i class="fa fa-tag"></i> Tipo</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="">Seleccione un tipo...</option>
                                <option value="Investigacion">Investigación</option>
                                <option value="Desarrollo">Desarrollo</option>
                                <option value="Vinculacion">Vinculación</option>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tipo_financiamiento"><i class="fa fa-money-bill-wave"></i> Tipo de
                                Financiamiento</label>
                            <select class="form-control" id="tipo_financiamiento" name="tipo_financiamiento">
                                <option value="">Seleccione un tipo de Financiamiento...</option>
                                <option value="Interno">Interno</option>
                                <option value="Externo">Externo</option>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6" id="organismo_externo_container" style="display: none;">
                            <label for="nombre_organismo_externo"><i class="fa fa-building"></i> Nombre Organismo
                                Externo</label>
                            <input type="text" class="form-control" id="nombre_organismo_externo"
                                name="nombre_organismo_externo" placeholder="Ingrese el nombre del organismo externo">
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecha_inicio"><i class="fa fa-calendar-alt"></i> Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_fin"><i class="fas fa-calendar-check"></i> Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de docencia -->
<!-- ---------------------------------------- -->

<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fa fa-chalkboard-teacher"></i> Docencia</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docenciaModal"
            id="addDocenciaBtn">
            <i class="fa fa-plus-circle"></i> Agregar Docencia
        </button>
    </div>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección puedes visualizar y gestionar tus docencias. Agrega, edita o elimina registros según sea necesario para mantener tu información actualizada.</p>

    <div class="table-responsive">
        <table id="table_docencia" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fa fa-book"></i> Libro</th>
                    <th><i class="fa fa-file-alt"></i> Manual de Práctica</th>
                    <th><i class="fa fa-chalkboard"></i> Material Didáctico</th>
                    <th><i class="fa fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($docencias)): ?>
                    <?php foreach ($docencias as $docencia): ?>
                        <tr>
                            <td><?= esc($docencia['libro']) ?></td>
                            <td><?= esc($docencia['manual_practica']) ?></td>
                            <td><?= esc($docencia['material_didactico']) ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docenciaModal"
                                    data-id="<?= esc($docencia['id']) ?>" data-libro="<?= esc($docencia['libro']) ?>"
                                    data-manual_practica="<?= esc($docencia['manual_practica']) ?>"
                                    data-material_didactico="<?= esc($docencia['material_didactico']) ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-eliminar-docencia"
                                    data-id="<?= esc($docencia['id']) ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- Modal para agregar/editar una docencia-->
<!-- ---------------------------------------- -->
<div class="modal fade" id="docenciaModal" tabindex="-1" role="dialog" aria-labelledby="docenciaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="docenciaModalLabel">Agregar Docencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Cv/experienciadocente/saveDocencia') ?>" method="post"
                    id="modalFormDocencia">
                    <input type="hidden" name="id_docencia" id="id_docencia">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="libro"><i class="fa fa-book"></i> Libro</label>
                            <textarea class="form-control" id="libro" name="libro" rows="3"
                                placeholder="Ingrese el libro"></textarea>
                            <div class="page-warning"></div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="manual_practica"><i class="fa fa-file-alt"></i> Manual de Práctica</label>
                            <textarea class="form-control" id="manual_practica" name="manual_practica" rows="3"
                                placeholder="Ingrese el manual de práctica"></textarea>
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="material_didactico"><i class="fa fa-chalkboard"></i> Material Didáctico</label>
                        <textarea class="form-control" id="material_didactico" name="material_didactico" rows="3"
                            placeholder="Ingrese el material didáctico"></textarea>
                        <div class="page-warning"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de investigaciones -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fa fa-flask"></i> Investigación</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#investigacionModal"
            id="addInvestigacionBtn">
            <i class="fa fa-plus-circle"></i> Agregar Investigación
        </button>
    </div>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    
    En esta sección puedes visualizar y gestionar tus investigaciones. Agrega, edita o elimina registros según sea necesario para mantener tu información actualizada.</p>

    <div class="table-responsive">
        <?php
        $tipos = ['Articulo de Revista', 'Articulo de Divulgacion', 'Capitulo de libro'];
        foreach ($tipos as $index => $tipo):
            ?>
            <h3 class="large-black-title"><i class="fa fa-book"></i> <?= esc($tipo) ?></h3>
            <!-- Título grande fuera de la tabla -->
            <table id="table_investigacion_<?= $index ?>" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><i class="fa fa-user"></i> Autores</th>
                        <th><i class="fa fa-calendar"></i> Año</th>
                        <th><i class="fa fa-file-alt"></i> Título</th>
                        <th><i class="fa fa-newspaper"></i> Fuente</th>
                        <th><i class="fa fa-link"></i> URL o DOI</th>
                        <th><i class="fa fa-building"></i> Editorial</th>
                        <th><i class="fa fa-list"></i> Index</th>
                        <th><i class="fa fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hayDatos = false;
                    foreach ($investigaciones as $investigacion):
                        if ($investigacion['tipo'] == $tipo):
                            $hayDatos = true;
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    if (isset($investigacion['autores']) && is_array($investigacion['autores'])):
                                        $autores = array_column($investigacion['autores'], 'nombre');
                                        echo esc(implode(', ', $autores));
                                    endif;
                                    ?>
                                </td>
                                <td><?= esc($investigacion['anio']) ?></td>
                                <td><?= esc($investigacion['titulo']) ?></td>
                                <td><?= esc($investigacion['fuente']) ?></td>
                                <td><?= esc($investigacion['url_doi']) ?></td>
                                <td><?= esc($investigacion['editorial']) ?></td>
                                <td><?= esc($investigacion['indiz']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#investigacionModal" data-id="<?= esc($investigacion['id']) ?>"
                                        data-titulo="<?= esc($investigacion['titulo']) ?>"
                                        data-tipo="<?= esc($investigacion['tipo']) ?>"
                                        data-anio="<?= esc($investigacion['anio']) ?>"
                                        data-fuente="<?= esc($investigacion['fuente']) ?>"
                                        data-url_doi="<?= esc($investigacion['url_doi']) ?>"
                                        data-editorial="<?= esc($investigacion['editorial']) ?>"
                                        data-indiz="<?= esc($investigacion['indiz']) ?>"
                                        data-autores='<?= isset($investigacion['autores']) ? esc(json_encode(array_column($investigacion['autores'], 'nombre'))) : '[]' ?>'>
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-investigacion"
                                        data-id="<?= esc($investigacion['id']) ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php if ($index < count($tipos) - 1): ?>
                <hr class="table-separator">
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>


<!-- ---------------------------------------- -->
<!-- Modal para agregar/editar una investigación-->
<!-- ---------------------------------------- -->
<div class="modal fade" id="investigacionModal" tabindex="-1" role="dialog" aria-labelledby="investigacionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="investigacionModalLabel"> Agregar Investigación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Cv/experienciadocente/saveInvestigacion') ?>" method="post"
                    id="modalFormInvestigacion">
                    <input type="hidden" name="id_investigacion" id="id_investigacion">

                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="tipo"><i class="fas fa-clipboard-list"></i> Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="" disabled selected>Seleccione un tipo de investigación...</option>
                                <option value="Articulo de Revista">Artículo de Revista</option>
                                <option value="Articulo de Divulgacion">Artículo de Divulgación</option>
                                <option value="Capitulo de libro">Capítulo de libro</option>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="">
                        <label for="autores"><i class="fas fa-users"></i> Autores</label>
                        <div id="autores-container" class="d-flex flex-wrap align-items-center">
                            <div class="input-group mb-2 autor-field">
                                <input type="text" class="form-control autor-input" name="autores[]"
                                    placeholder="Nombre del autor" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-autor" type="button"><i
                                            class="fas fa-plus"></i></button>
                                    <button class="btn btn-outline-secondary remove-autor" type="button"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="titulo"><i class="fas fa-heading"></i> Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                placeholder="Ingrese el título" >
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="anio"><i class="fas fa-calendar"></i> Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" placeholder="Ingrese el año"
                                >
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fuente"><i class="fas fa-newspaper"></i> Fuente</label>
                            <input type="text" class="form-control" id="fuente" name="fuente"
                                placeholder="Ingrese la fuente" >
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="url_doi"><i class="fas fa-link"></i> URL/DOI</label>
                            <input type="url" class="form-control" id="url_doi" name="url_doi"
                                placeholder="Ingrese la URL o DOI" required>
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editorial"><i class="fas fa-building"></i> Editorial</label>
                            <input type="text" class="form-control" id="editorial" name="editorial"
                                placeholder="Ingrese la editorial" >
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="indiz"><i class="fas fa-list"></i> Index</label>
                            <input type="text" class="form-control" id="indiz" name="indiz"
                                placeholder="Ingrese el índice">
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de vinculacion -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-link"></i> Vinculación</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vinculacionModal"
            id="addVinculacionBtn">
            <i class="fas fa-plus-circle"></i> Agregar Vinculación
        </button>
    </div>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección puedes visualizar y gestionar tus vinculaciones . Agrega, edita o elimina registros según sea necesario para mantener tu información actualizada.</p>


    <div class="table-responsive">
        <table id="table_vinculacion" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-tag"></i> Patente</th>
                    <th><i class="fas fa-building"></i> Convenio Industrial</th>
                    <th><i class="fas fa-tools"></i> Servicio Industrial</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($vinculaciones)): ?>
                    <?php foreach ($vinculaciones as $vinculacion): ?>
                        <tr>
                            <td><?= esc($vinculacion['patente']) ?></td>
                            <td><?= esc($vinculacion['convenio_industrial']) ?></td>
                            <td><?= esc($vinculacion['servicio_industrial']) ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#vinculacionModal" data-id="<?= esc($vinculacion['id']) ?>"
                                    data-patente="<?= esc($vinculacion['patente']) ?>"
                                    data-convenio_industrial="<?= esc($vinculacion['convenio_industrial']) ?>"
                                    data-servicio_industrial="<?= esc($vinculacion['servicio_industrial']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-eliminar-vinculacion"
                                    data-id="<?= esc($vinculacion['id']) ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- Modal para agregar/editar una vinculacion-->
<!-- ---------------------------------------- -->
<div class="modal fade" id="vinculacionModal" tabindex="-1" role="dialog" aria-labelledby="vinculacionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vinculacionModalLabel"> Agregar Vinculación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Cv/experienciadocente/saveVinculacion') ?>" method="post"
                    id="modalFormVinculacion">
                    <input type="hidden" name="id_vinculacion" id="id_vinculacion">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="patente"><i class="fas fa-tag"></i> Patente</label>
                            <textarea type="text" class="form-control" id="patente" name="patente"
                                placeholder="Ingrese la patente"></textarea>
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="convenio_industrial"><i class="fas fa-building"></i> Convenio Industrial</label>
                            <textarea type="text" class="form-control" id="convenio_industrial"
                                name="convenio_industrial" placeholder="Ingrese el convenio industrial"></textarea>
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="servicio_industrial"><i class="fas fa-tools"></i> Servicio Industrial</label>
                        <textarea type="text" class="form-control" id="servicio_industrial" name="servicio_industrial"
                            placeholder="Ingrese el servicio industrial"></textarea>
                        <div class="page-warning"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de evento academico -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-calendar-alt"></i> Eventos Académicos</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eventoAcademicoModal"
            id="addEventoAcademicoBtn">
            <i class="fas fa-plus-circle"></i> Agregar Evento Académico
        </button>
    </div>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>   
    En esta sección puedes visualizar y gestionar tus eventos académicos. Agrega, edita o elimina registros según sea necesario para mantener tu información actualizada.</p>

    <div class="table-responsive">
        <table id="table_evento_academico" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-file-alt"></i> Nombre de Ponencia</th>
                    <th><i class="fas fa-bullhorn"></i> Nombre del Evento</th>
                    <th><i class="fas fa-map-marker-alt"></i> Lugar</th>
                    <th><i class="fas fa-calendar-alt"></i> Fecha</th>
                    <th><i class="fas fa-flag"></i> País</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($eventosAcademicos)): ?>
                    <?php foreach ($eventosAcademicos as $eventoAcademico): ?>
                        <tr>
                            <td><?= esc($eventoAcademico['nombre_ponencia']) ?></td>
                            <td><?= esc($eventoAcademico['nombre_evento']) ?></td>
                            <td><?= esc($eventoAcademico['lugar']) ?></td>
                            <td><?= esc($eventoAcademico['fecha']) ?></td>
                            <td><?= esc($eventoAcademico['pais']) ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#eventoAcademicoModal" data-id="<?= esc($eventoAcademico['id']) ?>"
                                    data-nombre_ponencia="<?= esc($eventoAcademico['nombre_ponencia']) ?>"
                                    data-nombre_evento="<?= esc($eventoAcademico['nombre_evento']) ?>"
                                    data-lugar="<?= esc($eventoAcademico['lugar']) ?>"
                                    data-fecha="<?= esc($eventoAcademico['fecha']) ?>"
                                    data-pais="<?= esc($eventoAcademico['pais']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-eliminar-evento-academico"
                                    data-id="<?= esc($eventoAcademico['id']) ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- ---------------------------------------- -->
<!-- Modal para agregar/editar un evento academico-->
<!-- ---------------------------------------- -->
<div class="modal fade" id="eventoAcademicoModal" tabindex="-1" role="dialog"
    aria-labelledby="eventoAcademicoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoAcademicoModalLabel"> Agregar Evento Académico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Cv/experienciadocente/saveEventoAcademico') ?>" method="post"
                    id="modalFormEventoAcademico">
                    <input type="hidden" name="id_evento_academico" id="id_evento_academico">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre_ponencia"><i class="fas fa-file-alt"></i> Nombre de la Ponencia</label>
                            <input type="text" class="form-control" id="nombre_ponencia" name="nombre_ponencia"
                                placeholder="Ingrese el nombre de la ponencia">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre_evento"><i class="fas fa-bullhorn"></i> Nombre del Evento</label>
                            <input type="text" class="form-control" id="nombre_evento" name="nombre_evento"
                                placeholder="Ingrese el nombre del evento">
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="lugar"><i class="fas fa-map-marker-alt"></i> Lugar</label>
                            <input type="text" class="form-control" id="lugar" name="lugar"
                                placeholder="Ingrese el lugar">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                            <div class="page-warning"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pais"><i class="fas fa-flag"></i> País</label>
                        <input type="text" class="form-control" id="pais" name="pais" placeholder="Ingrese el país">
                        <div class="page-warning"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de las capacitaciones seleccionadas -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-graduation-cap"></i> Capacitaciones Seleccionadas</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#capacitacionModal">
            <i class="fas fa-plus-circle"></i> Seleccionar Capacitaciones
        </button>
    </div>
    <p class="section-description">En esta sección, puedes seleccionar nuevas capacitaciones y eliminar las capacitaciones seleccionadas.</p>

    <div class="table-responsive"> <!-- Add this wrapper -->
        <table id="table_capacitaciones" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-heading"></i> Titulo</th>
                    <th><i class="fas fa-tag"></i> Tipo</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($capacitacionesSeleccionadas)): ?>
                    <?php foreach ($capacitacionesSeleccionadas as $capacitacion): ?>
                        <tr>
                            <td><?= esc($capacitacion['titulo']) ?></td>
                            <td><?= esc($capacitacion['tipo']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger btn-quitar-capacitacion"
                                    data-id="<?= esc($capacitacion['id']) ?>">
                                    <i class="fas fa-trash-alt"></i> 
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>

                    
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- Modal para seleccionar las capacitaciones-->
<!-- ---------------------------------------- -->
<div class="modal fade" id="capacitacionModal" tabindex="-1" role="dialog" aria-labelledby="capacitacionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="capacitacionModalLabel">Seleccionar Capacitaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach ($todasLasCapacitaciones as $capacitacion): ?>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="capacitacion<?= esc($capacitacion['id']) ?>"
                            value="<?= esc($capacitacion['id']) ?>" <?= $capacitacion['mostrar_cv'] ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="capacitacion<?= esc($capacitacion['id']) ?>">
                            <?= esc($capacitacion['titulo']) ?>  (<?= esc($capacitacion['tipo']) ?>)
                        </label>

                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <span id="capacitacionesCount">0 capacitaciones seleccionadas</span>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarSeleccionCapacitaciones">Guardar
                    selección</button>
            </div>
        </div>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- JS -->
<!-- ---------------------------------------- -->

<script>
    var baseUrl = ' <?= base_url() ?>'; </script>
<script src="<?= base_url('dist/js/custom/cv/utils/commonFunctions.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/cv/experienciaDocente.js') ?>"></script>


<?php $this->endSection(); ?>