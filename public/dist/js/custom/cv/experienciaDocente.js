$(document).ready(function () {
  // Inicializa DataTable para cada tabla especificada
  const tables = [
    "#table_experiencia_docente",
    "#table_clases_impartidas",
    "#table_proyecto",
    "#table_docencia",
    "#table_investigacion_0",
    "#table_investigacion_1",
    "#table_investigacion_2",
    "#table_vinculacion",
    "#table_evento_academico"
    
  ];
  
  tables.forEach(function(table) {
    CommonFunctions.initializeDataTable(table);
  });

  // Inicializa manejadores comunes
  CommonFunctions.initializeCommonHandlers();

  // Función para inicializar modales
  function initializeModal(modalId, formId, saveUrl) {
    CommonFunctions.initializeModal(modalId, formId, saveUrl);
  }

  // Inicializar modales
  initializeModal("#experienciaDocenteModal", "#modalFormExperienciaDocente", baseUrl + "/Cv/experienciadocente/save");
  initializeModal("#proyectoModal", "#modalFormProyecto", baseUrl + "/Cv/experienciadocente/saveProject");
  initializeModal("#claseImpartidaModal", "#modalFormClaseImpartida", baseUrl + "/Cv/experienciadocente/saveClass");
  initializeModal("#docenciaModal", "#modalFormDocencia", baseUrl + "/Cv/experienciadocente/saveDocencia");
  initializeModal("#investigacionModal", "#modalFormInvestigacion", baseUrl + "/Cv/experienciadocente/saveInvestigacion");
  initializeModal("#vinculacionModal", "#modalFormVinculacion", baseUrl + "/Cv/experienciadocente/saveVinculacion");
  initializeModal("#eventoAcademicoModal", "#modalFormEventoAcademico", baseUrl + "/Cv/experienciadocente/saveEventoAcademico");

  // Función para agregar un nuevo campo de autor
  function addAutorField(value = '') {
    var autorHtml = `
        <div class="input-group mb-2 autor-field">
            <input type="text" class="form-control autor-input" name="autores[]"value="${value}" placeholder="Nombre del autor" required>
            <div class="input-group-append">
                <button title="Agregar autor" class="btn btn-outline-secondary add-autor" type="button">+</button>
                <button title="Eliminar autor" class="btn btn-outline-secondary remove-autor" type="button">-</button>
            </div>
        </div>`;
    $('#autores-container').append(autorHtml);
}

// Función para eliminar un campo
$(document).on('click', '.remove-autor', function() {
    $(this).closest('.autor-field').remove();
});

// Función para agregar un campo
$(document).on('click', '.add-autor', function() {
    addAutorField();
});

// Limpiar el contenedor de autores al cerrar el modal
$('#autorModal').on('hidden.bs.modal', function () {
    $('#autores-container').empty();
    addAutorField(); // Opcional: vuelve a añadir un campo por defecto si quieres
});

  // Lógica del modal de experiencia docente
  $("#experienciaDocenteModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);

    if (id) {
      modal.find(".modal-title").text("Editar Experiencia Docente");
      modal.find("#id_experiencia_docente").val(id);
      modal.find("#puesto_area").val(button.data("puesto_area"));
      modal.find("#institucion").val(button.data("institucion"));
      modal.find("#mes_inicio").val(button.data("mes_inicio"));
      modal.find("#anio_inicio").val(button.data("anio_inicio"));
      modal.find("#mes_fin").val(button.data("mes_fin"));
      modal.find("#anio_fin").val(button.data("anio_fin"));
      modal.find("#actualmente").prop("checked", button.data("actualmente") == "1");
      toggleFechaFin();
    } else {
      modal.find(".modal-title").text("Agregar Experiencia Docente");
      modal.find("form")[0].reset();
      modal.find("#id_experiencia_docente").val("");
    }
  });

  // Lógica del modal de proyecto
  $("#proyectoModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);

    if (id) {
      modal.find(".modal-title").text("Editar Proyecto");
      modal.find("#id_proyecto").val(id);
      modal.find("#nombre").val(button.data("nombre"));
      modal.find("#tipo").val(button.data("tipo"));
      modal.find("#tipo_financiamiento").val(button.data("tipo_financiamiento"));
      modal.find("#nombre_organismo_externo").val(button.data("nombre_organismo_externo"));
      modal.find("#fecha_inicio").val(button.data("fecha_inicio"));
      modal.find("#fecha_fin").val(button.data("fecha_fin"));
      toggleOrganismoExterno();
    } else {
      modal.find(".modal-title").text("Agregar Proyecto");
      modal.find("form")[0].reset();
      modal.find("#id_proyecto").val("");
    }
  });

  // Lógica del modal de clases
  $("#claseImpartidaModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);

    if (id) {
      modal.find(".modal-title").text("Editar Clase Impartida");
      modal.find("#id_clase_impartida").val(id);
      modal.find("#nombre_clase").val(button.data("nombre_clase"));
      modal.find("#programa_educativo").val(button.data("programa_educativo"));
      modal.find("#numero_horas").val(button.data("numero_horas"));
    } else {
      modal.find(".modal-title").text("Agregar Clase Impartida");
      modal.find("form")[0].reset();
      modal.find("#id_clase_impartida").val("");
    }
  });

  // Lógica del modal de docencia
  $("#docenciaModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);

    if (id) {
      modal.find(".modal-title").text("Editar Docencia");
      modal.find("#id_docencia").val(id);
      modal.find("#libro").val(button.data("libro"));
      modal.find("#manual_practica").val(button.data("manual_practica"));
      modal.find("#material_didactico").val(button.data("material_didactico"));
    } else {
      modal.find(".modal-title").text("Agregar Docencia");
      modal.find("form")[0].reset();
      modal.find("#id_docencia").val("");
    }
  });

  // Manejar la apertura del modal de investigación
  $('#investigacionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var titulo = button.data('titulo');
    var tipo = button.data('tipo');
    var anio = button.data('anio');
    var fuente = button.data('fuente');
    var url_doi = button.data('url_doi');
    var editorial = button.data('editorial');
    var indiz = button.data('indiz');
    var autores = button.data('autores');

    var modal = $(this);
    modal.find('.modal-title').text(id ? 'Editar Investigación' : 'Agregar Investigación');
    modal.find('#id_investigacion').val(id || '');
    modal.find('#titulo').val(titulo || '');
    modal.find('#tipo').val(tipo || '');
    modal.find('#anio').val(anio || '');
    modal.find('#fuente').val(fuente || '');
    modal.find('#url_doi').val(url_doi || '');
    modal.find('#editorial').val(editorial || '');
    modal.find('#indiz').val(indiz || '');

    // Limpiar los campos de autores existentes
    $('#autores-container').empty();

    // Agregar campos de autores
    if (autores && Array.isArray(autores)) {
      autores.forEach(function(autor) {
        addAutorField(autor);
      });
    } else {
      console.log('No se recibieron autores o el formato es incorrecto');
    }

    // Agregar un campo vacío al final si no hay autores
    addAutorField();
  });

  //Logica del modal de vinculacion
  $("#vinculacionModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);

    if(id){
      modal.find(".modal-title").text("Editar Vinculación");
      modal.find("#id_vinculacion").val(id);
      modal.find("#patente").val(button.data("patente"));
      modal.find("#convenio_industrial").val(button.data("convenio_industrial"));
      modal.find("#servicio_industrial").val(button.data("servicio_industrial"));



    }else{
      modal.find(".modal-title").text("Agregar Vinculación");
      modal.find("form")[0].reset();
      modal.find("#id_vinculacion").val("");
    }
  });

  //Logica del modal de evento academico
  $("#eventoAcademicoModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);

    if(id){
      modal.find(".modal-title").text("Editar Evento Académico");
      modal.find("#id_evento_academico").val(id);
      modal.find("#nombre_ponencia").val(button.data("nombre_ponencia"));
      modal.find("#nombre_evento").val(button.data("nombre_evento"));
      modal.find("#lugar").val(button.data("lugar"));
      modal.find("#fecha").val(button.data("fecha"));
      modal.find("#pais").val(button.data("pais"));
      

    }else{
      modal.find(".modal-title").text("Agregar Evento Académico");
      modal.find("form")[0].reset();
      modal.find("#id_evento_academico").val("");
    }
  });


  // Event listeners
  $("#actualmente").change(toggleFechaFin);
  $("#tipo_financiamiento").change(toggleOrganismoExterno);

  // Función para mostrar/ocultar fecha de fin
  function toggleFechaFin() {
    var currentlyChecked = $("#actualmente").is(":checked");
    $("#fechaFinContainer").toggle(!currentlyChecked);
  }

  // Función para mostrar/ocultar organismo externo
  function toggleOrganismoExterno() {
    var tipoFinanciamiento = $("#tipo_financiamiento").val();
    $("#organismo_externo_container").toggle(tipoFinanciamiento === "Externo");
  }

  // Configurar botones de eliminación
  function setupDeleteButtons(selector, deleteUrl, successMessage) {
    $(selector).click(function () {
      var id = $(this).data("id");
      CommonFunctions.confirmarEliminacion(
        deleteUrl + "/" + id,
        "¿Estás seguro?",
        "¡No podrás revertir esto!",
        successMessage
      );
    });
  }

  setupDeleteButtons(".btn-eliminar-experiencia-docente", baseUrl + "/Cv/experienciadocente/delete", "Experiencia docente eliminada");
  setupDeleteButtons(".btn-eliminar-proyecto", baseUrl + "/Cv/experienciadocente/deleteProject", "Proyecto eliminado");
  setupDeleteButtons(".btn-eliminar-clase", baseUrl + "/Cv/experienciadocente/deleteClass", "Clase impartida eliminada");
  setupDeleteButtons(".btn-eliminar-docencia", baseUrl + "/Cv/experienciadocente/deleteDocencia", "Docencia eliminada");
  setupDeleteButtons(".btn-eliminar-investigacion", baseUrl + "/Cv/experienciadocente/deleteInvestigacion", "Investigación eliminada");
  setupDeleteButtons(".btn-eliminar-vinculacion", baseUrl + "/Cv/experienciadocente/deleteVinculacion", "Vinculación eliminada");
  setupDeleteButtons(".btn-eliminar-evento-academico", baseUrl + "/Cv/experienciadocente/deleteEventoAcademico", "Evento académico eliminado");

   // Event listener para el botón "Gestionar Clases"
  $(document).on("click", ".btn-gestionar-clases", function () {
    var id = $(this).data("id");
    window.location.href = baseUrl + "/Cv/experienciadocente/manageClasses/" + id;
  });

  // Función para actualizar la tabla de capacitaciones
  function actualizarTablaCapacitaciones() {
    $.ajax({
      url: baseUrl + "/Cv/experienciadocente/getCapacitacionesSeleccionadas",
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          var html = "";
          response.data.forEach(function (capacitacion) {
            html += "<tr>";
            html += "<td>" + escapeHtml(capacitacion.titulo) + "</td>";
            html += "<td>" + escapeHtml(capacitacion.tipo) + "</td>";
            html +=
              '<td><button type="button" class="btn btn-danger btn-quitar-capacitacion" data-id="' +
              escapeHtml(capacitacion.id) +
              '">Quitar</button></td>';
            html += "</tr>";
          });
          $("#table_capacitaciones tbody").html(html);
          // Reinicializa DataTable después de actualizar el contenido
          $("#table_capacitaciones").DataTable().destroy();
          CommonFunctions.initializeDataTable("#table_capacitaciones");
        } else {
          alert("Hubo un error al cargar las capacitaciones");
        }
      },
    });
  }

  // Función auxiliar para escapar HTML
  function escapeHtml(unsafe) {
    if (typeof unsafe === "undefined" || unsafe === null) {
      return "";
    }
    return unsafe
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  // Event listener para guardar la selección de capacitaciones
  $("#guardarSeleccionCapacitaciones").click(function () {
    var capacitacionesSeleccionadas = [];
    $("#capacitacionModal input:checked").each(function () {
      capacitacionesSeleccionadas.push($(this).val());
    });

    $.ajax({
      url: baseUrl + "/Cv/experienciadocente/actualizarCapacitaciones",
      method: "POST",
      data: { capacitaciones: capacitacionesSeleccionadas },
      success: function (response) {
        if (response.success) {
          // Recargar la página después de actualizar las capacitaciones
          window.location.reload();
        } else {
          alert("Hubo un error al guardar las capacitaciones");
        }
      },
    });
  });

  // Event listener para quitar capacitación
  $(document).on("click", ".btn-quitar-capacitacion", function () {
    var id = $(this).data("id");
    $.ajax({
      url: baseUrl + "/Cv/experienciadocente/quitarCapacitacion",
      method: "POST",
      data: { id: id },
      success: function (response) {
        if (response.success) {
          window.location.reload();
        } else {
          alert("Hubo un error al quitar la capacitación");
        }
      },
    });
  });

  // Llama a actualizarTablaCapacitaciones al cargar la página
  actualizarTablaCapacitaciones();

  function updateCapacitacionesCount() {
    var count = $('#capacitacionModal input:checked').length;
    $('#capacitacionesCount').text(count + ' capacitaciones seleccionadas');
}

// Llamar a esta función al abrir el modal y cuando cambie una selección
$('#capacitacionModal').on('shown.bs.modal', updateCapacitacionesCount);
$(document).on('change', '#capacitacionModal input[type="checkbox"]', updateCapacitacionesCount);


});
