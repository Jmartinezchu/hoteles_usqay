<?php
headerAdmin($data);
require_once("Libraries/Core/Mysql.php");
$con = new Mysql();
$date = date('Y-m-d');

$total_caja_day = 0;
$reservacion_pagos = 0;
$total_ventas_day = 0;

$conf = "SELECT * FROM configuracion WHERE id = 1";
$request_confg = $con->buscar($conf);
$fecha_cierre = $request_confg["fecha_cierre"];
$fechaInicio = $request_confg["fecha_cierre"];

if (isset($_GET['fecha']) && !empty($_GET['fecha'])) {
    $fecha_cierre = $_GET['fecha'];
}

$sql_caja = "SELECT * FROM caja";
$request_caja = $con->listar($sql_caja);
$wherein = "(";
foreach ($request_caja as $c) {
    $wherein .= $c["id_caja"] . ",";
}
$wherein = substr($wherein, 0, -1);
$wherein .= ")";


$total_ventas = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 3 AND estado = 1 AND fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_ventas = $con->buscar($total_ventas);
$total_ventas_day = $request_ventas['total'];


$total_pago_reservacion = "SELECT SUM(monto) as reservacion FROM movimiento_caja WHERE tipomovimientocaja_id = 2 and estado = 1 and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_reservacion = $con->buscar($total_pago_reservacion);
$reservacion_pagos = $request_reservacion['reservacion'];

//   $total_caja_day = $total_ventas_day + $reservacion_pagos;

$openMoney = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 1 and estado = 1 and fecha = '" . $fechaInicio . "'";
$request_open = $con->buscar($openMoney);
$montoOpen = $request_open["total"];

$total_visa = "SELECT SUM(monto) as visa FROM movimiento_caja WHERE mediopagoid = 2  and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_visa = $con->buscar($total_visa);
$visa = $request_visa['visa'];


$total_yape = "SELECT SUM(monto) as yape FROM movimiento_caja WHERE mediopagoid = 5  and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_yape = $con->buscar($total_yape);
$yape = $request_yape['yape'];



$total_plin = "SELECT SUM(monto) as plin FROM movimiento_caja WHERE mediopagoid = 6 and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_plin = $con->buscar($total_plin);
$plin = $request_plin['plin'];



$total_mastercard = "SELECT SUM(monto) as mastercard FROM movimiento_caja WHERE mediopagoid = 3  and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_mastercard = $con->buscar($total_mastercard);
$mastercard = $request_mastercard['mastercard'];

$total_otro_tipo_ingreso = "SELECT SUM(monto) as ingresos FROM movimiento_caja WHERE mediopagoid = 1 and tipomovimientocaja_id = 11 and estado = 1 and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_ingresos = $con->buscar($total_otro_tipo_ingreso);
$total_ingresos_day_efectivo = $request_ingresos['ingresos'];

$total_otro_tipo = "SELECT SUM(monto) as ingresos FROM movimiento_caja WHERE mediopagoid = 1 and tipomovimientocaja_id = 11 and estado = 1 and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_ingresos = $con->buscar($total_otro_tipo_ingreso);
$total_ingresos_day = $request_ingresos['ingresos'];

$total_efectivo = "SELECT SUM(monto) as efectivo FROM movimiento_caja WHERE mediopagoid = 1 and tipomovimientocaja_id = 3 and estado = 1  and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_efectivo = $con->buscar($total_efectivo);


$total_efectivo_reserv = "SELECT SUM(monto) as efectivo FROM movimiento_caja WHERE mediopagoid = 1 and tipomovimientocaja_id = 2 and estado = 1 and fecha = '" . $request_confg["fecha_cierre"] . "'";
$request_efectivo_reserv = $con->buscar($total_efectivo_reserv);


$total_efectivo_day = $request_efectivo['efectivo'] + $request_efectivo_reserv['efectivo'] + $total_ingresos_day_efectivo;


$efectivo_salidas = "SELECT SUM(monto) as efectivo_salidas FROM movimiento_caja WHERE mediopagoid = 1 and estado = 2 and fecha ='" . $request_confg["fecha_cierre"] . "'";
$request_efectivo_salidas = $con->buscar($efectivo_salidas);
$total_salidas_efectivo = $request_efectivo_salidas['efectivo_salidas'];

$efectivoF =  $total_efectivo_day + $total_salidas_efectivo;


$total_caja_day = $total_efectivo_day + $visa + $yape + $mastercard + $plin;


?>


