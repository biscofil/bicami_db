<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Bisconcin Filippo, Cabianca Marco, Milanese Francesco">

        <!-- CACHE OFF -->
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />

        <link rel="shortcut icon" type="image/png" href="<?= base_url('public/img/Plane.png') ?>"/>

        <title><?= $_page_title ?> - BiCaMi</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?= base_url('public/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?= base_url('public/stylish-portfolio.css') ?>" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?= base_url('public/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php $this->jscsshandler->out_css_files(); ?>

        <?php $this->jscsshandler->out_js_properties(); ?>

    </head>
    <body>
        <!-- Navigation -->
        <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
        <nav id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
                <li class="sidebar-brand">
                    <a href="#top" onclick=$("#menu-close").click();>BiCaMi</a>
                </li>
                <li>
                    <a href="<?= site_url() ?>" onclick=$("#menu-close").click();>Home</a>
                </li>
                <?php if (isLogged()) : ?>
                    <li>
                        <a href="javascript:void(0)"><b><?= ucwords(sessionInfo('nome') . " " . sessionInfo("cognome")) ?></b></a>
                        <ul>
                            <li>
                                <a href="<?= site_url('login/logout') ?>" onclick=$("#menu-close").click();>Logout</a>
                            </li>
                            <li>
                                <a href="<?= site_url('profilo') ?>" onclick=$("#menu-close").click();>Profilo</a>
                            </li>
                            <li>
                                <a href="<?= site_url('prenotazioni') ?>" onclick=$("#menu-close").click();>Le mie prenotazioni</a>
                            </li>
                        </ul>
                    </li>
                    <?php if (isAdmin()) : ?>
                        <li>
                            <a href="javascript:void(0)" style="color:red;"><b>Amministrazione</b></a>
                            <ul>
                                <li>
                                    <a href="<?= site_url('admin/tratte') ?>" onclick=$("#menu-close").click();>Tratte</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('admin/voli') ?>" onclick=$("#menu-close").click();>Voli</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('admin/prenotazioni') ?>" onclick=$("#menu-close").click();>Prenotazioni</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('admin/utenti') ?>" onclick=$("#menu-close").click();>Utenti</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('admin/aeroplani') ?>" onclick=$("#menu-close").click();>Aeroplani</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('admin/aeroporti') ?>" onclick=$("#menu-close").click();>Aeroporti</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('admin/compagnie') ?>" onclick=$("#menu-close").click();>Compagnie</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('statistiche') ?>" onclick=$("#menu-close").click();>Statistiche</a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    endif;
                else:
                    ?>
                    <li>
                        <a href="<?= site_url('login') ?>" onclick=$("#menu-close").click();>Login</a>
                    </li>
                    <li>
                        <a href="<?= site_url('login/registrazione') ?>" onclick=$("#menu-close").click();>Registrati</a>
                    </li>
                <?php endif; ?>

                <li>
                    <a href="javascript:void(0);" id="dati_demo" style="color:red;"><b>INSERISCI DATI DEMO</b></a>
                </li>
            </ul>
        </nav>

        <?php if (Alert::atLeastOne()): ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php Alert::printAll(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>