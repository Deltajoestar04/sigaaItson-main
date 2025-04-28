<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>
<link href="<?= base_url() ?>/dist/css/custom/usuario/editar.css" rel="stylesheet" type="text/css">
<div class="register-container">
    <div class="register-panel">
        <div class="panel-heading">
            <div class="panel-title-container">
                <h3 class="panel-title"><i class="fas fa-user-edit"></i> Editar Maestro</h3>
            </div>
        </div>

        <div class="panel-body">
            <div class="panel-description">
                <p>
                    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
                    Complete el formulario a continuación para editar la información de un maestro en nuestro sistema.
                    Asegúrese de ingresar los detalles correctos y de manera completa.
                </p>
            </div>
            <form action="<?= base_url("/usuario/update/{$usuario['id']}") ?>" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="label-blue"><i class="fas fa-user"></i> Nombre</label>
                            <input class="form-control" value="<?= $usuario["nombre"] ?>" name="nombre"
                                placeholder="Su nombre">
                            <p class='page-warning'><?= session('errors.nombre') ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-blue"><i class="fas fa-user"></i> Apellido Paterno</label>
                            <input class="form-control" value="<?= $usuario["apellido_paterno"] ?>"
                                name="apellido_paterno" placeholder="Su apellido paterno">
                            <p class='page-warning'><?= session('errors.apellido_paterno') ?></p>
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-blue"><i class="fas fa-user"></i> Apellido Materno</label>
                            <input class="form-control" value="<?= $usuario["apellido_materno"] ?>"
                                name="apellido_materno" placeholder="Su apellido materno">
                            <p class='page-warning'><?= session('errors.apellido_materno') ?></p>
                        </div>

                        <div class="form-group mb-3">
                            <label class="label-blue"><i class="fas fa-phone"></i> Teléfono</label>
                            <input class="form-control" value="<?= $usuario["telefono"] ?>" name="telefono"
                                placeholder="Teléfono de contacto">
                            <p class='page-warning'><?= session('errors.telefono') ?></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="label-blue"><i class="fas fa-envelope"></i> Correo electrónico</label>
                            <input class="form-control" value="<?= $usuario["correo"] ?>" name="correo"
                                placeholder="Correo institucional de ITSON">
                            <p class='page-warning'><?= session('errors.correo') ?></p>
                        </div>
                        <?php if ($_SESSION['rol'] == "admin"): ?>
                            <div class="form-group mb-3">
                                <label class="label-blue"><i class="fas fa-id-card"></i> ID</label>
                                <input class="form-control" value="<?= $usuario["matricula"] ?>" name="matricula"
                                    placeholder="Matrícula institucional de ITSON">
                                <p class='page-warning'><?= session('errors.matricula') ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="form-group mb-3">
                            <label class="label-blue"><i class="fas fa-university"></i> Campus</label>
                            <select class="form-control" name="id_campus">
                                <option value="">Seleccione un campus...</option>
                                <?php foreach ($campus as $campusItem): ?>
                                    <option value="<?= $campusItem['id'] ?>" <?= ($campusItem['id'] == $usuario['id_campus']) ? 'selected' : '' ?>>
                                        <?= $campusItem['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class='page-warning'><?= session('errors.id_campus') ?></p>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <?php $cancelUrl = ($_SESSION['rol'] == 'admin') ? base_url('/usuario') : base_url("/usuario/perfil/{$usuario['id']}"); ?>

                    <a href="<?= $cancelUrl ?>" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar</a>

                    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $this->endSection(); ?>

<div class="form-group col-md-6">

    <label for="id_campus"><i class="fas fa-file-alt"></i> Campus Imparte</label>

    <select class="form-control" name="id_campus">

        <option value="">Seleccione un campus...</option>

        <?php foreach ($campus as $camp): ?>

            <option value="<?= $camp['id'] ?>" <?= old('id_campus') == $camp['id'] ? 'selected' : '' ?>>

                <?= $camp['nombre'] ?>

            </option>

        <?php endforeach; ?>

    </select>

    <p class='page-warning'><?= session('errors.id_campus') ?></p>

</div>