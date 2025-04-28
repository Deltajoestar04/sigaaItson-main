<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/usuario/general.css') ?>">


<div class="usuario-container">
    <div class="usuario-header">
        <h2 class="header-title"> Listado de maestros</h2>
        <a class="btn btn-primary btn-add" href="<?= base_url(); ?>/usuarios/agregar">
            <i class="fas fa-plus-circle"></i> Agregar Maestro
        </a>
    </div>

    <?php if (session('msg') !== null): ?>
        <div class="alert alert-success">
            <?= session('msg'); ?>
        </div>
    <?php endif; ?>

    <p class="section-description">
        <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
        En esta sección, puedes revisar y gestionar los maestros registrados. Puedes agregar, editar o eliminar
        maestros. Tambien puedes ver las capacitaciones de cada uno.
    </p>

    <div class="row mb-3">
    <div class="col-lg-12">
        <form method="post" action="<?= base_url('usuario/filtrerUsers') ?>" class="form-inline filter">
            <label for="estado_capacitacion" class="mr-2">Estado de Capacitación:</label>
            <select name="estado_capacitacion" id="estado_capacitacion" class="form-control mr-2">
                <?php if (!empty($estadosCapacitacion)): ?>
                    <?php foreach ($estadosCapacitacion as $estado): ?>
                        <option value="<?= $estado ?>" <?= ($estado == $estadoCapacitacionSeleccionado) ? 'selected' : '' ?>>
                            <?= $estado ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <button type="submit" class="btn btn-primary btn-filter">Filtrar</button>
        </form>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-bordered" id="table_cap">
        <thead>
            <tr>
                <th><i class="fas fa-info-circle"></i> Estado</th>
                <th><i class="fas fa-user"></i> Nombre</th>
                <th><i class="fas fa-envelope"></i> Correo</th>
                <th><i class="fas fa-phone"></i> Teléfono</th>
                <th><i class="fas fa-school"></i> Campus</th>
                <th><i class="fas fa-id-badge"></i> ID</th>
                <th><i class="fas fa-cogs"></i> Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $key => $usuario): ?>
                <tr>
                    <td class="icon-center"
                        data-order="<?= isset($usuario['ordenEstado']) ? $usuario['ordenEstado'] : 0 ?>">
                        <?php if (isset($usuario['iconoEstado'])): ?>
                            <i class="<?= $usuario['iconoEstado']; ?> icon-size"></i>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($usuario["nombre"] . " " . $usuario["apellido_paterno"] . " " . $usuario["apellido_materno"]) ?>
                    </td>
                    <td><?= esc($usuario["correo"]) ?></td>
                    <td><?= esc($usuario["telefono"]) ?></td>

                    <td>
                        <?php
                        $nombreCampus = '';
                        foreach ($campus as $camp) {
                            if ($camp['id'] == $usuario['id_campus']) {
                                $nombreCampus = $camp['nombre'];
                                break;
                            }
                        }
                        echo esc($nombreCampus);
                        ?>
                    </td>
                    <td><?= esc($usuario["matricula"]) ?></td>
                    <td>
                        <a class="btn btn-primary" href="<?= base_url(); ?>/usuarios/editar/<?= $usuario["slug"] ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-primary" href="<?= base_url(); ?>/capacitaciones/<?= $usuario["slug"] ?>">
                            <i class="fas fa-book"></i> Capacitaciones
                        </a>
                        <a class="btn btn-danger" data-id="<?= $usuario["id"] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>







<script>

    // Función para eliminar un usuario
    function eliminarUsuario(id) {
        Swal.fire({
            title: '<div style="text-align: center;">¿Estás seguro de que desea eliminar este usuario (maestro)?</div>',
            html: "<div style='text-align: left;'>" +
                "<p>Esta acción eliminará permanentemente:</p>" +
                "<ul>" +
                "<li>La cuenta del usuario</li>" +
                "<li>Todas las capacitaciones asociadas al usuario</li>" +
                "</ul>" +
                "<p><strong>Advertencia:</strong> Una vez eliminado, los datos no podrán ser recuperados.</p>" +
                "</div>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url(); ?>/usuario/delete/" + id;
            }
        });
    }

    // Asignar la función de eliminar al botón
    $(".btn-eliminar").click(function () {
        var id = $(this).data("id");
        eliminarUsuario(id);
    })



    $(document).ready(function () {
        $('#table_cap').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total registros)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            columnDefs: [
                {
                    targets: 0,
                    orderData: [0]
                }
            ]
        });
    });

</script>




<?php $this->endSection(); ?>