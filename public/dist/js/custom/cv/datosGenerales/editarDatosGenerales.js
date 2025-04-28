function previewImage(event) {
    var file = event.target.files[0];
    var maxSize = 5 * 1024 * 1024;
    var maxWidth = 1920; 
    var maxHeight = 1080; 

   
    if (file.size > maxSize) {
        alert('El tamaño del archivo es demasiado grande. Por favor selecciona un archivo más pequeño.');
        event.target.value = ''; 
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var image = new Image();
        image.onload = function() {
            if (this.width > maxWidth || this.height > maxHeight) {
                alert('La resolución de la imagen es demasiado alta. Por favor selecciona una imagen con resolución menor.');
                event.target.value = ''; 
                return;
            }

       
            var output = document.getElementById('preview-image');
            output.src = e.target.result;

           
            var label = event.target.nextElementSibling;
            label.textContent = file.name;
        };
        image.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

document.addEventListener('DOMContentLoaded', function() {
    var input = document.querySelector('input[type="file"]');
    input.addEventListener('change', previewImage);
});



 function calcularEdad(fechaNacimiento) {
        const hoy = new Date();
        const nacimiento = new Date(fechaNacimiento);
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mes = hoy.getMonth() - nacimiento.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }
        return edad;
    }

    document.getElementById('fecha_nacimiento').addEventListener('change', function() {
        const fechaNacimiento = this.value;
        if (fechaNacimiento) {
            const edad = calcularEdad(fechaNacimiento);
            document.getElementById('edad').value = edad;
        } else {
            document.getElementById('edad').value = '';
        }
    });