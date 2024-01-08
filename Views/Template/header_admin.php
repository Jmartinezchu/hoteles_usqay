<!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <title><?php echo $data['page_title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= media();?>/images/usqay-icon.svg" type="image/x-icon">

        <!-- third party css -->
        <link href="<?= media();?>/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
        <!-- third party css end -->

         <!--Scripts para data-->
        
         <script src="<?= media();?>/plugins/cloudflare/sweetalert2.all.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?= media();?>/plugins/jquery/jquery-3.3.1.js"></script>


        <!-- CSS TABLAS-->
        <link href="<?= media();?>/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">
        <link href="<?= media();?>/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css">
        <link href="<?= media();?>/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css">
        <link href="<?= media();?>/css/vendor/select.bootstrap5.css" rel="stylesheet" type="text/css">
        <link href="<?= media();?>/css/vendor/apexcharts.css" rel="stylesheet" type="text/css">

        <!-- Grafica 1 -->
        <link href="<?= media();?>/css/vendor/britecharts.min.css" rel="stylesheet" type="text/css">



        <!-- App css -->
        <link href="<?= media();?>/css/icons.min.css" rel="stylesheet" type="text/css">
        <link href="<?= media();?>/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
        <link href="<?= media();?>/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

        <!-- <script src="https://kit.fontawesome/ce813f3b0e.js" crossorigin="anonymous"></script> -->

        
        <link href="<?= media();?>/plugins/fontawesome/css/fontawesome.css" rel="stylesheet" type="text/css" id="dark-style">
        <link href="<?= media();?>/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet" type="text/css" id="dark-style">
        <link href="<?= media();?>/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css" id="dark-style">
        <link href="<?= media();?>/plugins/fontawesome/css/font-awesome.css.map" rel="stylesheet" type="text/css" id="dark-style">
        <link href="<?= media();?>/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" id="dark-style">
        <link href="<?= media();?>/plugins/fontawesome/css/all.css" rel="stylesheet" type="text/css" id="dark-style">
        <link href="<?= media();?>/plugins/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" id="dark-style">


    </head>
    

    <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <!-- navbar Start -->
    <?php require_once("nav_admin.php"); ?>
    <!-- navbar End -->

    <!-- Header Content Start -->
        <div class="wrapper">
            <!-- aside Start -->
            <!-- Topbar Start -->
            <div class="navbar-custom">
                
                        <ul class="list-unstyled topbar-menu float-end mb-0">
                            <li class="dropdown notification-list topbar-dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="<?= media();?>/images/flags/pe.jpg" alt="user-image" class="me-0 me-sm-1" height="12"> 
                                    <span class="align-middle d-none d-sm-inline-block">Perú</span>
                                </a>
                            </li>


                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <span class="account-user-avatar"> 
                                        <img src="<?= media(); ?>/images/avatar.png" alt="user-image" class="rounded-circle">
                                        
                                    </span>
                                    <span>
                                        <span class="account-user-name"><?= $_SESSION['userData']['nombres']?></span>
                                        <span class="account-position"><?= $_SESSION['userData']['nombre_rol']?></span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                    <!-- item-->
                                    <a href="<?= base_url(); ?>/logout" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1" ></i>
                                        <span >Cerrar Sesión</span>
                                    </a>
                                </div>
                            </li>

                        </ul>
                        <button class="button-menu-mobile open-left">
                            <i class="mdi mdi-menu"></i>
                        </button>
            </div>
    <!-- end Header Content -->
        
        </div>
        <!-- END wrapper -->

    </body>
</html>