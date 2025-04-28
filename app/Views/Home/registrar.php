<!DOCTYPE html>
<html lang="en">
<?php session() ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ITSON - Registrarse</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url(); ?>/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= base_url(); ?>/dist/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?= base_url(); ?>/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url(); ?>/dist/css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?= base_url(); ?>/dist/css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= base_url(); ?>/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Estilos de proyecto -->
    <link href="<?php base_url() ?>/dist/css/custom/style.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/dist/css/custom/home/registrar.css" rel="stylesheet" type="text/css">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.../assets/js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>
    <div class="container-fluid">
        <header class="header navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="header__logo-container navbar-header">
                <img class="header__logo-img" src="<?php base_url(); ?>/dist/img/ITSON_negativo.png"
                    alt="Logo de universidad ITSON">
            </div>
        </header>
        <div class="register-container">
            <div class="register-panel">
                <div class="panel-heading">
                    <div class="panel-title-container">
                        <h3 class="panel-title"><i class="fas fa-user-plus"></i> Registro de Usuario</h3>
                    </div>
                </div>

                <div class="panel-body">
                <div class="panel-description">
            <p>
              <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
              Complete el formulario a continuación para crear una cuenta en nuestro sistema. Asegúrese de ingresar la información correctamente y de manera completa. Su cuenta será creada una vez que envíe este formulario. Si tiene alguna pregunta, por favor, contáctenos para obtener ayuda.


            </p>
          </div>
                    <form action="<?= base_url(); ?>/Usuario/registrar" method="POST">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-user"></i> Nombre</label>
                                    <input class="form-control" value="<?= old('nombre') ?>" name="nombre"
                                        placeholder="Su nombre">
                                    <p class='page-warning'><?= session('errors.nombre') ?></p>
                                    <?php if (session('nom') !== null): ?>
                                        <p class='page-warning'><?= session('nom') ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-user"></i> Apellido Paterno</label>
                                    <input class="form-control" value="<?= old('apellido_paterno') ?>"
                                        name="apellido_paterno" placeholder="Su apellido paterno">
                                    <p class='page-warning'><?= session('errors.apellido_paterno') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-user"></i> Apellido Materno</label>
                                    <input class="form-control" value="<?= old('apellido_materno') ?>"
                                        name="apellido_materno" placeholder="Su apellido materno">
                                    <p class='page-warning'><?= session('errors.apellido_materno') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-envelope"></i> Correo electrónico</label>
                                    <input class="form-control" value="<?= old('correo') ?>" name="correo"
                                        placeholder="Correo institucional de ITSON">
                                    <p class='page-warning'><?= session('errors.correo') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-phone"></i> Teléfono</label>
                                    <input class="form-control" value="<?= old('telefono') ?>" name="telefono"
                                        placeholder="Teléfono de contacto">
                                    <p class='page-warning'><?= session('errors.telefono') ?></p>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-lock"></i> Contraseña</label>
                                    <input type="password" class="form-control" name="contrasena"
                                        placeholder="Ingrese una contraseña segura">
                                    <p class='page-warning'><?= session('errors.contrasena') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-lock"></i> Confirme su contraseña</label>
                                    <input type="password" class="form-control" name="confirmar_contrasena"
                                        placeholder="Verifique su contraseña">
                                    <p class='page-warning'><?= session('errors.confirmar_contrasena') ?></p>
                                </div>
                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-users"></i> Rol de Usuario</label>
                                    <select class="form-control" name="rol">
                                        <option value="">Seleccione un rol...</option>
                                        <option value="Maestro" <?= old('rol') == 'Maestro' ? 'selected' : '' ?>>Maestro
                                        </option>
                                        <option value="Estudiante" <?= old('rol') == 'Estudiante' ? 'selected' : '' ?>>
                                            Estudiante</option>
                                    </select>
                                    <p class='page-warning'><?= session('errors.rol') ?></p>
                                </div>

                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-university"></i> Campus</label>
                                    <select class="form-control" name="id_campus">
                                        <option value="">Seleccione un campus...</option>
                                        <?php foreach ($campus as $campusItem): ?>
                                            <option value="<?= $campusItem['id'] ?>" <?= old('id_campus') == $campusItem['id'] ? 'selected' : '' ?>>
                                                <?= $campusItem['nombre'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class='page-warning'><?= session('errors.id_campus') ?></p>
                                </div>

                                <div class="form-group">
                                    <label class="label-blue"><i class="fas fa-id-card"></i> ID (Con ceros)</label>
                                    <input class="form-control" value="<?= old('matricula') ?>" name="matricula"
                                        placeholder="ID institucional de ITSON">
                                    <p class='page-warning'><?= session('errors.matricula') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="<?= base_url(); ?>/" class="btn btn-danger"><i class="fas fa-times"></i>
                                Cancelar</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-user-plus"></i>
                                Registrarse</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>


    <script src="<?= base_url(); ?>/dist/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url(); ?>/dist/js/bootstrap.min.js"></script>

    <!--   Metis Menu Plugin JavaScript -->
    <script src="<?= base_url(); ?>/dist/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url(); ?>/dist/js/startmin.js"></script>

</body>

</html>