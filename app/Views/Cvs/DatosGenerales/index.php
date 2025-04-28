<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">
<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/DatosGenerales.css') ?>">


<!-- ---------------------------------------- -->
<!-- Contenido de los datos generales -->
<!-- ---------------------------------------- -->
<?php if (session()->getFlashdata('msg')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('msg'); ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?= session()->getFlashdata('error'); ?>
  </div>
<?php endif; ?>
<div class="section-container datos-generales-container">
  <div class="header-container">
    <h2 class="header-titler"><i class="fas fa-id-card"></i> Información Personal</h2>
  </div>

  <p class="section-description">
  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>Aquí puedes visualizar y gestionar tu información personal. Si necesitas actualizar algún dato, utiliza el botón de
    editar.
  </p>
  <div class="datos-generales">
    <div class="datos-generales-foto-container">
      <div class="datos-generales-foto">
        <?php if (!empty($datosGenerales['foto_personal'])): ?>
          <img src="<?= base_url('uploads/fotos_personales/' . $datosGenerales['foto_personal']) ?>" alt="Foto Personal">
        <?php else: ?>
          <img src="<?= base_url('fotodefecto.png') ?>" alt="Foto Personal">
        <?php endif; ?>
      </div>
    </div>
    <div class="datos-generales-info">
    <div class="datos-generales-nombre">
    <?= esc(
        ($usuario['nombre'] ?? '') . ' ' .
        ($usuario['apellido_paterno'] ?? '') . ' ' .
        ($usuario['apellido_materno'] ?? '')
    ) ?>
</div>

      <div class="datos-generales-columnas">
        <div class="datos-generales-columna">
          <div class="datos-item">
            <span class="datos-label"><i class="fas fa-birthday-cake"></i> Fecha de Nacimiento:</span>
            <span class="datos-valor">
    <?= esc(!empty(trim($datosGenerales['fecha_nacimiento']?? '')) 
            ? date('d-m-Y', strtotime($datosGenerales['fecha_nacimiento'])) 
            : 'No disponible') ?>
</span>

          </div>
            <div class="datos-item">
            <span class="datos-label"><i class="fas fa-user"></i> Edad:</span>
            <span
              class="datos-valor"><?= esc(!empty(trim($datosGenerales['edad']?? '')) ? $datosGenerales['edad'] : 'No disponible') ?></span>
          </div>
          <div class="datos-item">
            <span class="datos-label"><i class="fas fa-venus-mars"></i> Género:</span>
            <span
              class="datos-valor"><?= esc(!empty(trim($datosGenerales['genero'] ?? '')) ? $datosGenerales['genero'] : 'No disponible') ?></span>
          </div>
        </div>
        <div class="datos-generales-columna">
          <div class="datos-item">
            <span class="datos-label"><i class="fas fa-phone"></i> No. Teléfono:</span>
            <span
              class="datos-valor"><?= esc(!empty(trim($usuario['telefono'])) ? $usuario['telefono'] : 'No disponible') ?></span>
          </div>
          <div class="datos-item">
            <span class="datos-label"><i class="fas fa-mobile-alt"></i> No. Celular:</span>
            <span
              class="datos-valor"><?= esc(!empty(trim($datosGenerales['no_celular'] ?? '' )) ? $datosGenerales['no_celular'] : 'No disponible') ?></span>
          </div>
          <div class="datos-item">
            <span class="datos-label"><i class="fas fa-envelope"></i> Correo Electrónico:</span>
            <span
              class="datos-valor"><?= esc(!empty(trim($usuario['correo'])) ? $usuario['correo'] : 'No disponible') ?></span>
          </div>
          <div class="datos-item">
    <span class="datos-label"><i class="fas fa-envelope-open"></i> Correo Electrónico Alterno:</span>
    <span class="datos-valor">
        <?= esc(!empty($usuario['correo_adicional']) ? trim($usuario['correo_adicional']) : 'No disponible') ?>
    </span>
</div>

        </div>

      </div>
    </div>

  </div>
  <div class="text-right btn-editar">
    <a href="<?= base_url('/cv/datosgenerales/editarInformacion') ?>" class="btn btn-primary"
      title="Editar Información">
      <i class="fas fa-edit"></i>
    </a>
  </div>
</div>





<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de domicilio -->
<!-- ---------------------------------------- -->

<div class="section-container">
  <div class="header-container">
    <h2 class="header-title"><i class="fas fa-map-marker-alt"></i> Domicilio</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domicilioModal"
      title="Agregar Domicilio">
      <i class="fas fa-plus-circle"></i> Agregar Domicilio
    </button>
  </div>
  <p class="section-description">
  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes ver y gestionar los domicilios registrados. Usa los botones de acciones para editar o
    eliminar un domicilio existente, o agrega uno nuevo usando el botón "Agregar Domicilio".
  </p>
  <div class="table-responsive">
    <table id="table_domicilio" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th><i class="fas fa-road"></i> Calle</th>
          <th><i class="fas fa-map-pin"></i> Colonia</th>
          <th><i class="fas fa-building"></i> No. Exterior</th>
          <th><i class="fas fa-door-open"></i> No. Interior</th>
          <th><i class="fas fa-city"></i> Ciudad</th>
          <th><i class="fas fa-map-marker-alt"></i> Estado</th>
          <th><i class="fas fa-globe"></i> País</th>
          <th><i class="fas fa-mail-bulk"></i> Código Postal</th>
          <th><i class="fas fa-cogs"></i> Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($domicilios)): ?>
          <?php foreach ($domicilios as $domicilio): ?>
            <tr>
              <td><?= esc($domicilio['calle']) ?></td>
              <td><?= esc($domicilio['colonia']) ?></td>
              <td><?= esc($domicilio['no_exterior']) ?></td>
              <td><?= esc($domicilio['no_interior']) ?></td>
              <td><?= esc($domicilio['ciudad']) ?></td>
              <td><?= esc($domicilio['estado']) ?></td>
              <td><?= esc($domicilio['pais']) ?></td>
              <td><?= esc($domicilio['codigo_postal']) ?></td>
              <td>
                <button type="button" class="btn btn-primary btn-editar-domicilio" data-toggle="modal"
                  data-target="#domicilioModal" data-id="<?= $domicilio['id'] ?>"
                  data-calle="<?= esc($domicilio['calle']) ?>" data-no_exterior="<?= esc($domicilio['no_exterior']) ?>"
                  data-no_interior="<?= esc($domicilio['no_interior']) ?>" data-colonia="<?= esc($domicilio['colonia']) ?>"
                  data-ciudad="<?= esc($domicilio['ciudad']) ?>" data-estado="<?= esc($domicilio['estado']) ?>"
                  data-pais="<?= esc($domicilio['pais']) ?>" data-codigo_postal="<?= esc($domicilio['codigo_postal']) ?>"
                  title="Editar Domicilio">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-eliminar-domicilio" data-id="<?= $domicilio['id'] ?>"
                  title="Eliminar Domicilio">
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
<!-- Modal para agregar domicilio -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="domicilioModal" tabindex="-1" role="dialog" aria-labelledby="domicilioModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="domicilioModalLabel">
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="<?= base_url('/cv/datosgenerales/saveAddress') ?>" method="post" id="modalFormDomicilio">
        <input type="hidden" id="id_domicilio" name="id_domicilio">
        <input type="hidden" id="id_ubicacion" name="id_ubicacion">

        <div class="form-row">
    <div class="col-md-6 form-group">
        <label for="calle"><i class="fas fa-road"></i> Calle</label>
        <input type="text" class="form-control form-control-sm" id="calle" name="calle" placeholder="Ingrese la calle">
        <div class="page-warning"></div>
    </div>
    <div class="col-md-6 form-group">
        <label for="colonia"><i class="fas fa-home"></i> Colonia</label>
        <input type="text" class="form-control form-control-sm" id="colonia" name="colonia" placeholder="Ingrese la colonia">
        <div class="page-warning"></div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4 form-group">
        <label for="no_exterior"><i class="fas fa-building"></i> No. Exterior</label>
        <input type="text" class="form-control form-control-sm" id="no_exterior" name="no_exterior" placeholder="Número exterior">
        <div class="page-warning"></div>
    </div>
    <div class="col-md-4 form-group">
        <label for="no_interior"><i class="fas fa-door-open"></i> No. Interior</label>
        <input type="text" class="form-control form-control-sm" id="no_interior" name="no_interior" placeholder="Número interior">
        <div class="page-warning"></div>
    </div>
    <div class="col-md-4 form-group">
        <label for="codigo_postal"><i class="fas fa-cogs"></i> Código Postal</label>
        <input type="text" class="form-control form-control-sm" id="codigo_postal" name="codigo_postal" placeholder="Código Postal">
        <div class="page-warning"></div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-4 form-group">
        <label for="ciudad"><i class="fas fa-city"></i> Ciudad</label>
        <input type="text" class="form-control form-control-sm" id="ciudad" name="ciudad" placeholder="Ingrese la ciudad">
        <div class="page-warning"></div>
    </div>
    <div class="col-md-4 form-group">
        <label for="estado"><i class="fas fa-map-marker-alt"></i> Estado</label>
        <input type="text" class="form-control form-control-sm" id="estado" name="estado" placeholder="Ingrese el estado">
        <div class="page-warning"></div>
    </div>
    <div class="col-md-4 form-group">
        <label for="pais"><i class="fas fa-globe"></i> País</label>
        <input type="text" class="form-control form-control-sm" id="pais" name="pais" placeholder="Ingrese el país">
        <div class="page-warning"></div>
    </div>
</div>


        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save"></i> Guardar
            </button>
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
<script src="<?= base_url('dist/js/custom/cv/datosGenerales/datosGenerales.js') ?>"></script>

<?php $this->endSection(); ?>