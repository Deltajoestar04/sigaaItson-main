
const CommonFunctions = {
    // Configuración de DataTables
    dataTablesConfig: {
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
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
        }
    },

    initializeDataTable: function(tableId) {
        return $(tableId).DataTable(this.dataTablesConfig);
    },

    clearWarnings: function() {
        $('.page-warning').empty();
    },

    showWarnings: function(errors) {
        this.clearWarnings();
        $.each(errors, function (field, message) {
            $('#' + field).siblings('.page-warning').text(message);
        });
    },

    initializeCommonHandlers: function() {
        $('.modal').on('show.bs.modal', this.clearWarnings);
    },

    initializeModal: function(modalId, formId, saveUrl, reloadOnSuccess = true) {
        $(modalId).on('show.bs.modal', this.clearWarnings);

        $(formId).submit(function (event) {
            event.preventDefault();
            CommonFunctions.submitForm($(this), saveUrl, modalId, reloadOnSuccess);
        });
    },

    submitForm: function($form, url, modalId, reloadOnSuccess) {
        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $(modalId).modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    }).then((result) => {
                        if (result.isConfirmed && reloadOnSuccess) {
                            location.reload();
                        }
                    });
                } else {
                    response.errors ? CommonFunctions.showWarnings(response.errors) :
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.'
                });
            }
        });
    },

    confirmarEliminacion: function(url, titulo, textoConfirmacion, textoExito) {
        Swal.fire({
            title: titulo,
            text: textoConfirmacion,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        response.success ? Swal.fire({
                            title: textoExito,
                            text: response.message,
                            icon: 'success'
                        }).then(() => location.reload()) : 
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        });
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al intentar eliminar el elemento',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    },

    fillModalFields: function(modal, button, fields) {
        fields.forEach(field => {
            modal.find('#' + field).val(button.data(field));
        });
    },

    resetModal: function(modal, title, idField) {
        modal.find('.modal-title').text(title);
        modal.find('form')[0].reset();
        modal.find('#' + idField).val('');
    },

    toggleFechaFin: function() {
        var currentlyChecked = $('#actualmente').is(':checked');
        $('#fechaFinContainer').toggle(!currentlyChecked);
    }
};