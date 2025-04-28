<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>
<?php $session = session(); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/usuario/perfil.css') ?>">
<div class="container-fluid main-container">
    <div class="row g-4">
      
    
        <?php if (session()->getFlashdata('msg')): ?>
            <div class="col-12">
                <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
            </div>
        <?php endif; ?>

      
        <div class="col-md-8">
            <div class="card custom-card h-100 d-flex flex-column">
                <div class="card-header">
                    <h5 class="mb-0 header-title"><i class="fas fa-info-circle"></i> Información Personal</h5>
                </div>
                <div class="card-body flex-grow-1">
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="fas fa-user"></i> Nombre: <span class="text-muted"><?= $usuario["nombre"]." ".$usuario["apellido_paterno"]." ".$usuario["apellido_materno"]?></span></p>
                            <p><i class="fas fa-id-card"></i> ID: <span class="text-muted"><?= $usuario["matricula"] ?></span></p>
                            <p><i class="fas fa-envelope"></i> Correo: <span class="text-muted"><?= $usuario["correo"] ?></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-envelope-open-text"></i> Correo Adicional: <span class="text-muted"><?= $usuario["correo_adicional"] ?></span></p>
                            <p><i class="fas fa-phone"></i> Teléfono: <span class="text-muted"><?= $usuario["telefono"] ?></span></p>
                            <p><i class="fas fa-university"></i> Campus: <span class="text-muted"><?= $nombreCampus ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-start">
                    <a href="/usuarios/editar/<?= $usuario['slug'] ?>" class="btn btn-primary btn-editar">
                            <i class="fas fa-edit"></i> 
                        </a>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="col-md-4">
            <div class="card custom-card">
                <div class="card-header">
                    <h5 class="mb-0 header-title"><i class="fas fa-question-circle"></i> ¿Necesitas ayuda?</h5>
                </div>
                <div class="card-body">
                    <p>Contáctanos al correo:</p>
                    <p><a href="mailto:soporte@ejemplo.com">soporte@ejemplo.com</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>