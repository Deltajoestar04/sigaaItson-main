function actualizarNombreInstructor() {
    var campoNombre = document.getElementById('nombre_instructor_asistente');
    var nombreUsuario = document.getElementById('nombre_usuario_actual').value;
    var rolInstructor = document.getElementById('rol_instructor');

    if (rolInstructor.checked) {
        campoNombre.value = nombreUsuario;
        campoNombre.readOnly = true;
    } else {
        if (campoNombre.value === '' || campoNombre.value === nombreUsuario) {
            campoNombre.value = '';
        }
        campoNombre.readOnly = false;
    }
}

// Evidencia
const actualBtn = document.getElementById('evidencia');
const fileChosen = document.getElementById('file-chosen');

actualBtn.addEventListener('change', function () {
    if (this.files[0]) {
        fileChosen.textContent = this.files[0].name;
    } else {
        fileChosen.textContent = 'No se ha seleccionado ningún archivo';
    }
});
document.querySelector('form').addEventListener('submit', function (e) {
    const fechaInicial = new Date(document.getElementById('fecha_inicial').value);
    const fechaFinal = new Date(document.getElementById('fecha_final').value);
    const alertContainer = document.getElementById('alert-container');
    alertContainer.style.display = 'none';
    alertContainer.innerHTML = '';

    if (fechaInicial > fechaFinal) {
        e.preventDefault();
        alertContainer.innerHTML = '<p>La fecha inicial no puede ser posterior a la fecha final.</p>';
        alertContainer.style.display = 'block';
    }
});

document.getElementById('evidencia').addEventListener('change', function () {
    const file = this.files[0];
    const fileSize = file.size / 1024 / 1024;
    const alertContainer = document.getElementById('alert-container');
    alertContainer.style.display = 'none';
    alertContainer.innerHTML = '';

    if (fileSize > 5) {
        alertContainer.innerHTML = '<p>El archivo es demasiado grande. El tamaño máximo permitido es 5 MB.</p>';
        alertContainer.style.display = 'block';
        this.value = '';
        document.getElementById('file-chosen').textContent = 'No se ha seleccionado ningún archivo';
    }
});
actualizarNombreInstructor();