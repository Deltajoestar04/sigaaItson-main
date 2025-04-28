
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
   $(".btn-eliminar").click(function() {
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
