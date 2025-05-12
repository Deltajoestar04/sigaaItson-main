<!DOCTYPE html>
<html lang="es">
<?php
$currentUrl = current_url();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ITSON - SIGAA</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">

    <!-- MetisMenu CSS -->
    <link href="<?= base_url() ?>/dist/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?= base_url() ?>/dist/css/timeline.css" rel="stylesheet">

    <!-- Template CSS -->
    <link href="<?= base_url() ?>/dist/css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?= base_url() ?>/dist/css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= base_url() ?>/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Project Styles -->
    <link href="<?= base_url() ?>/dist/css/custom/style.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

    <!-- Croppie CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">

    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/777822fdd5.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Fuente HTML -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <header class="header navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="header__logo-container navbar-header">
                <img class="header__logo-img" src="<?= base_url(); ?>/dist/img/ITSON_negativo.png"
                    alt="Logo de universidad ITSON">
            </div>
            <div>
                <h2 class="header__title">Sistema Integral De Gestión Académica y Administrativa (SIGAA)</h2>
            </div>

            <div class="header__button">
                <div class="header__button-container">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin") { ?>
                            <li>
                                <a href="<?= base_url(); ?>/menu"
                                    class="<?= ($currentUrl == base_url() . '/menu') ? 'active' : '' ?>">
                                    <i class="fa fa-home fa-fw"></i> Inicio
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/usuarios"
                                    class="<?= ($currentUrl == base_url() . '/usuarios') ? 'active' : '' ?>">
                                    <i class="fa-solid fa-person-chalkboard"></i> Maestros
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/proximo"
                                    class="<?= ($currentUrl == base_url() . '/proximo') ? 'active' : '' ?>">
                                    <i class="fa-solid fa-graduation-cap"></i> Estudiantes
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/Indicador"
                                    class="<?= ($currentUrl == base_url() . '/Indicador') ? 'active' : '' ?>">
                                    <i class="fa-solid fa-square-check"></i> Indicadores
                                </a>
                            <li>
                                <a href="<?= base_url(); ?>/proximo"
                                    class="<?= ($currentUrl == base_url() . '/proximo') ? 'active' : '' ?>">
                                    <i class="fa-solid fa-hand-holding-dollar"></i> Becas
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/proximo"
                                    class="<?= ($currentUrl == base_url() . '/proximo') ? 'active' : '' ?>">
                                    <i class="fa-solid fa-book"></i> Programas Educativos
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reportes"
                                    class="<?= ($currentUrl == base_url() . '/reportes') ? 'active' : '' ?>">
                                    <i class="fa-solid fa-book"></i> Reportes PowerBi
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/cv"
                                    class="<?= ($currentUrl == base_url() . '/cv') ? 'active' : '' ?>">
                                    <i class="fa fa-chalkboard-teacher fa-1x"></i> CV
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] != "admin") { ?>
                            <li>
                                <a href="<?= base_url(); ?>/menu"
                                    class="<?= ($currentUrl == base_url() . '/menu') ? 'active' : '' ?>">
                                    <i class="fa fa-home fa-fw"></i> Inicio
                                </a>
                            </li>
                            <li>
                            <a href="<?= base_url(); ?>/Indicador" class="<?= ($currentUrl == base_url() . '/Indicador') ? 'active' : '' ?>">
                            <i class="fa-solid fa-square-check"></i> Indicador
                                        </a>
                                    </li>
                            <li>
                                <a href="<?= base_url(); ?>/capacitaciones"
                                    class="<?= ($currentUrl == base_url() . '/capacitaciones') ? 'active' : '' ?>">
                                    <i class="fa fa-chalkboard-teacher fa-1x"></i> Capacitaciones
                                </a>
                            </li>
                            <li>
                                <a href="#" class="<?= ($currentUrl == base_url() . '/cv') ? 'active' : '' ?>">
                                    <i class="fa-solid fa-book"></i> CV<span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?= base_url(); ?>/cv/datosgenerales"
                                            class="<?= ($currentUrl == base_url() . '/cv/datosgenerales') ? 'active' : '' ?>">
                                            <i class="fas fa-id-card"></i> Datos Generales
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>/cv/gradosacademicos"
                                            class="<?= ($currentUrl == base_url() . '/cv/gradosacademicos') ? 'active' : '' ?>">
                                            <i class="fa-solid fa-graduation-cap"></i> Grados Académicos
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>/cv/experiencialaboral"
                                            class="<?= ($currentUrl == base_url() . '/cv/experiencialaboral') ? 'active' : '' ?>">
                                            <i class="fa-solid fa-briefcase"></i> Experiencia Laboral
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>/cv/experienciadocente"
                                            class="<?= ($currentUrl == base_url() . '/cv/experienciadocente') ? 'active' : '' ?>">
                                            <i class="fa-solid fa-chalkboard-teacher"></i> Experiencia Docente
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>/cv/premios"
                                            class="<?= ($currentUrl == base_url() . '/cv/premios') ? 'active' : '' ?>">
                                            <i class="fa-solid fa-award"></i> Premios o Distinciones
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="<?= base_url(); ?>/cv/logros"
                                            class="<?= ($currentUrl == base_url() . '/cv/logros') ? 'active' : '' ?>">
                                            <i class="fa-solid fa-trophy"></i> Logros
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>/cv/asociaciones"
                                            class="<?= ($currentUrl == base_url() . '/cv/asociaciones') ? 'active' : '' ?>">
                                            <i class="fa-solid fa-handshake"></i> Asociaciones Profesionales
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <li>
                            <a
                                href="<?= base_url(); ?>/usuario/perfil/<?= isset($_SESSION["rol"]) ? $_SESSION["id"] : "" ?>">
                                <i class="fa fa-user fa-fw"></i> Perfil
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(); ?>/salir">
                                <i class="fa fa-sign-out fa-fw"></i> Salir
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </header>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php $this->renderSection("contenido") ?>
            </div>
        </div>
    </div>
    <style>
        .nav>li>a {
            color: #0066b3;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }


        .nav>li>a>i {
            margin-right: 10px;
            font-size: 18px;
        }

        .nav>li>a:hover,
        .nav>li>a:focus {
            background-color: #0066b3;
            color: #ffffff;
        }

        .nav>li>a.active {
            background-color: #0066b3;
            font-weight: bold;
        }

        .sidebar ul li a.active {
            background-color: #0066b3;
            color: #ffffff;
        }

        /* Submenú */
        .nav-second-level {
            background-color: #f9f9f9;
        }

        .nav-second-level li a {
            padding-left: 40px;
            color: #0066b3;
        }

        /* Separadores sutiles */
        .nav>li {
            border-bottom: 1px solid #e7e7e7;
        }



    </style>

    <!-- jQuery -->
    <!-- <script src="<?= base_url(); ?>/dist/js/jquery.min.js"></script> -->
     

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url(); ?>/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= base_url(); ?>/dist/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url(); ?>/dist/js/startmin.js"></script>

    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables jQuery Plugin -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    <!-- Croppie JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

    <?php $this->renderSection("js"); ?>
</body>

</html>