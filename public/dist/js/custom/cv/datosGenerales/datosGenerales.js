$(document).ready(function () {
  // Inicializa DataTable
  CommonFunctions.initializeDataTable("#table_domicilio");

  // Inicializa manejadores comunes
  CommonFunctions.initializeCommonHandlers();

    // Inicializa modal para agregar/editar dirección 
    CommonFunctions.initializeModal('#domicilioModal', '#modalFormDomicilio', baseUrl + '/Cv/datosGenerales/saveAddress');


     // Lógica del modal de domicilio
     $('#domicilioModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        
        if (id) {
            modal.find('.modal-title').text('Editar Domicilio');
            modal.find('#id_domicilio').val(id);
            modal.find('#calle').val(button.data('calle'));
            modal.find('#no_exterior').val(button.data('no_exterior'));
            modal.find('#no_interior').val(button.data('no_interior'));
            modal.find('#colonia').val(button.data('colonia'));
            modal.find('#codigo_postal').val(button.data('codigo_postal'));
            modal.find('#ciudad').val(button.data('ciudad'));
            modal.find('#estado').val(button.data('estado'));
            modal.find('#pais').val(button.data('pais'));
        } else {
            modal.find('.modal-title').text('Agregar Domicilio');
            modal.find('form')[0].reset();
            modal.find('#id_domicilio').val('');
        }
    });

    // Lógica para eliminar domicilio
    $('.btn-eliminar-domicilio').click(function () {
        var id = $(this).data('id');
        CommonFunctions.confirmarEliminacion(
            baseUrl + '/Cv/datosGenerales/deleteAddress/' + id,
            '¿Estás seguro?',
            '¡No podrás revertir esto!',
            'Domicilio eliminado'
        );
    });
    
});
