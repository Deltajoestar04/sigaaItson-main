<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/capacitacion/general.css') ?>">
<div class="capacitaciones-container">
    <div class="capacitaciones-header">
        <?php if ($_SESSION['rol'] === "admin"): ?>
            <h2 class="header-title">Listado de capacitaciones -
                <?= esc($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']); ?>
            </h2>
        <?php else: ?>
            <h2 class="header-title">Listado de capacitaciones</h2>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] != "admin"): ?>
            <a class="btn btn-primary btn-add-capacitacion" href="<?= base_url(); ?>/capacitaciones/agregar">
                <i class="fas fa-plus-circle"></i> Agregar Capacitación
            </a>
        <?php endif; ?>

    </div>

    <p class="section-description">
        <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            En esta sección, puedes revisar y gestionar las capacitaciones registradas. Tienes la opción de aceptar o
            rechazar capacitaciones según corresponda.
        <?php else: ?>
            En esta sección, puedes ver y gestionar tus capacitaciones registradas. Usa los botones de acciones para editar
            o eliminar una capacitación existente, o agrega una nueva usando el botón "Agregar Capacitación".
        <?php endif; ?>
    </p>

    <?php if (session('msg') !== null): ?>
        <div class="alert alert-success">
            <?= session('msg') ?>
        </div>
    <?php endif; ?>

    <div class="row mb-3">
        <div class="col-lg-3 col-md-6">
            <div class="form-group">
                <label for="yearFilter"><i class="fas fa-calendar-year"></i> Filtrar por año:</label>
                <div class="d-flex">
                    <select class="form-control" id="yearFilter">

                        <option value="" selected>Todos los años</option>
                        <?php
                        $currentYear = date('Y');
                        for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                    <button id="btnExportExcel" class="btn btn-success" title="Exportar a Excel">
                        <i class="fas fa-file-excel"></i> Exportar a Excel
                    </button>

                </div>
            </div>
        </div>
    </div>



    <div class="row mb-3">
        <div class="col-lg-3 col-md-6">
            <div class="statistics-panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-8 text-left">
                            <div class="huge">
                                <h3 id="horas_diciplinarias"></h3>
                            </div>
                            <div>Horas Disciplinar (Profesional)</div>
                        </div>
                        <div class="col-xs-3">
                            <i class="fa fa-book-open fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="statistics-panel panel-primary">

                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-8 text-left">
                            <div class="huge">
                                <h3 id="horas_docentes"></h3>
                            </div>
                            <div>Horas Docentes (Pedagógica)</div>
                        </div>
                        <div class="col-xs-3">
                            <i class="fa fa-apple-whole fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="table-responsive">
        <table id="table_cap" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-heading"></i> Título</th>
                    <th><i class="fas fa-tag"></i> Tipo</th>
                    <th><i class="fas fa-map-marker-alt"></i> Lugar</th>
                    <th><i class="fas fa-user-tag"></i> Rol</th>
                    <th><i class="fas fa-user"></i> Nombre del instructor/asistente</th>
                    <th><i class="fas fa-calendar-day"></i> Fecha inicial</th>
                    <th><i class="fas fa-calendar-alt"></i> Fecha final</th>
                    <th><i class="fas fa-building"></i> Organización</th>
                    <th><i class="fas fa-briefcase"></i> Modalidad</th>
                    <th><i class="fas fa-clock"></i> Horas</th>
                    <th><i class="fas fa-info-circle"></i> Estado</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($capacitaciones as $key => $capacitacion): ?>
                    <tr>
                        <td><?= esc($capacitacion["titulo"]) ?></td>
                        <td class="tipo"><?= esc($capacitacion["tipo"]) ?></td>
                        <td><?= esc($capacitacion["lugar"]) ?></td>
                        <td><?= esc($capacitacion["rol"]) ?></td>
                        <td><?= esc($capacitacion["nombre_instructor"]) ?></td>
                        <td class="fecha_inicial"><?= date("d-m-Y", strtotime($capacitacion["fecha_inicial"])) ?></td>
                        <td><?= date("d-m-Y", strtotime($capacitacion["fecha_final"])) ?></td>
                        <td><?= esc($capacitacion["institucion"]) ?></td>
                        <td><?= esc($capacitacion["modalidad"]) ?></td>
                        <td class="horas"><?= esc($capacitacion["duracion_horas"]) ?></td>
                        <td class="estado"><?= esc($capacitacion["estado"]) ?></td>
                        <td>
                            <a class="btn btn-primary"
                                href="<?= base_url(); ?>/capacitaciones/mostrar/<?= esc($capacitacion["slug"]) ?>">
                                <i class="fas fa-eye"></i> Ver
                            </a>

                            <a class="btn btn-primary"
                                href="<?= base_url(); ?>/capacitaciones/editar/<?= esc($capacitacion["slug"]) ?>"
                                title="Editar capacitación">
                                <i class="fas fa-edit"></i>
                            </a>

                            <?php if ($_SESSION['rol'] != "admin"): ?>

                                <button type="button" class="btn btn-danger btn-eliminar"
                                    data-id="<?= esc($capacitacion["id"]) ?>" title="Eliminar Capacitación">
                                    <i class="fa fa-trash"></i>
                                </button>

                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>
<?php if ($_SESSION['rol'] === "admin"): ?>
    <div class="container" style="position: relative; min-height: 40px;">
        <div class="row mt-3">
            <div class="col-lg-12" style="position: absolute; bottom: 0; width: 100%;">
                <a class="btn btn-primary" href="<?= base_url(); ?>/usuarios">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>


<!-- /#page-wrapper -->

<script src="<?= base_url('dist/js/custom/capacitaciones/index.js') ?>"></script>


<?php $this->endSection(); ?>