$(document).ready(function () {
    // Inicializa DataTable
    CommonFunctions.initializeDataTable("#table_premio");

    // Inicializa manejadores comunes
    CommonFunctions.initializeCommonHandlers();

    // Inicializa modal para agregar/editar premio
    CommonFunctions.initializeModal(
        '#premioModal',
        '#modalFormPremio',
        baseUrl + '/Cv/premio/save'
    );

    // Lógica del modal de premio
    $("#premioModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var modal = $(this);

        if (id) {
            modal.find(".modal-title").text("Editar Premio");
            modal.find("#id_premio").val(id);
        modal.find("#anio").val(button.data("anio"));
            modal.find("#descripcion").val(button.data("descripcion"));
            modal.find("#organismo").val(button.data("organismo"));
            modal.find("#pais").val(button.data("pais"));
        } else {
            modal.find(".modal-title").text("Agregar Premio");
            modal.find("form")[0].reset();
            modal.find("#id_premio").val("");
        }
    });

    // Lógica para eliminar premio
    $(".btn-eliminar-premio").click(function () {
        var id = $(this).data("id");
        CommonFunctions.confirmarEliminacion(
            baseUrl + "/Cv/premio/delete/" + id,
            "¿Estás seguro?",
            "¡No podrás revertir esto!",
            "Premio eliminado"
        );
    });



});