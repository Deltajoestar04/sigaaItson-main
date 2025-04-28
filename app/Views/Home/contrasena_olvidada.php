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
  <title>ITSON - Contraseña olvidada</title>

  <!-- Bootstrap Core CSS -->
  <link href="<?php base_url() ?>/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="<?php base_url() ?>/dist/css/metisMenu.min.css" rel="stylesheet">

  <!-- Timeline CSS -->
  <link href="<?php base_url() ?>/dist/css/timeline.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?php base_url() ?>/dist/css/startmin.css" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <link href="<?php base_url() ?>/dist/css/morris.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="<?php base_url() ?>/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Estilos de proyecto -->
  <link href="<?php base_url() ?>/dist/css/custom/style.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>/dist/css/custom/home/olvidarContraseña.css" rel="stylesheet" type="text/css">

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


    <div class="login-container">
  <div class="login-panel">
    <div class="panel-heading">
      <div class="panel-title-container">
        <h3 class="panel-title"><i class="fas fa-lock"></i> Restablecer contraseña</h3>
      </div>
    </div>

    <div class="panel-body">
      <div class="form-group">
        <div class="panel-description">
          <p>
            <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
            Ingresa tu matrícula para restablecer la contraseña. Recibirás un correo electrónico con un enlace para cambiar tu contraseña. Ten en cuenta que el enlace tendrá una fecha de expiración determinada.
            </p>
        </div>

        <form action="<?= base_url(); ?>/usuario/recuperacion_contrasena" method="post">
          <div class="form-group">
          <label style="color: #006db6;"><i class="fas fa-user" style="color: #006db6;"></i> Matrícula</label>
            <input class="form-control" placeholder="Ingresa su ID (incluyendo los ceros)" id="matricula" name="matricula" required autofocus>
          </div>
        
          <a href="<?= base_url(); ?>/" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar</a>
          <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Recuperar contraseña</button>
      
        </form>

      </div>
    </div>
  </div>
</div>
</div>


    <script src="<?php base_url() ?>/dist/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php base_url() ?>/dist/js/bootstrap.min.js"></script>

    <!--   Metis Menu Plugin JavaScript -->
    <script src="<?php base_url() ?>/dist/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php base_url() ?>/dist/js/startmin.js"></script>


</body>

</html>