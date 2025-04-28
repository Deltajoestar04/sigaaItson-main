<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">
<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de logros -->
<!-- ---------------------------------------- -->
<div class="section-container">
  <div class="header-container">
    <h2 class="header-title"><i class="fas fa-trophy"></i> Logros</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#logroModal">
      <i class="fas fa-plus-circle"></i> Agregar Logro
    </button>
  </div>
  <p class="section-description">  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes agregar nuevos logros, así como editar o eliminar logros existentes.</p>

  <div class="table-responsive">
    <table id="table_logro" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th><i class="fas fa-info-circle"></i> Descripción</th>
          <th><i class="fas fa-tag"></i> Tipo</th>
          <th><i class="fas fa-cogs"></i> Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($logros)): ?>
          <?php foreach ($logros as $logro): ?>
            <tr>
              <td><?= esc($logro['descripcion']) ?></td>
              <td><?= esc($logro['tipo']) ?></td>
              <td>
                <button type="button" class="btn btn-sm btn-primary btn-editar-logro" data-toggle="modal"
                  data-target="#logroModal" data-id="<?= $logro['id'] ?>" data-tipo="<?= esc($logro['tipo']) ?>"
                  data-descripcion="<?= esc($logro['descripcion']) ?>">
                  <i class="fas fa-edit"></i> 
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-eliminar-logro" data-id="<?= $logro['id'] ?>">
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
<!-- Modal para agregar o editar logro -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="logroModal" tabindex="-1" role="dialog" aria-labelledby="logroModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logroModalLabel"><i class="fas fa-trophy"></i> Agregar Logro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="logros-form"  action="<?= base_url('Cv/logro/save') ?>" method="post" id="modalFormLogro">
          <input type="hidden" id="id_logro" name="id_logro">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="descripcion"><i class="fas fa-info-circle"></i> Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4"></textarea>
                <div class="page-warning"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipo"><i class="fas fa-tag"></i> Tipo</label>
                <select class="form-control" id="tipo" name="tipo">
                  <option value="">Seleccione un tipo...</option>
                  <option value="Profesional">Profesional</option>
                  <option value="Academico">Académico</option>
                </select>
                <div class="page-warning"></div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
      </div>
      </form>
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
<script src="<?= base_url('dist/js/custom/cv/logro.js') ?>"></script>
<?php $this->endSection(); ?>