$(document).ready(function() {
    // Inicializa DataTable
    CommonFunctions.initializeDataTable('#table_grado');


    // Inicializa manejadores comunes
    CommonFunctions.initializeCommonHandlers();

    //Inicializa modal para agregar/editar grados Academicos
    CommonFunctions.initializeModal('#gradoModal','#modalFormGrado',baseUrl+'/Cv/GradosAcademicos/save')

    //Logica del modal de grado academico
// Lógica del modal de grado académico
$('#gradoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var modal = $(this);

    if (id) {
        modal.find('.modal-title').text('Editar Grado Académico');
        modal.find('#id_grado_academico').val(id);
        modal.find('#nombre_grado').val(button.data('nombre_grado'));
        modal.find('#institucion').val(button.data('institucion'));
        modal.find('#pais').val(button.data('pais'));
        modal.find('#fecha_inicio').val(button.data('fecha_inicio'));
        modal.find('#fecha_final').val(button.data('fecha_final'));
        modal.find('#fecha_titulacion').val(button.data('fecha_titulacion'));
        modal.find('#no_cedula').val(button.data('no_cedula'));
        modal.find('#tipo_cedula').val(button.data('tipo_cedula'));

        // Manejo de SNI
        var nivelSNI = button.data('nivel');
        if (nivelSNI) {
            modal.find('#sni_check').prop('checked', true);
            modal.find('#sni_nivel_container').show();
            modal.find('#sni_nivel').val(nivelSNI);
        } else {
            modal.find('#sni_check').prop('checked', false);
            modal.find('#sni_nivel_container').hide();
        }

        // Manejo de PRODEP
        var fechaComienzo = button.data('fecha_comienzo');
        var fechaTermino = button.data('fecha_termino');
        if (fechaComienzo || fechaTermino) {
            modal.find('#prodep_check').prop('checked', true);
            modal.find('#prodep_fechas').show();
            modal.find('#fecha_comienzo').val(fechaComienzo);
            modal.find('#fecha_termino').val(fechaTermino);
        } else {
            modal.find('#prodep_check').prop('checked', false);
            modal.find('#prodep_fechas').hide();
        }
    } else {
        modal.find('.modal-title').text('Agregar Grado Académico');
        modal.find('form')[0].reset();
        modal.find('#id_grado_academico').val('');
        modal.find('#sni_nivel_container').hide();
        modal.find('#prodep_fechas').hide();
    }
});

// Manejo de los checkboxes
$('#sni_check').change(function() {
    $('#sni_nivel_container').toggle(this.checked);
    if (!this.checked) {
        $('#sni_nivel').val('');
    }
});

$('#prodep_check').change(function() {
    $('#prodep_fechas').toggle(this.checked);
    if (!this.checked) {
        $('#fecha_comienzo').val('');
        $('#fecha_termino').val('');
    }
});

 // Función para eliminar un grado academico
 $('.btn-eliminar-grado-academico').click(function () {
    var id = $(this).data('id');
    CommonFunctions.confirmarEliminacion(
        baseUrl + '/Cv/gradosacademicos/delete/' + id,
        '¿Estás seguro?',
        '¡No podrás revertir esto!',
        'Grado academico eliminado'
    );
});
});