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

      <label for="prog_edu_id">Filtrar por Programa Educativo:</label>
      <select name="prog_edu_id" id="programa" class="form-control">
        <option value="">-- Selecciona un programa --</option>
        <?php foreach ($programas as $programa): ?>
          <option value="<?= $programa['id']; ?>" <?= ($programa['id'] == old('prog_edu_id')) ? 'selected' : ''; ?>>
            <?= esc($programa['nombre']); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <div class="table-responsive">
        <table id="table_indicadores" class="table table-striped table-bordered">
          <thead>
            <tr>
               <th><i class="fas fa-user"></i> Obj. Particular</th>
              <th><i class="fas fa-align-left"></i> Descripción</th>
              <th><i class="fas fa-sort-numeric-down"></i> Cant. Mínima</th>
              <th><i class="fad fa-trophy-alt"></i> Total Obtenido</th>
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
                <tr data-id="<?= $item['id'] ?>">
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

<!-- Modal -->
 <!-- Agregar -->
<div class="modal fade" id="modalIndicador" tabindex="-1" role="dialog" aria-labelledby="modalIndicadorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('Indicador/guardar') ?>" method="POST" id="formIndicador">
        <div class="modal-header">
          <h5 class="modal-title" id="modalIndicadorLabel"><i class="fas fa-plus"></i> Nuevo Indicador</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" id="errorModal" style="display: none;"></div>
          <input type="hidden" name="id_indicador" id="id_indicador">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="obj_particular"><i class="fas fa-user"></i> Objetivo Particular</label>
              <input type="text" class="form-control" id="obj_particular" name="obj_particular">
            </div>
            <div class="form-group col-md-6">
              <label for="descripcion"><i class="fas fa-align-left"></i> Descripción</label>
              <input type="text" class="form-control" id="descripcion" name="descripcion">
            </div>
          </div>

          <div class="form-group">
            <label for="prog_edu_id"><i class="fas fa-graduation-cap"></i> Programa Educativo</label>
            <select class="form-control" id="prog_edu_id" name="prog_edu_id">
              <option value="">-- Selecciona un programa --</option>
              <?php foreach ($programas as $programa): ?>
                <option value="<?= $programa['id']; ?>"><?= esc($programa['nombre']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="cant_minima"><i class="fas fa-sort-numeric-down"></i> Cantidad Mínima</label>
              <input type="number" class="form-control" id="cant_minima" name="cant_minima">
            </div>
            <div class="form-group col-md-4">
              <label for="total_obtenido"><i class="fas fa-sigma"></i> Total Obtenido</label>
              <input type="number" class="form-control" id="total_obtenido" name="total_obtenido">
            </div>
            <div class="form-group col-md-4">
              <label for="meta"><i class="fas fa-flag-checkered"></i> Meta (%)</label>
              <input type="number" class="form-control" id="meta" name="meta" max="100" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="indicador"><i class="fas fa-tag"></i> Indicador</label>
            <input type="text" class="form-control" id="indicador" name="indicador">
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="comentarios"><i class="fas fa-comment"></i> Comentarios</label>
              <textarea class="form-control" id="comentarios" name="comentarios" rows="2"></textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="estrategias_semaforo_verde"><i class="fas fa-tools"></i> Estrategias</label>
              <textarea class="form-control" id="estrategias_semaforo_verde" name="estrategias_semaforo_verde" rows="2"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
  var baseUrl = '<?= base_url() ?>';

  // Filtro por programa
  document.getElementById("programa").addEventListener("change", function () {
    var progEduId = this.value;

    fetch(baseUrl + '/Indicador/obtenerIndicadoresPorPrograma?prog_edu_id=' + progEduId)
      .then(response => response.json())
      .then(data => {
        var tbody = document.querySelector("#tbody_indicadores");
        tbody.innerHTML = "";

        if (data.length > 0) {
          data.forEach(function (item) {
            var resultado = parseFloat(item.resultado);
            var claseResultado = resultado >= 80 ? 'bg-verde' :
                                 resultado >= 60 ? 'bg-amarillo' :
                                 resultado > 0 ? 'bg-rojo' : 'bg-gris';

            var tr = document.createElement("tr");
            tr.setAttribute('data-id', item.id);
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
          tbody.innerHTML = `<tr><td colspan="9" class="text-center">No hay indicadores registrados.</td></tr>`;
        }
      })
      .catch(error => console.error("Error al obtener los indicadores:", error));
  });

  // Edición en línea por doble clic (excluyendo campo "Resultado")
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("table_indicadores");

    table.addEventListener("dblclick", function (e) {
      const target = e.target;

      if (target.tagName === "TD" && !target.classList.contains("editing")) {
        const colIndex = [...target.parentNode.children].indexOf(target);

        // Excluir la columna de "Resultado" (índice 5)
        if (colIndex === 5) return;

        const originalText = target.textContent.trim();
        const input = document.createElement("input");
        input.value = originalText;
        input.className = "form-control form-control-sm";
        target.classList.add("editing");
        target.innerHTML = "";
        target.appendChild(input);
        input.focus();

        input.addEventListener("blur", function () {
          const newText = input.value.trim();
          target.innerHTML = newText;
          target.classList.remove("editing");

          const row = target.closest("tr");
          const id = row.dataset.id;

          const fieldNames = ["obj_particular", "descripcion", "cant_minima", "total_obtenido", "meta", "resultado", "indicador", "comentarios", "estrategias_semaforo_verde"];
          const field = fieldNames[colIndex];

          fetch(`${baseUrl}/Indicador/editarCampo`, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({ id: id, campo: field, valor: newText })
          })
          .then(response => response.json())
          .then(data => {
  if (!data.success) {
    alert("Error al guardar: " + data.message);
  } else {cargarTablaIndicadores
    // Recargar la tabla con el filtro actual
    const programaSelect = document.getElementById("programa");
    const progEduId = programaSelect.value;
    cargarTablaIndicadores(progEduId);
  }
})

          .catch(error => {
            console.error("Error:", error);
            alert("Error de red");
          });
        });
      }
    });
  });
  function cargarTablaIndicadores(progEduId) {
  fetch(baseUrl + '/Indicador/obtenerIndicadoresPorPrograma?prog_edu_id=' + progEduId)
    .then(response => response.json())
    .then(data => {
      var tbody = document.querySelector("#tbody_indicadores");
      tbody.innerHTML = "";

      if (data.length > 0) {
        data.forEach(function (item) {
          var resultado = parseFloat(item.resultado);
          var claseResultado = resultado >= 80 ? 'bg-verde' :
                               resultado >= 60 ? 'bg-amarillo' :
                               resultado > 0 ? 'bg-rojo' : 'bg-gris';

          var tr = document.createElement("tr");
          tr.setAttribute('data-id', item.id);
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
        tbody.innerHTML = `<tr><td colspan="9" class="text-center">No hay indicadores registrados.</td></tr>`;
      }
    })
    .catch(error => console.error("Error al recargar los indicadores:", error));
}

</script>

<script src="<?= base_url('dist/js/custom/Indicador/general.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/Indicador/indicador.js') ?>"></script>

<?php $this->endSection(); ?>