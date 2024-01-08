<?php headerAdmin($data);

$con = new Mysql();

$inicio = date('Y-m-d');
$fin = date('Y-m-d');

if (isset($_GET['fecha_inicio'])) {
    $inicio = $_GET['fecha_inicio'];
}

if (isset($_GET['fecha_fin'])) {
    $fin = $_GET['fecha_fin'];
}

$fechaInicio = date('Y-m-d');
$fechaFin = date('Y-m-d');
$sql = "SELECT b.id as id_boleta, b.serie, v.idventa, v.usuario, v.subtotal, v.total_impuestos, v.venta_estado_id as estado, v.total_venta, v.created_at  FROM venta v INNER JOIN boleta b ON v.idventa = b.id_venta WHERE v.created_at BETWEEN '" . $inicio . " 00:00:00' AND '" . $fin . " 23:59:59'";
$request_sql = $con->listar($sql);


?>
<div class="wrapper">
    <div class="content-page">

        <?php require_once("Libraries/Core/Open.php") ?>
        <!-- content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                                    <li class="breadcrumb-item active">PSE</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Boletas de ventas</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h4>
                                <strong >Crear Habitación: </strong><span id="total" class="text-dark"></span><input type="hidden" name="total_venta" id="total_venta" style="height=">
                                
                            </h4>
                            <br> -->
                                <div class="row">
                                    <h4 class="page-title"> <i class=" dripicons-align-center"></i> Filtros</h4>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-date" class="form-label">Fecha inicio: </label>
                                            <input class="form-control" id="fechainicio" type="date" name="fechainicio" value="<?php echo  $fechaInicio; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-date" class="form-label">Fecha fin: </label>
                                            <input class="form-control" id="fechafin" type="date" name="fechafin" value="<?php echo  $fechaFin; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <br>
                                            <button onclick="buscar()" type="button" class="btn btn-primary">
                                                <i class="dripicons-search">
                                                </i>
                                                <span id="btnText">Buscar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header">
                                        <div class="tab-content">
                                            <div class="table-responsive">
                                                <table id="tableTickets" class="table dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Nro de boleta </th>
                                                            <th># Venta</th>
                                                            <th>Serie</th>
                                                            <th>Usuario</th>
                                                            <th>Fecha</th>
                                                            <th>Estado de Comprobante</th>
                                                            <th>SubTotal</th>
                                                            <th>Total Impuestos</th>
                                                            <th>Total</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody style="text-align: center;">
                                                        <?php
                                                        foreach ($request_sql as $list) :

                                                        ?>
                                                            <tr>
                                                                <td><?= $list['id_boleta'] ?></td>
                                                                <td><?= $list['idventa'] ?></td>
                                                                <td><?= $list['serie'] ?></td>
                                                                <td><?= $list['usuario'] ?></td>
                                                                <td><?= $list['created_at'] ?></td>
                                                                <td><?php
                                                                    if ($list['estado'] == 2) :
                                                                        echo $list['estado'] = '<span style="background:#0F4B81;color:white;padding:5px;border-radius:5px">Boleta emitida</span>';
                                                                    elseif ($list['estado'] == 4) :
                                                                        echo $list['estado'] = '<span style="background:#EF6A01;color:white;padding:5px;border-radius:5px">Boleta anulada</span>';
                                                                    endif;
                                                                    ?>
                                                                </td>
                                                                <td><?= number_format($list['subtotal'], 2) ?></td>
                                                                <td><?= number_format($list['total_impuestos'], 2) ?></td>
                                                                <td><?= $list['total_venta'] ?></td>
                                                                <td>
                                                                    <button style="border:none; background:transparent;" onclick="DescargarXML(<?php echo $list['id_boleta'] ?>)" title="Descargar XML"><i style="color:#005a93" class="fa-solid fa-file-code fa-lg"></i></button>&nbsp;<button style="border:none; background:transparent;" onclick="DescargarBoleta(<?php echo $list['id_boleta'] ?>)" title="Descargar Boleta"><i class="fa-solid fa-file-pdf fa-lg"></i></button>&nbsp;<button style="border:none; background:transparent;" onclick="AnularBoleta(<?php echo $list['id_boleta'] ?>)" title="Anular Boleta"><i style="color: #DC3545;" class="fa-solid fa-trash fa-lg"></i></button>




                                                                </td>
                                                            </tr>
                                                        <?php
                                                        endforeach;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- end preview-->

                                        </div> <!-- end tab-content-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>

                    </div>
                </div>
                <!-- content -->
            </div>
        </div>

        <script>
            function buscar() {
                window.location.href = base_url + "/reports/boletasalesfecha_inicio=" + $('#fechainicio').val() +
                    "&fecha_fin=" + $('#fechafin').val();
            }
        </script>


        <?php footerAdmin($data); ?>