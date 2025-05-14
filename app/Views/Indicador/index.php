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
 <div class="modal fade" id="modalIndicador" tabindex="-1" aria-labelledby="modalIndicadorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formNuevoIndicador">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nuevo Indicador</h5>
        </div>
        
          <div class="modal-body">
          <div class="mb-3">
            <label for="obj_particular" class="form-label"><i class="fas fa-user"></i> Obj. Particular</label>
            <input type="text" class="form-control" id="obj_particular" name="obj_particular" required>  
          </div>

          <div class="mb-3">
            <label for="descripcion"  class="form-label" >Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="2" required></textarea>
          </div>

          <div class="mb-3">
    <label for="prog_edu_id" class="form-label">
        <i class="fas fa-graduation-cap"></i> Programa Educativo
    </label>
    <select class="form-select" id="prog_edu_id" name="prog_edu_id" required>
        <option value="">-- Selecciona un programa --</option>
        <?php foreach ($programas as $programa): ?>
            <option value="<?= esc($programa['id']); ?>">
                <?= esc($programa['nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="cant_minima" class="form-label"><i class="fas fa-sort-numeric-down"></i> Cant. Mínima</label>
              <input type="number" class="form-control" id="cant_minima" name="cant_minima" max="100" min="0">
            </div>
            <div class="col-md-4 mb-3">
              <label for="total_obtenido" class="form-label"><i class="fas fa-sort-numeric-down"></i> Total Obtenido</label>
              <input type="number" class="form-control" id="total_obtenido" name="total_obtenido" max="100" min="0">
            </div>
            <div class="col-md-4 mb-3">
              <label for="meta" class="form-label"><i class="fas fa-sort-numeric-down"></i> Meta (%)</label>
              <input type="number" class="form-control" id="meta" name="meta" max="100" min="0">
            </div>
          </div>

          <div class="mb-3">
            <label for="indicador" class="form-label"><i class="fas fa-tag"></i> Indicador</label>
            <input type="text" class="form-control" id="indicador" name="indicador">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="comentarios" class="form-label"><i class="fas fa-comment"></i> Comentarios</label>
              <textarea class="form-control" id="comentarios" name="comentarios" rows="2"></textarea>
            </div>
            <div class="col-md-6 mb-3">
              <label for="estrategias_semaforo_verde" class="form-label"><i class="fas fa-tools"></i> Acciones y/o Estrategias</label>
              <textarea class="form-control" id="estrategias_semaforo_verde" name="estrategias_semaforo_verde" rows="2"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
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
  } else {
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

editable.addEventListener('blur', function () {
    console.log("Blur activado, enviando datos...");
    fetch('/indicador/actualizar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            id: id,
            campo: campo,
            valor: valor
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


//guardar el nuevo indicador
// Mostrar el modal al hacer clic en "Nuevo Indicador"
document.addEventListener('DOMContentLoaded', function() {
    // Agregar el evento de doble clic a cada celda editable
    const editableCells = document.querySelectorAll('.editable'); // Selecciona todas las celdas con la clase 'editable'
    
    editableCells.forEach(function(cell) {
        cell.addEventListener('dblclick', function() {
            // Convertir la celda en un campo de texto editable
            const currentText = cell.innerText;
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentText;
            cell.innerHTML = '';  // Limpia la celda
            cell.appendChild(input);
            input.focus();

            // Cuando el campo de texto pierda el foco (blur), guardar el dato
            input.addEventListener('blur', function() {
                const newValue = input.value; // Obtener el nuevo valor del campo
                const cellId = cell.getAttribute('data-id'); // El ID de la fila o el identificador del registro
                const field = cell.getAttribute('data-field'); // El campo de la columna que se está editando

                // Llamar a la función para enviar los datos al servidor mediante AJAX
                guardarDatos(cellId, field, newValue, cell);
            });
        });
    });
});

// Función para enviar la petición AJAX
function guardarDatos(id, campo, valor, cell) {
    console.log("Enviando datos:", { id, campo, valor });

    // Enviar los datos al servidor mediante fetch (AJAX)
    fetch('/indicador/actualizar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'  // Si tienes CSRF habilitado
        },
        body: JSON.stringify({
            id: id,
            campo: campo,
            valor: valor
        })
    })
    .then(response => response.json()) // Esperar respuesta en formato JSON
    .then(data => {
        if (data.success) {
            console.log('Datos actualizados correctamente.');
            // Si la actualización fue exitosa, actualizamos la celda
            cell.innerHTML = valor;
        } else {
            console.log('Error al actualizar:', data.message);
            // En caso de error, podemos mostrar un mensaje o dejar el valor original
            cell.innerHTML = data.message || 'Error al actualizar';
        }
    })
    .catch(error => {
        console.error('Error de conexión:', error);
        // Si hay error en la petición AJAX, podemos restaurar el valor original o manejar el error
        cell.innerHTML = 'Error de conexión';
    });
}



/*$('#formIndicador').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '<?= base_url("indicador/guardar") ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'ok') {
                    alert('Indicador guardado exitosamente');
                    // Opcional: recargar tabla o limpiar formulario
                    $('#formIndicador')[0].reset();
                } else {
                    alert('Error al guardar: ' + JSON.stringify(response.errors));
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Error en la petición AJAX');
            }
        });
    });*/
/*document.getElementById('formNuevoIndicador').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = new FormData(this);

    fetch('<?= base_url('/indicador/guardar') ?>', {
        method: 'POST',
        body: form
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            alert(data.message);
            // Opcional: recargar tabla, cerrar modal
            $('#modalIndicador').modal('hide');
            this.reset(); // Limpia el formulario
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => {
        console.error('Error en el guardado:', err);
    });
});*/

    
</script>

<script src="<?= base_url('dist/js/custom/Indicador/general.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/Indicador/indicador.js') ?>"></script>

<?php $this->endSection(); ?>