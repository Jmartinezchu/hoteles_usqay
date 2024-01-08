<?php 
 
 require_once("Libraries/Core/Mysql.php");
 $con = new Mysql();

 $config = "SELECT * FROM configuracion WHERE id = 1";
 $request_config = $con->buscar($config);
 $fecha_actual = date("Y-m-d");
 
 if(strtotime($fecha_actual) === strtotime($request_config["fecha_cierre"])){
    header('Location: '.base_url().'/dashboard');
 }

 getModal("modalOpenBox",$data);
?>



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

        <!-- Grafica 1 -->
        <link href="<?= media();?>/css/vendor/britecharts.min.css" rel="stylesheet" type="text/css">



        <!-- App css -->
        <link href="<?= media();?>/css/icons.min.css" rel="stylesheet" type="text/css">
        <link href="<?= media();?>/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
        <link href="<?= media();?>/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">


</head>

<body>

    
    <div class="wrapper">
        <header>
            <div class="navbar-custom " style="left: 0; ">
                        <ul class="list-unstyled topbar-menu float-end mb-0">
                            <li class="dropdown notification-list topbar-dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="<?= media();?>/images/flags/pe.jpg" alt="user-image" class="me-0 me-sm-1" height="12"> 
                                    <span class="align-middle d-none d-sm-inline-block">Perú</span>
                                </a>
                            </li>

                        </ul>
            </div>
        </header>

    <div class="container-fluid">
        <div class="page" style="padding: 100px;">
            <div class="alert alert-info bg-white text-info" role="alert">
                <h4 class="alert-heading" style ="text-align: center;">Aviso!</h4>
                <p style ="text-align: center;" >La fecha actual es diferente a la fecha de cierre, ¿Deseas aperturar un nuevo día?</p>
                <p style ="text-align: center;" >Ultimo cierre: <b><?php echo $request_config["fecha_cierre"];?></b></p>
                <hr>
                <div style= "text-align:center;">
                    <button type="button" class="btn btn-info btn-rounded" onclick="aperturar()">Aperturar</button>
                    
                    <button type="button" class="btn btn-danger btn-rounded" onclick="cancelar()">Cancelar</button>
                </div>
                <a type="button" class="btn btn-outline-info btn-rounded float mb-0" href="<?= base_url(); ?>/logout">
                    <i class="uil-circuit"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </div>
<script src="<?= media();?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<?php footerAdmin($data); ?>
