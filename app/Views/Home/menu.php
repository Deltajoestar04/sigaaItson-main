<?php $this->extend("General"); ?>

<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/home/menu.css') ?>">

<!-- Page Content -->
<div class="container-fluid">
    <header class="header navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="header__logo-container navbar-header">
            <img class="header__logo-img" src="<?php echo base_url(); ?>/dist/img/ITSON_negativo.png"
                alt="Logo de universidad ITSON">
        </div>
    </header>
    <div class="menu-container">
    <div class="menu-heading">
        <div class="heading-title-container">
            <h3 class="heading-title"><i class="fas fa-tachometer-alt"></i> Menú Principal</h3>
        </div>
    </div>

    <div class="row mb-3">
        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin") { ?>
            <div class="col-xs-12 col-sm-4">
                <a href="<?= base_url(); ?>/usuarios" class="menu-button btn btn-lg btn-block btn-primary">
                    <div class="button-icon"><i class="fa fa-chalkboard-teacher fa-2x"></i></div>
                    <div class="button-title">Maestros</div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a href="<?= base_url(); ?>/proximo" class="menu-button btn btn-lg btn-block btn-primary">
                    <div class="button-icon"><i class="fa fa-user-graduate fa-2x"></i></div>
                    <div class="button-title">Estudiantes</div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a href="<?= base_url(); ?>/proximo" class="menu-button btn btn-lg btn-block btn-primary">
                    <div class="button-icon"><i class="fa fa-graduation-cap fa-2x"></i></div>
                    <div class="button-title">Becas</div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a href="<?= base_url(); ?>/proximo" class="menu-button btn btn-lg btn-block btn-primary">
                    <div class="button-icon"><i class="fa fa-book fa-2x"></i></div>
                    <div class="button-title">Programas Educativos</div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a href="<?= base_url(); ?>/reportes" class="menu-button btn btn-lg btn-block btn-primary">
                    <div class="button-icon"><i class="fa fa-book fa-2x"></i></div>
                    <div class="button-title">Reportes PowerBI</div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <a href="<?= base_url(); ?>/cv" class="menu-button btn btn-lg btn-block btn-primary">
                    <div class="button-icon"><i class="fa fa-book fa-2x"></i></div>
                    <div class="button-title">CV</div>
                </a>
            </div>
            
        <?php } ?>

        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] != "admin") { ?>
            <div class="col-xs-12 col-sm-4">
                <a href="<?= base_url(); ?>/capacitaciones" class="menu-button btn btn-lg btn-block btn-primary">
                    <div class="button-icon"><i class="fa fa-chalkboard-teacher fa-2x"></i></div>
                    <div class="button-title">Capacitaciones</div>
                </a>
            </div>
         
        <?php } ?>
    </div>
</div>


    <!-- /.row -->
</div>
<!-- /.container-fluid -->





<?php $this->endSection(); ?>