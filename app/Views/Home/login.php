<!DOCTYPE html>
<html lang="en">
<?php session() ?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">


  <title>ITSON - Registro De Capacitaciones</title>

  <!-- Bootstrap Core CSS -->
  <link href="<?= base_url() ?>/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="<?= base_url() ?>/dist/css/metisMenu.min.css" rel="stylesheet">

  <!-- Timeline CSS -->
  <link href="<?= base_url() ?>/dist/css/timeline.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?= base_url() ?>/dist/css/startmin.css" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <link href="<?= base_url() ?>/dist/css/morris.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="<?= base_url() ?>/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Estilos de proyecto -->
  <link href="<?= base_url() ?>/dist/css/custom/style.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>/dist/css/custom/home/login.css" rel="stylesheet" type="text/css">
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
        <img class="header__logo-img" src="<?= base_url(); ?>/dist/img/ITSON_negativo.png"
          alt="Logo de universidad ITSON">
      </div>
    </header>
    <div class="login-container">
      <div class="login-panel">
        <div class="panel-heading">
          <div class="panel-title-container">
            <h3 class="panel-title"><i class="fas fa-key"></i> Inicio de Sesión</h3>
          </div>
        </div>

        <div class="panel-body">
          <p class="panel-description">
            <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
            Ingresa tu matrícula y contraseña para iniciar sesión. Si aún no tienes una cuenta, puedes registrarte
            utilizando el enlace proporcionado. En caso de haber olvidado tu contraseña, utiliza el enlace
            correspondiente para recuperarla.
          </p>

          <form action="<?= base_url(); ?>/iniciar-sesion" method="POST">
            <div class="form-group">
              <?php if (session('msg') !== null): ?>
                <div class="alert alert-success"><?= session('msg'); ?></div>
              <?php endif; ?>

              <?php if (isset($_GET['logout']) && $_GET['logout'] === 'true'): ?>
                <div class="alert alert-success">
                  Has cerrado sesión correctamente.
                </div>
              <?php endif; ?>

              <div class="form-group">
                <label for="matricula"><i class="fas fa-user"></i> Matrícula</label>
                <input class="form-control" value="<?= old('matricula') ?>" placeholder="Ingresa tu Matrícula"
                  name="matricula" autofocus>
                <?php if (session('errors.matricula')): ?>
                  <div class="alert alert-danger"><?= session('errors.matricula') ?></div>
                <?php endif; ?>
              </div>

              <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                <input class="form-control" placeholder="Contraseña" name="password" type="password">
                <?php if (session('errors.password')): ?>
                  <div class="alert alert-danger"><?= session('errors.password') ?></div>
                <?php endif; ?>
              </div>

              <?php if (session('errors')): ?>
                <div class="alert alert-danger">La matrícula o contraseña son incorrectos</div>
              <?php endif; ?>

              <a href="<?= base_url(); ?>/contrasena_olvidada" class="forgot-password-link">¿Olvidaste la
                contraseña?</a>
              <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Entrar
              </button>
            </div>
          </form>

          <div class="register-link">
            <span>No tienes cuenta? </span><a href="<?= base_url(); ?>/registrar"
              class="register-link-text">Regístrate</a>
          </div>
        </div>



      </div>
    </div>



    <script src="<?= base_url() ?>/dist/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url() ?>/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= base_url() ?>/dist/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url() ?>/dist/js/startmin.js"></script>

</body>

</html>

