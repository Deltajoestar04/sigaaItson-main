<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">
<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de clases -->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title">
            Gestión de clases - <?= esc($experienciaDocente['puesto_area']) ?> en
            <?= esc($experienciaDocente['institucion']) ?>
        </h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#claseImpartidaModal"
            id="addClaseImpartidaBtn">
            <i class="fa fa-plus-circle"></i> Agregar clase
        </button>
    </div>
    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
        En esta sección puedes gestionar las clases asociadas a tu experiencia docente como
        <?= esc($experienciaDocente['puesto_area']) ?> en <?= esc($experienciaDocente['institucion']) ?>. Agrega, edita
        o elimina clases para mantener actualizada tu información sobre las clases impartidas.
    </p>

    <div class="table-responsive">
        <table id="table_clases_impartidas" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-book"></i> Nombre de la Clase</th>
                    <th><i class="fas fa-book-open"></i> Programa Educativo</th>
                    <th><i class="fas fa-clock"></i> Número de Horas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clasesImpartidas as $clase): ?>
                    <tr>
                        <td><?= esc($clase['nombre_clase']) ?></td>
                        <td><?= esc($clase['programa_educativo']) ?></td>
                        <td><?= esc($clase['numero_horas']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-editar-clase" data-toggle="modal"
                                data-target="#claseImpartidaModal" data-id="<?= $clase['id'] ?>"
                                data-nombre_clase="<?= esc($clase['nombre_clase']) ?>"
                                data-programa_educativo="<?= esc($clase['programa_educativo']) ?>"
                                data-numero_horas="<?= esc($clase['numero_horas']) ?>"
                                data-id_experiencia_docente="<?= $experienciaDocente['id'] ?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-eliminar-clase" data-id="<?= $clase['id'] ?>">
                                 <i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<a href="<?= base_url('/cv/experienciadocente') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Regresar</a>

<!-- ---------------------------------------- -->
<!-- Modal para agregar/editar clases -->
<!-- ---------------------------------------- -->
<div class="modal fade clase-impartida-modal" id="claseImpartidaModal" tabindex="-1" role="dialog"
    aria-labelledby="claseImpartidaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="claseImpartidaModalLabel">Agregar Clase Impartida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modalFormClaseImpartida" action="<?= base_url('Cv/experienciadocente/saveClass'); ?>"
                    method="post">
                    <input type="hidden" id="id_clase_impartida" name="id_clase_impartida">
                    <input type="hidden" id="id_experiencia_docente" name="id_experiencia_docente"
                        value="<?= $experienciaDocente['id'] ?>">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="nombre_clase">
                                <i class="fas fa-chalkboard-teacher"></i> Nombre de la Clase
                            </label>
                            <input type="text" class="form-control" id="nombre_clase" name="nombre_clase"
                                placeholder="Ingrese el nombre de la clase">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="programa_educativo">
                                <i class="fas fa-book"></i> Programa Educativo
                            </label>
                            <input type="text" class="form-control" id="programa_educativo" name="programa_educativo"
                                placeholder="Ingrese el programa educativo">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="numero_horas">
                                <i class="fas fa-clock"></i> Número de Horas
                            </label>
                            <input type="number" class="form-control" id="numero_horas" name="numero_horas"
                                placeholder="Ingrese el número de horas" step="1">
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



<script>
    var baseUrl = '<?= base_url() ?>'; 
</script>
<script src="<?= base_url('dist/js/custom/cv/utils/commonFunctions.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/cv/experienciaDocente.js') ?>"></script>



<?php $this->endSection(); ?>