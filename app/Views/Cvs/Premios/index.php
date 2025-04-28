<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">
<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de premios-->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-award"></i> Premios o Distinciones</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#premioModal">
            Agregar Premio o Distinción
        </button>
    </div>
    <p class="section-description">  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>En esta sección, puedes agregar nuevos premios o distinciones, así como editar o eliminar los premios o distinciones existentes.</p>

    <div class="table-responsive">
        <table id="table_premio" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-info-circle"></i> Descripción</th>
                    <th><i class="fas fa-calendar-alt"></i> Año</th>
                    <th><i class="fas fa-building"></i> Organismo</th>
                    <th><i class="fas fa-flag"></i> País</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($premios)): ?>
                    <?php foreach ($premios as $premio): ?>
                        <tr>
                            <td><?= esc($premio['descripcion']) ?></td>
                            <td><?= esc($premio['anio']) ?></td>
                            <td><?= esc($premio['organismo']) ?></td>
                            <td><?= esc($premio['pais']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary btn-editar-premio" data-toggle="modal"
                                    data-target="#premioModal" data-id="<?= $premio['id'] ?>" data-anio="<?= esc($premio['anio']) ?>"
                                    data-descripcion="<?= esc($premio['descripcion']) ?>" data-organismo="<?= esc($premio['organismo']) ?>"
                                    data-pais="<?= esc($premio['pais']) ?>">
                                    <i class="fas fa-edit"></i> 
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-eliminar-premio"
                                    data-id="<?= $premio['id'] ?>">
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
<!-- Modal para agregar o editar premio -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="premioModal" tabindex="-1" role="dialog" aria-labelledby="premioModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="premioModalLabel">Agregar Premio o Distinción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <form class="premios-form" action="<?= base_url('Cv/premio/save') ?>" method="post" id="modalFormPremio">
          <input type="hidden" id="id_premio" name="id_premio">
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
                <label for="anio"><i class="fas fa-calendar-alt"></i> Año</label>
                <select class="form-control" id="anio" name="anio">
                  <option value="">Seleccione un año...</option>
                  <?php for ($i = date("Y"); $i >= 1990; $i--): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                  <?php endfor; ?>
                </select>
                <div class="page-warning"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="organismo"><i class="fas fa-building"></i> Organismo</label>
                <input type="text" class="form-control" id="organismo" name="organismo">
                <div class="page-warning"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="pais"><i class="fas fa-flag"></i> País</label>
                <input type="text" class="form-control" id="pais" name="pais">
                <div class="page-warning"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
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
<script src="<?= base_url('dist/js/custom/cv/premio.js') ?>"></script>

<?php $this->endSection(); ?>
