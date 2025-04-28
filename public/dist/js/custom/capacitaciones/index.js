//SwetAlert2 para eliminar
$(document).ready(function () {
  function eliminar(id) {
    Swal.fire({
      title:
        '<div style="text-align: center;">¿Desea proceder con la eliminación de esta capacitación?</div>',
      html:
        "<div style='text-align: left;'>" +
        "<p>Esta acción eliminará permanentemente:</p>" +
        "<ul>" +
        "<li>La información de la capacitación seleccionada</li>" +
        "</ul>" +
        "<p><strong>Advertencia:</strong> Una vez eliminada, no podrá recuperarse.</p>" +
        "</div>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminarla!",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        location.href = "<?= base_url(); ?>/capacitaciones/eliminar/" + id;
      }
    });
  }

  // Evento para eliminar
  $(".btn-eliminar").click(function () {
    var id = $(this).data("id");
    eliminar(id);
  });
});

//Horas de capacitación
$(document).ready(function () {
  var horas_diciplinarias = 0;
  var horas_docentes = 0;
  var fecha = "";
  $(".fecha_inicial").each(function (index, element) {
    fecha = $(element).text();
    año = new Date().getFullYear();
  });
  $(".tipo").each(function (index, element) {
    if (
      $(element).text() == "Disciplinar" &&
      $(element).parent().find(".estado").text() == "Aceptado"
    ) {
      if ($(element).parent().find(".fecha_inicial").text().includes(año)) {
        horas_diciplinarias += parseInt(
          $(element).parent().find(".horas").text()
        );
      }
    } else if (
      $(element).text() == "Docente" &&
      $(element).parent().find(".estado").text() == "Aceptado"
    ) {
      if ($(element).parent().find(".fecha_inicial").text().includes(año)) {
        horas_docentes += parseInt($(element).parent().find(".horas").text());
      }
    }
  });

  $("#horas_docentes").text(`${horas_docentes}/20`);
  $("#horas_diciplinarias").text(`${horas_diciplinarias}/20`);
});

//Lenaguaje de datatable
$(document).ready(function () {
  var table = $("#table_cap").DataTable({
    order: [
      [4, "asc"],
      [5, "asc"],
    ],
    columnDefs: [{ type: "date-eu", targets: [4, 5] }],
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
      infoFiltered: "(Filtrado de _MAX_ total registros)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });

  $("#btnExportExcel").click(function () {
    var selectedYear = $("#yearFilter").val();
    var data = [];

    var headerText = $(".header-title").text();
    var nombreMaestro = headerText.includes("-")
      ? headerText.split("-")[1].trim()
      : "";

    var headers = [
      "Título",
      "Tipo",
      "Lugar",
      "Rol",
      "Nombre del instructor/asistente",
      "Fecha inicial",
      "Fecha final",
      "Organización",
      "Modalidad",
      "Horas",
      "Estado",
    ];
    data.push(headers);

    table.rows({ search: "applied" }).every(function () {
      var rowData = this.data();
      data.push([
        rowData[0],
        rowData[1],
        rowData[2],
        rowData[3],
        rowData[4],
        rowData[5],
        rowData[6],
        rowData[7],
        rowData[8],
        rowData[9],
        rowData[10],
      ]);
    });

    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.aoa_to_sheet(data);
    XLSX.utils.book_append_sheet(wb, ws, "Capacitaciones");

    var fileName =
      "Capacitaciones" +
      (nombreMaestro ? "_" + nombreMaestro.replace(/\s+/g, "_") : "") +
      (selectedYear ? "_" + selectedYear : "") +
      ".xlsx";
    XLSX.writeFile(wb, fileName);
  });

  function updateHours(selectedYear) {
    var horas_diciplinarias = 0;
    var horas_docentes = 0;

    $(".fecha_inicial").each(function (index, element) {
      var rowYear = $(element).text().split("-")[2];
      var $row = $(element).closest("tr");

      if (selectedYear === "" || rowYear === selectedYear) {
        if (
          $row.find(".tipo").text() == "Disciplinar" &&
          $row.find(".estado").text() == "Aceptado"
        ) {
          horas_diciplinarias += parseInt($row.find(".horas").text());
        } else if (
          $row.find(".tipo").text() == "Docente" &&
          $row.find(".estado").text() == "Aceptado"
        ) {
          horas_docentes += parseInt($row.find(".horas").text());
        }
      }
    });

    $("#horas_docentes").text(`${horas_docentes}/20`);
    $("#horas_diciplinarias").text(`${horas_diciplinarias}/20`);
  }

  $("#yearFilter").on("change", function () {
    var selectedYear = $(this).val();

    if (selectedYear === "") {
      table.column(5).search("").draw();
    } else {
      table.column(5).search(selectedYear).draw();
    }

    updateHours(selectedYear);
  });

  updateHours("");
});