<!-- content -->
<div class="wrapper">
    <div class="content-page">
        <?php require_once("Libraries/Core/Open.php") ?>
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Menú principal</h4>
                        </div>
                    </div>
                </div>

                <!----------------------- TARJETAS DE DATOS INICIALES ----------------------->
                <div class="card">
                    <div class="row">

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-sale widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Ventas</h5>
                                    <h3 class="mt-3 mb-3"><?= $data['ventas'] ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-book-open widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Reservas</h5>
                                    <h3 class="mt-3 mb-3"><?= $data['reservas'] ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-cash widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Pagos</h5>
                                    <h3 class="mt-3 mb-3"><?= formatMoney($total_caja_day + $total_salidas_efectivo) ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-cash-register widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Movimientos de dinero</h5>
                                    <h3 class="mt-3 mb-3"><?= formatMoney($total_ingresos_day) ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->


                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Efectivo</h5>
                                    <h3 class="mt-3 mb-3"><?= formatMoney($efectivoF) ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Mastercard</h5>
                                    <h3 class="mt-3 mb-3"><?= formatMoney($mastercard) ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Visa</h5>
                                    <h3 class="mt-3 mb-3"><?= formatMoney($visa) ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Yape</h5>
                                    <h3 class="mt-3 mb-3"><?= formatMoney($yape) ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Plin</h5>
                                    <h3 class="mt-3 mb-3"><?= formatMoney(abs($plin)) ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">En mantenimiento</h5>
                                    <h3 class="mt-3 mb-3"><?= $data['mantenimiento'] ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Ocupada</h5>
                                    <h3 class="mt-3 mb-3"><?= $data['ocupadas'] ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-lg-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Disponible</h5>
                                    <h3 class="mt-3 mb-3"><?= $data['disponible'] ?></h3>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                    </div>
                </div>
                <!----------------------- TARJETAS DE DATOS INICIALES ----------------------->

                <!----------------------- SEGUNDA FILA DE DATOS ----------------------------->
                <div class="card">
                    <div class="row">

                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <button onclick="verUsuarios();" type="button" class="btn btn-info"><i class="uil-search-plus"></i> </button>
                                    </div>
                                    <h4 class="header-title mb-4">Nuevos huespedes</h4>
                                    <!------------------ ITEMS ------------------>
                                    <?php
                                    if (count($data['ultimosusuarios']) > 0) {
                                        foreach ($data['ultimosusuarios'] as $usuarios) {
                                    ?>
                                            <div class="d-flex align-items-start mt-3">
                                                <img class="me-3 rounded-circle" src="<?= media(); ?>/images/avatar.png" width="40" alt="Generic placeholder image">
                                                <div class="w-100 overflow-hidden">
                                                    <span class="badge badge-success-lighten float-end">
                                                        <i class="uil-user"></i>
                                                    </span>
                                                    <span class="badge badge-warning-lighten float-end">
                                                        <i class="uil-postcard"></i>
                                                    </span>
                                                    <span class="badge badge-danger-lighten float-end">
                                                        <i class="uil-phone-alt"></i>
                                                    </span>
                                                    <h5 class="mt-0 mb-1"><?= $usuarios['nombres'] ?></h5>
                                                    <span class="font-13"><?= $usuarios['email_user'] ?></span>
                                                </div>
                                            </div>
                                            <!------------------ ITEMS ------------------>

                                    <?php }
                                    } ?>

                                </div>
                                <!-- end card-body -->
                            </div>






                        </div><!-- end col-->


                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <button onclick="verReservas();" type="button" class="btn btn-info"><i class="uil-search-plus"></i> </button>
                                    </div>

                                    <h4 class="header-title">Ultimas reservas</h4>
                                    <!-- end nav-->
                                    <div class="tab-content">
                                        <div class="table-responsive" id="striped-rows-preview">
                                            <div class="table-responsive-sm">
                                                <table class="table table-striped table-centered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Cliente</th>
                                                            <th>Desde</th>
                                                            <th>Hasta</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        if (count($data['ultimasreservas']) > 0) {
                                                            foreach ($data['ultimasreservas'] as $reservas) {
                                                        ?>

                                                                <tr>
                                                                    <td class="table-user">
                                                                        <?= $reservas['cliente'] ?>
                                                                    </td>
                                                                    <td><?= $reservas['fechainicio'] ?></td>
                                                                    <td><?= $reservas['fechafin'] ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($reservas['reservacion_estado_id'] == 1) {
                                                                        ?>

                                                                            <span class="status usqay-orange"></span>
                                                                            Pendiente
                                                                        <?php  } else if ($reservas['reservacion_estado_id'] == 2) { ?>
                                                                            <span class="status usqay-blue"></span>
                                                                            Checked In
                                                                        <?php } else if ($reservas['reservacion_estado_id'] == 3) { ?>
                                                                            <span class="status usqay-orange"></span>
                                                                            Checked Out
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                        <?php }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div> <!-- end table-responsive-->
                                        </div> <!-- end preview-->

                                    </div> <!-- end tab-content-->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->



                    </div>
                </div>

                <!----------------------- SEGUNDA FILA DE DATOS ----------------------------->

                <!----------------------- PRIMER GRAFICO ------------------------------------>
                <!-- <div class="card">


                        <div class="row">
                            <div class="col-xl-9 col-lg-8">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <ul class="nav float-end d-none d-lg-flex">
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">Today</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">7d</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#">15d</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">1m</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">1y</a>
                                            </li>
                                        </ul>
                                        <h4 class="header-title mb-3">Sessions Overview</h4>

                                        <div dir="ltr">
                                            <div id="sessions-overview" class="apex-charts mt-3" data-colors="#0acf97"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                        </div> -->


                <!----------------------- PRIMER GRAFICO ------------------------------------>

                <!----------------------- PRIMER GRAFICO ------------------------------------>
                <!-- <div class="card">


                        <div class="row">
                            <div class="col-xl-9 col-lg-8">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <ul class="nav float-end d-none d-lg-flex">
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">Today</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">7d</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#">15d</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">1m</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-muted" href="#">1y</a>
                                            </li>
                                        </ul>
                                        <h4 class="header-title mb-3">Sessions Overview</h4>

                                        <div dir="ltr">
                                            <div id="sessions-overview" class="apex-charts mt-3" data-colors="#0acf97"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                        </div>
                        </div> -->


                <!----------------------- PRIMER GRAFICO ------------------------------------>


            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data); ?>