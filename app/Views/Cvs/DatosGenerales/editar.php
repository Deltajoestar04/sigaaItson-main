<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>
<?php $session = session(); ?>


<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/editarDatosGenerales.css') ?>">
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?= session()->getFlashdata('error'); ?>
  </div>
<?php endif; ?>
<div class="section-container">
    <div class="header-container">
        <h2 class="page-header">
            <i class="fas fa-id-card"></i> Información Personal
        </h2>
    </div>

    <p class="section-description">
        Aquí puedes editar tu información personal.
    </p>

    <form method="POST" enctype="multipart/form-data" action="<?= base_url('/cv/datosgenerales/updateInformation/' . $usuario['id']) ?>">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre" class="blue-label">
                                <i class="fas fa-user"></i> Nombre:
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($usuario['nombre'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="apellido_paterno" class="blue-label">
                                <i class="fas fa-user"></i> Apellido Paterno:
                            </label>
                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="<?= esc($usuario['apellido_paterno'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="apellido_materno" class="blue-label">
                                <i class="fas fa-user"></i> Apellido Materno:
                            </label>
                            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="<?= esc($usuario['apellido_materno'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento" class="blue-label">
                                <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento:
                            </label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= esc($datosGenerales['fecha_nacimiento'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="edad" class="blue-label">
                                <i class="fas fa-birthday-cake"></i> Edad:
                            </label>
                            <input type="text" class="form-control" id="edad" name="edad" value="<?= esc($datosGenerales['edad'] ?? '') ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genero" class="blue-label">
                                <i class="fas fa-transgender"></i> Género:
                            </label>
                            <select class="form-control" id="genero" name="genero">
                                <option value="">Selecciona un género</option>
                                <option value="Masculino" <?= (esc($datosGenerales['genero'] ?? '') == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                                <option value="Femenino" <?= (esc($datosGenerales['genero'] ?? '') == 'Femenino') ? 'selected' : '' ?>>Femenino</option>
                                <option value="Otro" <?= (esc($datosGenerales['genero'] ?? '') == 'Otro') ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="blue-label">
                                <i class="fas fa-phone"></i> No. Teléfono:
                            </label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= esc($usuario['telefono'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="no_celular" class="blue-label">
                                <i class="fas fa-mobile-alt"></i> No. Celular:
                            </label>
                            <input type="tel" class="form-control" id="no_celular" name="no_celular" value="<?= esc($datosGenerales['no_celular'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="correo" class="blue-label">
                                <i class="fas fa-envelope"></i> Correo Electrónico:
                            </label>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?= esc($usuario['correo'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="correo_adicional" class="blue-label">
                                <i class="fas fa-envelope-open"></i> Correo Electrónico Alterno:
                            </label>
                            <input type="email" class="form-control" id="correo_adicional" name="correo_adicional" value="<?= esc($usuario['correo_adicional'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="foto_personal" class="blue-label">
                        <i class="fas fa-camera"></i> Foto Personal:
                    </label>
                    <div class="photo-container mb-3">
                        <img src="<?= !empty($datosGenerales['foto_personal']) ? base_url('uploads/fotos_personales/' . $datosGenerales['foto_personal']) : base_url('fotodefecto.png') ?>" alt="Foto Personal" id="preview-image">
                    </div>
                    <div class="custom-file text-center">
                        <input type="file" class="custom-file-input" id="foto_personal" name="foto_personal" accept=".jpg,.jpeg,.png" onchange="previewImage(event)">
                        <label class="custom-file-label" for="foto_personal">Seleccionar archivo</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right btn-editar">
            <a href="<?= base_url('cv/datosgenerales') ?>" class="btn btn-secondary" title="Cancelar">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary" title="Guardar Cambios">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script src="<?= base_url('dist/js/custom/cv/datosGenerales/editarDatosGenerales.js') ?>"></script>

<?php $this->endSection(); ?>
