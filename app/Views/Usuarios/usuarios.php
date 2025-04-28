<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>


<div class="row">
  <div>
    <h1 class="page-header">Listado De Usuarios</h1>
  </div>
</div>
<div class="row">
  <div class="col">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-user fa-5x"></i>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="panel-footer">
              <span class="pull-left">Juan Perez</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Usuarios
          </div>
          <!-- /.panel-heading -->
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Lugar</th>
                    <th>Fecha</th>
                    <th>Organización</th>
                    <th>Modalidad</th>
                    <th>Horas</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($capacitaciones as $key => $capacitacion) { ?>
                    <tr>
                      <td>
                        <?= $capacitacion["nombre"] ?>
                      </td>
                      <td>
                        <?= $capacitacion["tipo"] ?>
                      </td>
                      <td>
                        <?= $capacitacion["lugar"] ?>
                      </td>
                      <td>
                        <?= $capacitacion["fecha_cursada"] ?>
                      </td>
                      <td>
                        <?= $capacitacion["institucion"] ?>
                      </td>
                      <td>
                        <?= $capacitacion["modalidad"] ?>
                      </td>
                      <td>
                        <?= $capacitacion["duracion_horas"] ?>
                      </td>
                      <td> <button class="btn btn-primary">Editar</button></td>
                      <td><button class="btn btn-danger btn-eliminar" data-id="<?= $capacitacion["id"] ?>">Eliminar</button></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
      </div>
      <!-- /.col-lg-6 -->
    </div>
    <div class="row">
      <div class="col-lg-12">
        <a class="btn btn-success" href="<?php base_url(); ?>/form">Agregar</a>

      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<?php $this->endSection(); ?>


<?php $this->section("js"); ?>
<script>
  $(document).ready(function() {
    function eliminar(id) {

      Swal.fire({
        title: '¿Estás seguro?',
        text: "Se borrará completamente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borralo!'
      }).then((result) => {
        if (result.isConfirmed) {
          location.href = "<?= base_url(); ?>/capacitaciones/eliminar/" + id
        }
      })

    }
    $(".btn-eliminar").click(function() {

      var id = $(this).data("id");
      eliminar(id);


    });



  });
</script>



<?php $this->endSection(); ?>