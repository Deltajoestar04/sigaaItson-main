$(document).ready(function () {
    // Inicializa DataTable
    CommonFunctions.initializeDataTable("#table_experiencia_laboral");

    // Inicializa manejadores comunes
    CommonFunctions.initializeCommonHandlers();

    // Inicializa modal para agregar/editar experiencia laboral
    CommonFunctions.initializeModal(
        '#experienciaLaboralModal',
        '#modalFormExperienciaLaboral',
        baseUrl + '/Cv/experiencialaboral/save'
    );

    // Lógica del modal de experiencia laboral
    $("#experienciaLaboralModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var modal = $(this);

        if (id) {
            modal.find(".modal-title").text("Editar Experiencia Laboral");
            modal.find("#id_experiencia_laboral").val(id);
            modal.find("#actividad_puesto").val(button.data("actividad_puesto"));
            modal.find("#empresa").val(button.data("empresa"));
            modal.find("#mes_inicio").val(button.data("mes_inicio"));
            modal.find("#anio_inicio").val(button.data("anio_inicio"));
            modal.find("#mes_fin").val(button.data("mes_fin"));
            modal.find("#anio_fin").val(button.data("anio_fin"));
            modal.find("#actualmente").prop("checked", button.data("actualmente") == "1");
            toggleFechaFin();
        } else {
            modal.find(".modal-title").text("Agregar Experiencia Laboral");
            modal.find("form")[0].reset();
            modal.find("#id_experiencia_laboral").val("");
        }
    });

    // Lógica para eliminar experiencia laboral
    $(".btn-eliminar-experiencia-laboral").click(function () {
        var id = $(this).data("id");
        CommonFunctions.confirmarEliminacion(
            baseUrl + "/Cv/experiencialaboral/delete/" + id,
            "¿Estás seguro?",
            "¡No podrás revertir esto!",
            "Experiencia laboral eliminada"
        );
    });

    // Event listeners
    $("#actualmente").change(toggleFechaFin);

    // Función para mostrar/ocultar fecha de fin
    function toggleFechaFin() {
        var currentlyChecked = $("#actualmente").is(":checked");
        $("#fechaFinContainer").toggle(!currentlyChecked);
    }

    // Inicialización inicial
    toggleFechaFin();
});
