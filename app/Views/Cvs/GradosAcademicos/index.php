<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">




<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de grados académicos -->
<!-- ---------------------------------------- -->
<div class="section-container">
  <div class="header-container">
    <h2 class="header-title">
      <i class="fas fa-graduation-cap"></i> Grados académicos
    </h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gradoModal">
      <i class="fas fa-plus-circle"></i> Agregar nuevo grado académico
    </button>
  </div>
  <p class="section-description">
  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección puedes visualizar y gestionar tus grados académicos. Agrega, edita o elimina registros según sea
    necesario para mantener tu información académica actualizada.
  </p>

  <div class="table-responsive">
    <table class="table table-striped table-bordered" id="table_grado">
      <thead>
        <tr>
          <th><i class="fas fa-certificate"></i> Nombre del grado académico</th>
          <th><i class="fas fa-university"></i> Institución</th>
          <th><i class="fas fa-globe"></i> País</th>
          <th><i class="fas fa-calendar-alt"></i> Fecha de inicio</th>
          <th><i class="fas fa-calendar-check"></i> Fecha final</th>
          <th><i class="fas fa-calendar-day"></i> Año de titulación</th>
          <th><i class="fas fa-id-card"></i> No. de cédula</th>
          <th><i class="fas fa-file-alt"></i> Tipo de cédula</th>
          <th><i class="fas fa-layer-group"></i> Nivel</th>
          <th><i class="fas fa-calendar-alt"></i> Fecha de inicio PRODEP</th>
          <th><i class="fas fa-calendar-check"></i> Fecha de término PRODEP</th>
          <th><i class="fas fa-cogs"></i> Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($grados)): ?>
          <?php foreach ($grados as $grado): ?>
            <tr>
              <td><?= esc($grado['nombre_grado']) ?></td>
              <td><?= esc($grado['institucion']) ?></td>
              <td><?= esc($grado['pais']) ?></td>
              <td><?= esc(date('d-m-Y', strtotime($grado['fecha_inicio']))) ?></td>
              <td><?= esc(date('d-m-Y', strtotime($grado['fecha_final']))) ?></td>
              <td><?= esc($grado['fecha_titulacion']) ?></td>
              <td><?= esc($grado['no_cedula']) ?></td>
              <td><?= esc($grado['tipo_cedula']) ?></td>
              <td><?= esc($grado['nivel'] ?: 'No disponible') ?></td>

              <td>
                <?= esc($grado['fecha_comienzo'] ? date('d-m-Y', strtotime($grado['fecha_comienzo'])) : 'No disponible') ?>
              </td>
              <td><?= esc($grado['fecha_termino'] ? date('d-m-Y', strtotime($grado['fecha_termino'])) : 'No disponible') ?>
              </td>

              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gradoModal"
                  data-id="<?= esc($grado['id']) ?>" data-nombre_grado="<?= esc($grado['nombre_grado']) ?>"
                  data-institucion="<?= esc($grado['institucion']) ?>" data-pais="<?= esc($grado['pais']) ?>"
                  data-fecha_inicio="<?= esc($grado['fecha_inicio']) ?>"
                  data-fecha_final="<?= esc($grado['fecha_final']) ?>"
                  data-fecha_titulacion="<?= esc($grado['fecha_titulacion']) ?>"
                  data-no_cedula="<?= esc($grado['no_cedula']) ?>" data-tipo_cedula="<?= esc($grado['tipo_cedula']) ?>"
                  data-nivel="<?= esc($grado['nivel']) ?>" data-fecha_comienzo="<?= esc($grado['fecha_comienzo']) ?>"
                  data-fecha_termino="<?= esc($grado['fecha_termino']) ?>">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-eliminar-grado-academico"
                  data-id="<?= esc($grado['id']) ?>">
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
<!-- Modal para agregar/editar un grado academico-->
<!-- ---------------------------------------- -->
<div class="modal fade" id="gradoModal" tabindex="-1" role="dialog" aria-labelledby="gradoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gradoModalLabel">Agregar Nuevo Grado Académico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
        <form action="<?= base_url("Cv/gradosacademicos/save") ?>" method="post" id="modalFormGrado">
          <input type="hidden" name="id_grado_academico" id="id_grado_academico">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="nombre_grado"><i class="fas fa-certificate"></i> Nombre del grado académico</label>
              <input type="text" class="form-control" id="nombre_grado" name="nombre_grado"
                placeholder="Ingrese el nombre del grado">
              <div class="page-warning"></div>
            </div>
            <div class="form-group col-md-6">
              <label for="institucion"><i class="fas fa-university"></i> Institución</label>
              <input type="text" class="form-control" id="institucion" name="institucion"
                placeholder="Ingrese la institución">
              <div class="page-warning"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="pais"><i class="fas fa-globe"></i> País</label>
              <input type="text" class="form-control" id="pais" name="pais" placeholder="Ingrese el país">
              <div class="page-warning"></div>
            </div>
            <div class="form-group col-md-6">
              <label for="fecha_inicio"><i class="fas fa-calendar-alt"></i> Periodo - fecha de inicio</label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
              <div class="page-warning"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="fecha_final"><i class="fas fa-calendar-check"></i> Periodo - fecha final</label>
              <input type="date" class="form-control" id="fecha_final" name="fecha_final">
              <div class="page-warning"></div>
            </div>
            <div class="form-group col-md-6">
              <label for="fecha_titulacion"><i class="fas fa-calendar-day"></i> Año de titulación</label>
              <input type="number" class="form-control" id="fecha_titulacion" name="fecha_titulacion"
                placeholder="Ingrese el año">
              <div class="page-warning"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="no_cedula"><i class="fas fa-id-card"></i> No. de Cédula</label>
              <input type="text" class="form-control" id="no_cedula" name="no_cedula"
                placeholder="Ingrese el numero de cedula">
              <div class="page-warning"></div>
            </div>
            <div class="form-group col-md-6">
              <label for="tipo_cedula"><i class="fas fa-file-alt"></i> Tipo de cédula</label>
              <select id="tipo_cedula" name="tipo_cedula" class="form-control">
                <option selected>Elige...</option>
                <option>Federal</option>
                <option>Estatal</option>
              </select>
              <div class="page-warning"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="sni_check" name="sni_check">
                <label class="form-check-label" for="sni_check">
                  <i class="fas fa-layer-group"></i> Pertenece al Sistema Nacional de Investigadores (SNI)
                </label>
              </div>
              <div id="sni_nivel_container" style="display:none; margin-top: 10px;">
                <label for="sni_nivel"><i class="fas fa-layer-group"></i> Nivel SNI:</label>
                <select id="sni_nivel" name="sni_nivel" class="form-control">
                  <option value="" selected>Seleccione nivel...</option>
                  <option value="Candidato">Candidato</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </div>
              <div class="page-warning"></div>
            </div>
            <div class="form-group col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prodep_check" name="prodep_check">
                <label class="form-check-label" for="prodep_check">
                  <i class="fas fa-calendar-alt"></i> Pertenece al Programa para el Desarrollo Profesional Docente
                  (PRODEP)
                </label>
              </div>
              <div id="prodep_fechas" style="display:none; margin-top: 10px;">
                <div class="form-group">
                  <label for="fecha_comienzo"><i class="fas fa-calendar-alt"></i> Fecha inicio PRODEP</label>
                  <input type="date" class="form-control" id="fecha_comienzo" name="fecha_comienzo">
                </div>
                <div class="form-group">
                  <label for="fecha_termino"><i class="fas fa-calendar-check"></i> Fecha término PRODEP</label>
                  <input type="date" class="form-control" id="fecha_termino" name="fecha_termino">
                </div>
              </div>
              <div class="page-warning"></div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i>
          Cancelar</button>
        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Guardar</button>
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
<script src="<?= base_url('dist/js/custom/cv/gradoAcademico.js') ?>"></script>




<?php $this->endSection(); ?>