<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/capacitacion/agregar.css') ?>">
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="header-title"><i class="fa fa-edit"></i> Editar Horas de Capacitación</h2>
        </div>


        
        <div class="card-body">
            <div class="section-description">
                <p><i class="fa fa-info-circle"></i> Por favor, edite los campos necesarios para actualizar las horas de
                    capacitación.</p>
            </div>
            <div id="alert-container" class="alert-container" style="display:none;"></div>

            <form action="<?= base_url(); ?>/Capacitacion/update/<?= $capacitacion['id']; ?>" method="POST"
                enctype="multipart/form-data" id="capacitacionForm">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="titulo"><i class="fa fa-heading"></i> Título</label>
                            <input class="form-control"
                                value="<?= htmlspecialchars(old('titulo', $capacitacion['titulo']), ENT_QUOTES, 'UTF-8') ?>"
                                name="titulo" id="titulo" placeholder="Título de la Capacitación">
                            <?php if (session('errors.titulo')): ?>
                                <p class='page-warning'><?= session('errors.titulo') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label><i class="fa fa-book"></i> Tipo de Capacitación</label>
                            <label class="radio-inline">
                                <input type="radio" name="tipo" id="tipo_disciplinar" value="Disciplinar" <?= old('tipo', $capacitacion['tipo']) == 'Disciplinar' ? 'checked' : '' ?>> Disciplinar (Profesional)
                                <i class="fa fa-graduation-cap"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="tipo" id="tipo_docente" value="Docente" <?= old('tipo', $capacitacion['tipo']) == 'Docente' ? 'checked' : '' ?>> Docente (Pedagógica)
                                <i class="fa fa-chalkboard-teacher"></i>
                            </label>
                            <?php if (session('errors.tipo')): ?>
                                <p class='page-warning'><?= session('errors.tipo') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label><i class="fa fa-cogs"></i> Modalidad</label>
                            <label class="radio-inline">
                                <input type="radio" name="modalidad" id="modalidad_presencial" value="Presencial"
                                    <?= old('modalidad', $capacitacion['modalidad']) == 'Presencial' ? 'checked' : '' ?>>
                                Presencial
                                <i class="fa fa-map-marker-alt"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="modalidad" id="modalidad_virtual" value="Virtual"
                                    <?= old('modalidad', $capacitacion['modalidad']) == 'Virtual' ? 'checked' : '' ?>>
                                Virtual
                                <i class="fa fa-desktop"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="modalidad" id="modalidad_vp" value="VP" <?= old('modalidad', $capacitacion['modalidad']) == 'VP' ? 'checked' : '' ?>> VP (Virtual Presencial)
                                <i class="fa fa-globe"></i> <i class="fa fa-laptop"></i>
                            </label>
                            <?php if (session('errors.modalidad')): ?>
                                <p class='page-warning'><?= session('errors.modalidad') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label><i class="fa fa-user-tag"></i> Rol</label>
                            <label class="radio-inline">
                                <input type="radio" name="rol" id="rol_instructor" value="Instructor" <?= old('rol', $capacitacion['rol']) == 'Instructor' ? 'checked' : '' ?>
                                    onchange="actualizarNombreInstructor()"> Instructor
                                <i class="fa fa-chalkboard-teacher"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="rol" id="rol_asistente" value="Asistente" <?= old('rol', $capacitacion['rol']) == 'Asistente' ? 'checked' : '' ?>
                                    onchange="actualizarNombreInstructor()"> Asistente
                                <i class="fa fa-user-plus"></i>
                            </label>
                            <?php if (session('errors.rol')): ?>
                                <p class='page-warning'><?= session('errors.rol') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="nombre_instructor_asistente"><i class="fa fa-user"></i> Nombre del
                                instructor/asistente</label>
                            <input type="hidden" id="nombre_usuario_actual"
                                value="<?= $usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']; ?>">
                            <input class="form-control" id="nombre_instructor_asistente" name="nombre_instructor"
                                value="<?= old('nombre_instructor', $capacitacion['nombre_instructor']) ?>"
                                placeholder="Nombre del instructor/asistente" <?= old('rol', $capacitacion['rol']) == 'Instructor' ? 'readonly' : '' ?>>
                            <?php if (session('errors.nombre_instructor')): ?>
                                <p class='page-warning'><?= session('errors.nombre_instructor') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="lugar"><i class="fa fa-map-marker-alt"></i> Lugar</label>
                            <input class="form-control" name="lugar" id="lugar"
                                value="<?= old('lugar', $capacitacion['lugar']) ?>"
                                placeholder="Localidad donde se imparte">
                            <?php if (session('errors.lugar')): ?>
                                <p class='page-warning'><?= session('errors.lugar') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="duracion_horas"><i class="fa fa-clock"></i> Horas de la capacitación</label>
                            <input class="form-control" name="duracion_horas" id="duracion_horas"
                                value="<?= old('duracion_horas', $capacitacion['duracion_horas']) ?>"
                                placeholder="Duración de la capacitación en horas">
                            <?php if (session('errors.duracion_horas')): ?>
                                <p class='page-warning'><?= session('errors.duracion_horas') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="fecha_inicial"><i class="fa fa-calendar-day"></i> Fecha de inicio</label>
                            <input class="form-control"
                                value="<?= old('fecha_inicial', $capacitacion['fecha_inicial']) ?>" name="fecha_inicial"
                                id="fecha_inicial" type="date">
                            <?php if (session('errors.fecha_inicial')): ?>
                                <p class="page-warning"><?= session('errors.fecha_inicial') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="fecha_final"><i class="fa fa-calendar-alt"></i> Fecha de finalización</label>
                            <input class="form-control" value="<?= old('fecha_final', $capacitacion['fecha_final']) ?>"
                                name="fecha_final" id="fecha_final" type="date">
                            <?php if (session('errors.fecha_final')): ?>
                                <p class="page-warning"><?= session('errors.fecha_final') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="institucion"><i class="fa fa-building"></i> Organización</label>
                            <input class="form-control" value="<?= old('institucion', $capacitacion['institucion']) ?>"
                                name="institucion" id="institucion" placeholder="Institución donde se imparte">
                            <?php if (session('errors.institucion')): ?>
                                <p class='page-warning'><?= session('errors.institucion') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label><i class="fa fa-file-upload"></i> Evidencia</label>
                            <div class="container-evidencia">
                                <label for="evidencia" class="btn btn-outline-secondary">
                                    <i class="fa fa-upload"></i> Seleccionar archivo
                                </label>
                                <input type="file" name="evidencia" id="evidencia" class="form-control-file"
                                    style="display: none;" accept=".pdf,image/jpeg,image/png">
                                <span
                                    id="file-chosen"><?= $capacitacion['evidencia'] ? $capacitacion['evidencia'] : 'No se ha seleccionado ningún archivo' ?></span>
                            </div>
                            <small class="form-text text-muted">
                                Por favor, suba un archivo en formato PDF, JPG o PNG. El tamaño máximo permitido es de 5
                                MB.
                            </small>
                            <?php if (session('errors.evidencia')): ?>
                                <p class='page-warning'><?= session('errors.evidencia') ?></p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group button-group">
                    <a class="btn btn-danger" href="<?= base_url(); ?>/capacitaciones/<?= esc($usuario["slug"]) ?>">
                            Cancelar</a>
                        <button class="btn btn-primary" type="submit"></i> Guardar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="<?= base_url('dist/js/custom/capacitaciones/edit.js') ?>"></script>


<?php $this->endSection(); ?>