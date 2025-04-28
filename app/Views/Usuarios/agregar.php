<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>
<link href="<?= base_url() ?>/dist/css/custom/usuario/agregar.css" rel="stylesheet" type="text/css">
   <div class="register-container">
            <div class="register-panel">
                <div class="panel-heading">
                    <div class="panel-title-container">
                        <h3 class="panel-title"><i class="fas fa-user-plus"></i> Registro de Maestro</h3>
                    </div>
                </div>

                <div class="panel-body">
                <div class="panel-description">
            <p>
              <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
              Complete el formulario a continuación para agregar un nuevo maestro al sistema. Asegúrese de ingresar toda la información de manera correcta y completa. Una vez que envíe este formulario, el maestro será añadido a la base de datos.

            </p>
          </div>
                    <form action="<?= base_url(); ?>/Usuario/save" method="POST">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-user"></i> Nombre</label>
                                    <input class="form-control" value="<?= old('nombre') ?>" name="nombre"
                                        placeholder="Su nombre">
                                    <p class='page-warning'><?= session('errors.nombre') ?></p>
                                    <?php if (session('nom') !== null): ?>
                                        <p class='page-warning'><?= session('nom') ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-user"></i> Apellido Paterno</label>
                                    <input class="form-control" value="<?= old('apellido_paterno') ?>"
                                        name="apellido_paterno" placeholder="Su apellido paterno">
                                    <p class='page-warning'><?= session('errors.apellido_paterno') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-user"></i> Apellido Materno</label>
                                    <input class="form-control" value="<?= old('apellido_materno') ?>"
                                        name="apellido_materno" placeholder="Su apellido materno">
                                    <p class='page-warning'><?= session('errors.apellido_materno') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-envelope"></i> Correo electrónico</label>
                                    <input class="form-control" value="<?= old('correo') ?>" name="correo"
                                        placeholder="Correo institucional de ITSON">
                                    <p class='page-warning'><?= session('errors.correo') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-phone"></i> Teléfono</label>
                                    <input class="form-control" value="<?= old('telefono') ?>" name="telefono"
                                        placeholder="Teléfono de contacto">
                                    <p class='page-warning'><?= session('errors.telefono') ?></p>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-lock"></i> Contraseña</label>
                                    <input type="password" class="form-control" name="contrasena"
                                        placeholder="Ingrese una contraseña segura">
                                    <p class='page-warning'><?= session('errors.contrasena') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-lock"></i> Confirme su contraseña</label>
                                    <input type="password" class="form-control" name="confirmar_contrasena"
                                        placeholder="Verifique su contraseña">
                                    <p class='page-warning'><?= session('errors.confirmar_contrasena') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-users"></i> Rol de Usuario</label>
                                    <select class="form-control" name="rol">
                                        <option value="">Seleccione un rol...</option>
                                        <option value="Maestro" <?= old('rol') == 'Maestro' ? 'selected' : '' ?>>Maestro
                                        </option>
                                        <option value="Estudiante" <?= old('rol') == 'Estudiante' ? 'selected' : '' ?>>
                                            Estudiante</option>
                                    </select>
                                    <p class='page-warning'><?= session('errors.rol') ?></p>
                                </div>

                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-university"></i> Campus</label>
                                    <select class="form-control" name="id_campus">
                                        <option value="">Seleccione un campus...</option>
                                        <?php foreach ($campus as $campusItem): ?>
                                            <option value="<?= $campusItem['id'] ?>" <?= old('id_campus') == $campusItem['id'] ? 'selected' : '' ?>>
                                                <?= $campusItem['nombre'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class='page-warning'><?= session('errors.id_campus') ?></p>
                                </div>

                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-id-card"></i> ID (Con ceros)</label>
                                    <input class="form-control" value="<?= old('matricula') ?>" name="matricula"
                                        placeholder="ID institucional de ITSON">
                                    <p class='page-warning'><?= session('errors.matricula') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="<?= base_url(); ?>/usuario" class="btn btn-danger"><i class="fas fa-times"></i>
                                Cancelar</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-user-plus"></i>
                                Agregar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>


<?php $this->endSection(); ?>