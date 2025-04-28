<?php $this->extend("General"); ?> 
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/Indicador/general.css') ?>">

<div class="section-container">
  <div class="header-container">
    <h2 class="header-title"><i class="fas fa-chart-bar"></i> Indicadores</h2>
  </div>

  <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
    <!-- Descripción y tabla de clasificación lado a lado -->
    <div style="flex: 1; min-width: 300px;">
      <p class="section-description">
        <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
        En esta sección, puedes visualizar los indicadores registrados.
      </p>
      <div class="table-responsive">
        <table id="table_indicadores" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th><i class="fas fa-tag"></i> Indicador</th>
              <th><i class="fas fa-chart-line"></i> Valor</th>
              <th><i class="fas fa-comment"></i> Comentarios</th>
              <th><i class="fas fa-bullseye"></i> Objetivo</th>
              <th><i class="fas fa-align-left"></i> Descripción</th>
              <th><i class="fas fa-sort-numeric-down"></i> Cant. Mínima</th>
              <th><i class="fas fa-sigma"></i> Total</th>
              <th><i class="fas fa-flag-checkered"></i> Meta</th>
              <th><i class="fas fa-tools"></i> Acciones</th>
              <th><i class="fas fa-cogs"></i> Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($indicadores)): ?>
              <?php foreach ($indicadores as $item): ?>
                <tr>
                  <td><?= esc($item['Indicador']) ?></td>
                  <td><?= esc($item['Resultado']) ?></td>
                  <td><?= esc($item['Comentarios']) ?></td>
                  <td><?= esc($item['Objetivo']) ?></td>
                  <td><?= esc($item['Descripcion']) ?></td>
                  <td><?= esc($item['Cant_min']) ?></td>
                  <td><?= esc($item['Total']) ?></td>
                  <td><?= esc($item['Meta']) ?></td>
                  <td><?= esc($item['Acciones']) ?></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-editar-indicador" data-toggle="modal"
                            data-target="#indicadorModal" data-id="<?= $item['id'] ?>" title="Editar Indicador">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-eliminar-indicador"
                            data-id="<?= $item['id'] ?>" title="Eliminar Indicador">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="10" class="text-center">No hay indicadores registrados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div style="flex: 0 0 120px;">
      <h5 class="text-center font-weight-bold bg-warning py-2">CLASIFICACIÓN</h5>
      <table class="table table-bordered text-center">
        <tbody>
          <tr>
            <td class="bg-success text-white font-weight-bold">80% o mayor</td>
          </tr>
          <tr>
            <td class="bg-warning text-dark font-weight-bold">Entre 60% y 79%</td>
          </tr>
          <tr>
            <td class="bg-danger text-white font-weight-bold">Menor a 60%</td>
          </tr>
          <tr>
            <td class="bg-secondary text-white font-weight-bold">Igual a 0<br>N/A</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Modal para agregar/editar indicador -->
<div class="modal fade" id="indicadorModal" tabindex="-1" role="dialog" aria-labelledby="indicadorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="indicadorModalLabel">Agregar/Editar Indicador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/Indicador/guardar') ?>" method="post" id="modalFormIndicador">
          <input type="hidden" id="id_indicador" name="id_indicador">
          <div class="form-group">
            <label for="indicador"><i class="fas fa-tag"></i> Indicador</label>
            <input type="text" class="form-control" id="indicador" name="Indicador" placeholder="Ingrese el indicador" required>
          </div>
          <div class="form-group">
            <label for="resultado"><i class="fas fa-chart-line"></i> Resultado</label>
            <input type="text" class="form-control" id="resultado" name="Resultado" placeholder="Ingrese el resultado" required>
          </div>
          <div class="form-group">
            <label for="comentarios"><i class="fas fa-comment"></i> Comentarios</label>
            <textarea class="form-control" id="comentarios" name="Comentarios" rows="3" placeholder="Ingrese comentarios"></textarea>
          </div>
          <div class="form-group">
            <label for="objetivo"><i class="fas fa-bullseye"></i> Objetivo</label>
            <input type="text" class="form-control" id="objetivo" name="Objetivo" placeholder="Ingrese el objetivo">
          </div>
          <div class="form-group">
            <label for="descripcion"><i class="fas fa-align-left"></i> Descripción</label>
            <textarea class="form-control" id="descripcion" name="Descripcion" rows="2" placeholder="Ingrese la descripción"></textarea>
          </div>
          <div class="form-group">
            <label for="cant_min"><i class="fas fa-sort-numeric-down"></i> Cantidad Mínima</label>
            <input type="number" class="form-control" id="cant_min" name="Cant_min" placeholder="Ingrese cantidad mínima">
          </div>
          <div class="form-group">
            <label for="total"><i class="fas fa-sigma"></i> Total</label>
            <input type="number" class="form-control" id="total" name="Total" placeholder="Ingrese total">
          </div>
          <div class="form-group">
            <label for="meta"><i class="fas fa-flag-checkered"></i> Meta</label>
            <input type="text" class="form-control" id="meta" name="Meta" placeholder="Ingrese meta">
          </div>
          <div class="form-group">
            <label for="acciones"><i class="fas fa-tools"></i> Acciones</label>
            <input type="text" class="form-control" id="acciones" name="Acciones" placeholder="Ingrese acciones">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>
