$(document).ready(function () {
    // Inicializa DataTable
    CommonFunctions.initializeDataTable("#table_logro");

    // Inicializa manejadores comunes
    CommonFunctions.initializeCommonHandlers();

    // Inicializa modal para agregar/editar logro
    CommonFunctions.initializeModal(
        '#logroModal',
        '#modalFormLogro',
        baseUrl + '/Cv/logro/save'
    );

    // Lógica del modal de logro
    $("#logroModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var modal = $(this);

        if (id) {
            modal.find(".modal-title").text("Editar Logro");
            modal.find("#id_logro").val(id);
            modal.find("#descripcion").val(button.data("descripcion"));
            modal.find("#tipo").val(button.data("tipo"));
        } else {
            modal.find(".modal-title").text("Agregar Logro");
            modal.find("form")[0].reset();
            modal.find("#id_logro").val("");
        }
    });

    // Lógica para eliminar logro
    $(".btn-eliminar-logro").click(function () {
        var id = $(this).data("id");
        CommonFunctions.confirmarEliminacion(
            baseUrl + "/Cv/logro/delete/" + id,
            "¿Estás seguro?",
            "¡No podrás revertir esto!",
            "Logro eliminado"
        );
    });

});