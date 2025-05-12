<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/Indicador/general.css') ?>">

<div class="section-container">
  <div class="header-container d-flex justify-content-between align-items-center">
    <h2 class="header-title"><i class="fas fa-chart-bar"></i> Indicadores</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalIndicador">
      <i class="fas fa-plus"></i> Nuevo Indicador
    </button>
  </div>

  <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
    <div style="flex: 1; min-width: 300px;">
      <p class="section-description">
        <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
        En esta sección, puedes visualizar los indicadores registrados.
      </p>

      <!-- Filtro por Programa Educativo caja de seleccion -->
      <label for="prog_edu_id">Filtrar por Programa Educativo:</label>
      <select name="prog_edu_id" id="programa" class="form-control">
        <option value="">-- Selecciona un programa --</option>
        <?php foreach ($programas as $programa): ?>
          <option value="<?= esc($programa['id']) ?>"><?= esc($programa['nombre']) ?></option>
        <?php endforeach; ?>
      </select>

      <div class="table-responsive">
        <table id="table_indicadores" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th><i class="fas fa-user"></i> Obj. Particular</th>
              <th><i class="fas fa-align-left"></i> Descripción</th>
              <th><i class="fas fa-sort-numeric-down"></i> Cant. Mínima</th>
              <th><i class="fas fa-sigma"></i> Total Obtenido</th>
              <th><i class="fas fa-flag-checkered"></i> Meta</th>
              <th><i class="fas fa-chart-line"></i> Resultado</th>
              <th><i class="fas fa-tag"></i> Indicador</th>
              <th><i class="fas fa-comment"></i> Comentarios</th>
              <th><i class="fas fa-tools"></i> Acciones y/o Estrategias</th>
            </tr>
          </thead>
          <tbody id="tbody_indicadores">
            <?php if (!empty($indicadores)): ?>
              <?php foreach ($indicadores as $item): ?>
                <?php
                  $resultado = floatval($item['resultado']);
                  $claseResultado = $resultado >= 80 ? 'bg-verde' :
                                    ($resultado >= 60 ? 'bg-amarillo' : 
                                    ($resultado > 0 ? 'bg-rojo' : 'bg-gris'));
                ?>
                <tr>
                  <td><?= esc($item['obj_particular']) ?></td>
                  <td><?= esc($item['descripcion']) ?></td>
                  <td><?= esc($item['cant_minima']) ?></td>
                  <td><?= esc($item['total_obtenido']) ?></td>
                  <td><?= esc($item['meta']) ?>%</td>
                  <td class="<?= $claseResultado ?>"><?= esc($item['resultado']) ?></td>
                  <td><?= esc($item['indicador']) ?></td>
                  <td><?= esc($item['comentarios']) ?></td>
                  <td><?= esc($item['estrategias_semaforo_verde']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center">No hay indicadores registrados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div style="flex: 0 0 80px;">
      <h5 class="text-center font-weight-bold bg-warning py-2">Clasificación</h5>
      <table class="table text-center" style="border: 2px solid #000; border-collapse: collapse;">
        <tbody>
          <tr><td class="bg-success text-white font-weight-bold">≥80%<br>Bueno</td></tr>
          <tr><td class="bg-warning text-dark font-weight-bold">60%-79%<br>Regular</td></tr>
          <tr><td class="bg-danger text-white font-weight-bold">1%-59%<br>Deficiente</td></tr>
          <tr><td class="bg-secondary text-white font-weight-bold">=0%<br>N/A</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal agregar/editar -->
<div class="modal fade" id="modalIndicador" tabindex="-1" role="dialog" aria-labelledby="modalIndicadorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('Indicador/guardar') ?>" method="POST" id="formIndicador">
        <div class="modal-body">
          <div class="alert alert-danger" id="errorModal" style="display: none;"></div>
        <div class="modal-header">
          <h5 class="modal-title" id="modalIndicadorLabel"><i class="fas fa-plus"></i> Nuevo Indicador</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_indicador" id="id_indicador">
          <!-- campos -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  var baseUrl = '<?= base_url() ?>';

  // Filtro por Programa Educativo caja de seleccion 
  document.getElementById("programa").addEventListener("change", function () {
    var progEduId = this.value;

    // Realizar la solicitud AJAX al controlador
    fetch(baseUrl + '/Indicador/obtenerIndicadoresPorPrograma?prog_edu_id=' + progEduId)
      .then(response => response.json())
      .then(data => {
        var tbody = document.querySelector("#tbody_indicadores");
        tbody.innerHTML = ""; // Limpiar la tabla antes de llenarla

        if (data.length > 0) {
          data.forEach(function (item) {
            var resultado = parseFloat(item.resultado);
            var claseResultado = resultado >= 80 ? 'bg-verde' :
                                 resultado >= 60 ? 'bg-amarillo' :
                                 resultado > 0 ? 'bg-rojo' : 'bg-gris';

            var tr = document.createElement("tr");
            tr.innerHTML = `
              <td>${item.obj_particular}</td>
              <td>${item.descripcion}</td>
              <td>${item.cant_minima}</td>
              <td>${item.total_obtenido}</td>
              <td>${item.meta}%</td>
              <td class="${claseResultado}">${item.resultado}</td>
              <td>${item.indicador}</td>
              <td>${item.comentarios}</td>
              <td>${item.estrategias_semaforo_verde}</td>
            `;
            tbody.appendChild(tr);
          });
        } else {
          var tr = document.createElement("tr");
          tr.innerHTML = `<td colspan="9" class="text-center">No hay indicadores registrados.</td>`;
          tbody.appendChild(tr);
        }
      })
      .catch(error => console.error("Error al obtener los indicadores:", error));
  });
</script>

<script src="<?= base_url('dist/js/custom/Indicador/general.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/Indicador/indicador.js') ?>"></script>

<?php $this->endSection(); ?>
