<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>


<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">

<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-list"></i> Listado de maestro</h2>
    </div>

    <div class="table-responsive">
        <table id="table_cv" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Nombre</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= esc($usuario['nombre']) .' ' . esc($usuario['apellido_paterno']) .' '. esc($usuario['apellido_materno'])?></td>

                            <td>
    <a href="<?= base_url('/admin/ver_cv/' . $usuario['slug']) ?>" class="btn btn-primary">Ver CV</a>
    <a href="<?= base_url('/admin/descargarPDF/' . $usuario['id']) ?>" class="btn btn-danger">Descargar PDF</a>
</td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->endSection(); ?>