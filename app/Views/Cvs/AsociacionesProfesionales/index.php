<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">

<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla asociaciones -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-handshake"></i> Asociaciones Profesionales</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#asociacionProfesionalModal">
            <i class="fas fa-plus-circle"></i> Agregar Asociación Profesional
        </button>
    </div>
    <p class="section-description">  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>En esta sección, puedes agregar nuevas asociaciones profesionales, así como editar o eliminar las asociaciones existentes.</p>

    <div class="table-responsive">
        <table id="table_asociacion_profesional" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-briefcase"></i> Nombre</th>
                    <th><i class="fas fa-tag"></i> Tipo</th>
                    <th><i class="fas fa-calendar-day"></i> Fecha de Inicio</th>
                    <th><i class="fas fa-calendar-check"></i> Fecha Final</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($asociaciones)): ?>
                    <?php foreach ($asociaciones as $asociacion): ?>
                        <tr>
                            <td><?= esc($asociacion['nombre']) ?></td>
                            <td><?= esc($asociacion['tipo']) ?></td>
                            <td><?= esc($asociacion['fecha_inicio']) ?></td>
                            <td><?= esc($asociacion['fecha_final']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary btn-editar-asociacion" data-toggle="modal"
                                    data-target="#asociacionProfesionalModal" data-id="<?= $asociacion['id'] ?>"
                                    data-nombre="<?= esc($asociacion['nombre']) ?>" data-tipo="<?= esc($asociacion['tipo']) ?>"
                                    data-fecha_inicio="<?= esc($asociacion['fecha_inicio']) ?>"
                                    data-fecha_final="<?= esc($asociacion['fecha_final']) ?>">
                                    <i class="fas fa-edit"></i> 
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-eliminar-asociacion-profesional"
                                    data-id="<?= $asociacion['id'] ?>">
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
<!-- Modal para agregar o editar asociación profesional -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="asociacionProfesionalModal" tabindex="-1" role="dialog" aria-labelledby="asociacionProfesionalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asociacionProfesionalModalLabel"><i class="fas fa-handshake"></i> Agregar Asociación Profesional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="asociacion-profesional-form" action="<?= base_url('Cv/asociacionProfesional/save') ?>" method="post" id="modalFormAsociacionProfesional">
                    <input type="hidden" name="id_asociacion_profesional" id="id_asociacion_profesional">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre"><i class="fas fa-briefcase"></i> Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre">
                                <div class="page-warning"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="tipo"><i class="fas fa-tag"></i> Tipo</label>
                                <input type="text" class="form-control" name="tipo" id="tipo">
                                <div class="page-warning"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Periodo</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fecha_inicio"><i class="fas fa-calendar-day"></i> Fecha de Inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio">
                                <div class="page-warning"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_final"><i class="fas fa-calendar-check"></i> Fecha Final</label>
                                <input type="date" class="form-control" name="fecha_final" id="fecha_final">
                                <div class="page-warning"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ---------------------------------------- -->
<!-- JS -->
<!-- ---------------------------------------- -->
<script>
    var baseUrl = '<?= base_url() ?>'; 
</script>

<script src="<?= base_url('dist/js/custom/cv/utils/commonFunctions.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/cv/asociacionProfesional.js') ?>"></script>
<?php $this->endSection(); ?>
