$(document).ready(function () {
    // Inicializa DataTable
    CommonFunctions.initializeDataTable("#table_asociacion_profesional");

    // Inicializa manejadores comunes
    CommonFunctions.initializeCommonHandlers();

    // Inicializa modal para agregar/editar asociacion profesional
    CommonFunctions.initializeModal(
        '#asociacionProfesionalModal',
        '#modalFormAsociacionProfesional',
        baseUrl + '/Cv/asociacionProfesional/save'
    );

    // Lógica del modal de asociacion profesional
    $("#asociacionProfesionalModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var modal = $(this);

        if (id) {
            modal.find(".modal-title").text("Editar Asociación Profesional");
            modal.find("#id_asociacion_profesional").val(id);
            modal.find("#nombre").val(button.data("nombre"));
            modal.find("#tipo").val(button.data("tipo"));
            modal.find("#fecha_inicio").val(button.data("fecha_inicio"));
            modal.find("#fecha_final").val(button.data("fecha_final"));
        } else {
            modal.find(".modal-title").text("Agregar Asociación Profesional");
            modal.find("form")[0].reset();
            modal.find("#id_asociacion_profesional").val("");
        }
    });

    // Lógica para eliminar asociacion profesional
    $(".btn-eliminar-asociacion-profesional").click(function () {
        var id = $(this).data("id");
        CommonFunctions.confirmarEliminacion(
            baseUrl + "/Cv/asociacionProfesional/delete/" + id,
            "¿Estás seguro?",
            "¡No podrás revertir esto!",
            "Asociación Profesional eliminada"
        );
    });
});