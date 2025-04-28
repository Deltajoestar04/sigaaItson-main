<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/capacitacion/mostrar.css') ?>">

<div class="container-fluid main-container">
    <div class="row g-4">
        <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
        <?php endif; ?>

        <div class="col-md-7">
            <div class="card custom-card h-100 d-flex flex-column">
                <div class="card-header">
                    <h5 class="mb-0 header-title">Detalles de Capacitación</h5>
                </div>
                <div class="card-body flex-grow-1">
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="fas fa-book"></i> Título: <span
                                    class="text-muted"><?= $capacitacion["titulo"] ?></span></p>
                            <p><i class="fas fa-layer-group"></i> Tipo de Capacitación: <span
                                    class="text-muted"><?= $capacitacion["tipo"] ?></span></p>
                            <p><i class="fas fa-chalkboard-teacher"></i> Modalidad: <span
                                    class="text-muted"><?= $capacitacion["modalidad"] ?></span></p>
                            <p><i class="fas fa-building"></i> Organización: <span
                                    class="text-muted"><?= $capacitacion["institucion"] ?></span></p>
                            <p><i class="fas fa-map-marker-alt"></i> Lugar: <span
                                    class="text-muted"><?= $capacitacion["lugar"] ?></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-user-tag"></i> Rol: <span
                                    class="text-muted"><?= $capacitacion["rol"] ?></span></p>
                            <p><i class="fas fa-user-tie"></i> Nombre del Instructor: <span
                                    class="text-muted"><?= $capacitacion["nombre_instructor"] ?></span></p>
                            <p><i class="fas fa-clock"></i> Duración de la Capacitación: <span
                                    class="text-muted"><?= $capacitacion["duracion_horas"] ?> horas</span></p>
                            <p><i class="fas fa-calendar-alt"></i> Fecha de Inicio: <span
                                    class="text-muted"><?= (new DateTime($capacitacion["fecha_inicial"]))->format('d-m-Y') ?></span>
                            </p>
                            <p><i class="fas fa-calendar-check"></i> Fecha Final: <span
                                    class="text-muted"><?= (new DateTime($capacitacion["fecha_final"]))->format('d-m-Y') ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                
                 <div class="card-footer ">
                    <div class="d-flex justify-content-start ">
                        <p class="mb-0">
                            Estado: <span class="text-muted"><?= $capacitacion["estado"] ?></span>
                        </p>
                    </div>
            
                    <?php if ($capacitacion["estado"] === "Rechazado"): ?>
                    <div>
                        <p class="mb-0">
                           Motivo: <span class="text-muted"><?= $capacitacion["motivo"] ?></span>
                       </p>
                    </div>
                    <?php endif; ?>
                </div>


            </div>
        </div>


        <!-- Tarjeta de Evidencia -->
        <div class="col-md-5">
            <div class="card custom-card">
                <div class="card-header">
                    <h5 class="mb-0 header-title">Evidencia</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEvidencia">
                            Ver evidencia
                        </button>
                        <?php if ($_SESSION["rol"] == "admin") { ?>
                            <?php if ($capacitacion["estado"] == "Enviado") { ?>
                                <a href="/capacitaciones/estado/<?= $capacitacion["id"] ?>/Aceptado" class="btn btn-success"
                                    type="submit">Aprobar <i class="fa-solid fa-check"></i></a>
                                <?php if (isset($correo_maestro)): ?>
                                    <a href="#"
                                        onclick="rechazarSolicitud(<?= $capacitacion['id'] ?>, '<?= htmlspecialchars($correo_maestro, ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($nombre_maestro, ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($apellido_paterno, ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($apellido_materno, ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($capacitacion['titulo'], ENT_QUOTES, 'UTF-8') ?>')"
                                        class="btn btn-danger">Rechazar <i class="fa-solid fa-x"></i></a>
                                <?php endif; ?>
                            <?php } ?>
                            <a href="#" data-id="<?= $capacitacion['id'] ?>"
                                data-correo="<?= htmlspecialchars($correo_maestro, ENT_QUOTES, 'UTF-8') ?>"
                                data-nombre="<?= htmlspecialchars($nombre_maestro, ENT_QUOTES, 'UTF-8') ?>"
                                data-apellido-paterno="<?= htmlspecialchars($apellido_paterno, ENT_QUOTES, 'UTF-8') ?>"
                                data-apellido-materno="<?= htmlspecialchars($apellido_materno, ENT_QUOTES, 'UTF-8') ?>"
                                data-titulo="<?= htmlspecialchars($capacitacion['titulo'], ENT_QUOTES, 'UTF-8') ?>"
                                onclick="enviarAviso(this)" class="btn btn-info">Enviar Aviso <i
                                    class="fa-solid fa-envelope"></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- Modal de Evidencia -->
<div class="modal fade" id="modalEvidencia" tabindex="-1" aria-labelledby="modalEvidenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEvidenciaLabel">Evidencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <?php
                $file_path = base_url('evidencias/' . $capacitacion["evidencia"]);
                $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                ?>
                <div class="viewer">
                    <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png'])): ?>
                        <img class="viewer-img img-fluid" src="<?= $file_path ?>" alt="Evidencia">
                    <?php elseif ($file_extension == 'pdf'): ?>
                        <iframe src="<?= $file_path ?>" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                    <?php else: ?>
                        <p>Formato de archivo no soportado para vista previa.</p>
                    <?php endif; ?>
                </div>
                <h4 class="modal-title mt-3" id="modalEvidenciaLabel">Ver Archivo Completo</h4>
                <a href="<?= $file_path ?>" target="_blank" class="btn btn-link">Abrir en una
                    nueva pestaña</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="container" style="position: relative; min-height: 40px;">
    <div class="row mt-3">
        <div class="col-lg-12" style="position: absolute; bottom: 0; width: 100%;">
            <a class="btn btn-primary" href="<?= base_url(); ?>/capacitaciones/<?= esc($usuario["slug"]) ?>">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>

        </div>
    </div>
</div>



<script>
    function mostrarModalAccion(tipo, capacitacionId, datos) {
        const esRechazo = tipo === 'rechazo';
        const titulo = esRechazo ? 'Motivo de rechazo' : 'Enviar Aviso';
        const placeholder = esRechazo ? 'Escribe el motivo de rechazo' : 'Escribe el mensaje del aviso';
        const textoBoton = 'Enviar';

        Swal.fire({
            title: `${titulo} - ${datos.tituloCapacitacion}`,
            html: `
<textarea id="mensaje" class="swal-textarea" placeholder="${placeholder}" style="font-size:16px; width: 100%; height: 200px; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;"></textarea>
<div id="char-counter" class="char-counter" style="text-align: right; font-size: 14px; color: #6c757d;">0/250</div>
`,
            showCancelButton: true,
            confirmButtonText: textoBoton,
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn-confirm',
                cancelButton: 'btn-cancel',
            },
            didOpen: () => {
                const mensajeTextarea = document.getElementById('mensaje');
                const charCounter = document.getElementById('char-counter');
                mensajeTextarea.addEventListener('input', () => {
                    const currentLength = mensajeTextarea.value.length;
                    charCounter.textContent = `${currentLength}/250`;
                });
            },
            preConfirm: () => {
                const mensajeTextarea = document.getElementById('mensaje');
                return mensajeTextarea.value;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                let mensaje = result.value;
                let url = construirURL(tipo, capacitacionId, mensaje, datos);
                console.log(url);
                window.location.href = url;
            }
        });
    }

    function construirURL(tipo, capacitacionId, mensaje, datos) {
        const baseURL = tipo === 'rechazo'
            ? `/capacitaciones/motivo_correo/${capacitacionId}/Rechazado`
            : `/capacitaciones/aviso_correo/${capacitacionId}`;

        const params = new URLSearchParams({
            motivo: mensaje,
            correo: datos.correoMaestro,
            nombre: datos.nombreMaestro,
            apellido_paterno: datos.apellidoPaterno,
            apellido_materno: datos.apellidoMaterno,
            titulo_capacitacion: datos.tituloCapacitacion
        });

        return `${baseURL}?${params.toString()}`;
    }

    // Función para rechazar solicitud
    function rechazarSolicitud(capacitacionId, correoMaestro, nombreMaestro, apellidoPaterno, apellidoMaterno, tituloCapacitacion) {
        mostrarModalAccion('rechazo', capacitacionId, {
            correoMaestro,
            nombreMaestro,
            apellidoPaterno,
            apellidoMaterno,
            tituloCapacitacion
        });
    }

    // Función para enviar aviso
    function enviarAviso(element) {
        const capacitacionId = element.getAttribute('data-id');
        const datos = {
            correoMaestro: element.getAttribute('data-correo') ? decodeURIComponent(element.getAttribute('data-correo')) : '',
            nombreMaestro: element.getAttribute('data-nombre') ? decodeURIComponent(element.getAttribute('data-nombre')) : '',
            apellidoPaterno: element.getAttribute('data-apellido-paterno') ? decodeURIComponent(element.getAttribute('data-apellido-paterno')) : '',
            apellidoMaterno: element.getAttribute('data-apellido-materno') ? decodeURIComponent(element.getAttribute('data-apellido-materno')) : '',
            tituloCapacitacion: element.getAttribute('data-titulo') ? decodeURIComponent(element.getAttribute('data-titulo')) : ''
        };
        mostrarModalAccion('aviso', capacitacionId, datos);
    }

</script>


<?php $this->endSection(); ?>