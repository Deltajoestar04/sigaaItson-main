<!DOCTYPE html>
<html lang="en">
<?php helper('form'); ?>
<?php session(); ?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ITSON - Restablecer contraseña</title>

  <!-- Bootstrap Core CSS -->
  <link href="<?= base_url('dist/css/bootstrap.min.css') ?>" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="<?= base_url('dist/css/metisMenu.min.css') ?>" rel="stylesheet">

  <!-- Timeline CSS -->
  <link href="<?= base_url('dist/css/timeline.css') ?>" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?= base_url('dist/css/startmin.css') ?>" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <link href="<?= base_url('dist/css/morris.css') ?>" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="<?= base_url('dist/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">

  <!-- Estilos de proyecto -->
  <link href="<?= base_url('dist/css/custom/style.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>/dist/css/custom/home/restablecerContraseña.css" rel="stylesheet" type="text/css">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <div class="container-fluid">
    <header class="header navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="header__logo-container navbar-header">
        <img class="header__logo-img" src="<?= base_url('dist/img/ITSON_negativo.png') ?>"
          alt="Logo de universidad ITSON">
      </div>
    </header>

    <div class="reset-password-container">
      <div class="reset-password-panel">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fas fa-lock"></i> Restablecer Contraseña</h3>
        </div>
        <div class="panel-body">
          <form action="<?= base_url('/reiniciar_contrasena') ?>" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">

            <div class="panel-description">
              <p>
                <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
                Por favor, ingrese una nueva contraseña y confírmela en los campos correspondientes.

Una vez que haya confirmado su nueva contraseña, será redirigido al inicio de sesión, donde podrá acceder a su cuenta utilizando sus nuevas credenciales. 
              </p>
              </div>
              <div class="form-group">
                <label style="color: #006db6;" ><i class="fas fa-key"style="color: #006db6;"></i> Contraseña Nueva</label>
                <input type="password" class="form-control" name="contrasena"
                  placeholder="Ingrese una contraseña nueva">
                <p class='page-warning'><?= session('errors.contrasena') ?></p>
              </div>

              <div class="form-group">
                <label style="color: #006db6;"><i class="fas fa-key" style="color: #006db6;"></i> Confirme su Contraseña Nueva</label>
                <input type="password" class="form-control" name="confirmar_contrasena"
                  placeholder="Repite la contraseña nueva">
                <p class='page-warning'><?= session('errors.confirmar_contrasena') ?></p>
              </div>

              <div class="form-group text-center">
              <a href="<?= base_url(); ?>/" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Restablecer</button>
             
              </div>
          </form>
        </div>
      </div>
    </div>

  </div>

  <script src="<?= base_url('dist/js/jquery.min.js') ?>"></script>
  <script src="<?= base_url('dist/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('dist/js/metisMenu.min.js') ?>"></script>
  <script src="<?= base_url('dist/js/startmin.js') ?>"></script>
</body>

</html>