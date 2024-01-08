<?php headerAdmin($data); 

 $con = new Mysql();

 $inicio = date('Y-m-d');
 $fin = date('Y-m-d');
 $date = date('Y-m-d');

 $total_caja_day = 0;
 $reservacion_pagos = 0;
 $total_ventas_day = 0;

 if (isset($_GET['fecha_inicio'])) {
     $inicio = $_GET['fecha_inicio'];
 }

 if (isset($_GET['fecha_fin'])) {
    $fin = $_GET['fecha_fin'];
 }
 if(isset($_GET['fecha']) && !empty($_GET['fecha'])){
    $fecha_cierre = $_GET['fecha'];
 }

$fechaInicio = date('Y-m-d');
$fechaFin = date('Y-m-d');

$sql = "SELECT r.id_reservacion, r.fecha_inicio, r.fecha_fin, f.serie as serie_factura, b.serie as serie_boleta, r.fecha_hora_checkIn, u.nombres as cliente, CONCAT(u.nombres,u.apellidos) as usuario, rp.voucher_electronico_id as tipocomprobante, h.idhabitacion as id_habitacion, h.nombre_habitacion, o.nombre as origen, e.nombre as estado, mep.nombre as mediopago, r.total FROM reservaciones r INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion INNER JOIN origen_reservacion o ON r.reservacion_origen_id=o.idorigen_reservacion INNER JOIN reservaciones_estados e ON r.reservacion_estado_id=e.id_reservacionestado INNER JOIN usuario u ON r.cliente=u.idusuario LEFT JOIN reservaciones_payments rp ON r.id_reservacion = rp.reservacionid LEFT JOIN venta_medio_pago mp ON mp.id_venta = r.id_reservacion  LEFT JOIN medio_pago mep ON mep.idmediopago = rp.metodo_pago_id  LEFT JOIN factura f ON f.id_venta = r.id_reservacion LEFT JOIN boleta b ON b.id_venta = r.id_reservacion  where r.reservacion_estado_id != 4 and r.created_at BETWEEN '". $inicio ." 00:00:00' AND '".$fin." 23:59:59' group by r.id_reservacion ";
$request_sql = $con->listar($sql);



// var_dump($request_sql);exit;

$conf = "SELECT * FROM configuracion WHERE id = 1";
$request_confg = $con->buscar($conf);
$fecha_cierre = $request_confg["fecha_cierre"];
$hoy = $request_confg["fecha_cierre"];

$sql_caja = "SELECT * FROM caja";
$request_caja = $con->listar($sql_caja);
$wherein = "(";
foreach ($request_caja as $c) {
      $wherein .= $c["id_caja"] . ",";
}
$wherein = substr($wherein, 0, -1);
$wherein .= ")";

$total_ventas = "SELECT SUM(total_venta) as total FROM venta WHERE venta_estado_id = 2 AND created_at = '".$request_confg["fecha_cierre"]."'";
$request_ventas = $con->buscar($total_ventas);
$total_ventas_day = $request_ventas['total'];

$total_pago_reservacion = "SELECT SUM(monto) as reservacion FROM movimiento_caja WHERE tipomovimientocaja_id = 2 and estado = 1 and created_at = '".$request_confg["fecha_cierre"]."'";
$request_reservacion = $con->buscar($total_pago_reservacion);
$reservacion_pagos = $request_reservacion['reservacion'];
$total_caja_day = $total_ventas_day + $reservacion_pagos;

$total_ventas = "SELECT SUM(total_venta) as total FROM venta WHERE venta_estado_id = 2 AND created_at = '".$request_confg["fecha_cierre"]."'";
$request_ventas = $con->buscar($total_ventas);
$total_ventas_day = $request_ventas['total'];


$medios = "SELECT * FROM medio_pago";
$totales = $con->listar($medios);
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
                            <li class="breadcrumb-item active">Reportes</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Reporte de reservas</h4>
                </div>
            </div>
        </div>     
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-body">
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
                                <table id="tableRooms" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th>Comprobante</th>
                                            <th>Serie</th>
                                            <th>Habitacion</th>
                                            <th>Fecha/Hora</th>
                                            <th>Cliente</th>
                                            <th>Origen</th>
                                            <th>Usuario</th>
                                            <?php foreach ($totales as $tot) : ?>
                                                <th><?php echo $tot["nombre"]; ?></th>
                                            <?php endforeach; ?>
                                            <th>SubTotal</th>
                                            <th>IGV</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                                
                                    <tbody style="text-align: center;">
                                        <?php 
                                        foreach($request_sql as $list):

                                            $total = $list['total'];
                                        ?>
                                        <tr>
                                        <?php
                                                $reservacionid =  $list['id_reservacion'];
                                                $btnPrint = '';
                                                if($list['tipocomprobante'] == 3){
                                                    $btnPrint .= '<a title="Imprimir" href="'.base_url().'/prints/reimpresion?id='. $reservacionid.'" target="_blank" style="color:black">
                                                    <i class="fa-solid fa-print"></i>
                                                    </a>';
                                                }else if($list['tipocomprobante'] == 1){
                                                    $btnPrint .= '<a title="Imprimir" href="'.base_url().'/prints/facturares?id='.$reservacionid.'" target="_blank" style="color:black">
                                                    <i class="fa-solid fa-print"></i>
                                                    </a>';
                                                }else if($list['tipocomprobante'] == 2){
                                                    $btnPrint .= '<a title="Imprimir" href="'.base_url().'/prints/boletares?id='.$reservacionid.'" target="_blank" style="color:black">
                                                    <i class="fa-solid fa-print"></i>
                                                    </a>';
                                                }else{
                                                    echo "";
                                                }
                                            ?> 
                                            <td><?php echo $btnPrint?></td>
                                        <td><?= $list['id_reservacion']?></td>
                                        <td><?php
                                                if($list['tipocomprobante'] == 3){
                                                    echo "TICKET";
                                                }else if($list['tipocomprobante'] == 1){
                                                    echo "FACTURA";
                                                }else if($list['tipocomprobante'] == 2){
                                                    echo  "BOLETA";
                                                }else{
                                                    echo "SIN COMPROBANTE";
                                                }
                                            ?>
                                        </td>
                                        <td><?php
                                                if($list['tipocomprobante'] == 3){
                                                    echo "";
                                                }else if($list['tipocomprobante'] == 1){
                                                    echo $list['serie_factura'];
                                                }else if($list['tipocomprobante'] == 2){
                                                    echo $list['serie_boleta'];
                                                }else{
                                                    echo "SIN COMPROBANTE";
                                                }
                                            ?>
                                        </td>
                                            <td><?= $list['nombre_habitacion']?></td>
                                            <td><?= $list['fecha_hora_checkIn']?></td>
                                            <td><?= $list['usuario']?></td>
                                            <td style="text-align:center;"><?= $list['origen']?></td>
                                            <td><?= $_SESSION['userData']['nombres']?></td>
                                                <?php
                                                foreach ($totales as $tot) {
                                                    $query_parcial = "Select sum(total) as parcial from reservaciones_payments where reservacionid = '" . $list['id_reservacion'] . "'  AND  metodo_pago_id = '" . $tot["idmediopago"] . "'";
                                                    $r_parcial = $con->listar($query_parcial);
                                                    
                                                    foreach($r_parcial as $row){
                                                        echo "<td style='text-align: center'>";
                                                        echo number_format(floatval($row['parcial']), 2, '.', ' ');
                                                        echo "</td>";
                                                    }
                                                    
                                                
                                                }
                                                ?>
                                            <td><?php echo number_format(floatval(($total/110)*100), 2, ".", "") ?></td>
                                            <td><?php echo number_format(floatval(($total/110)*10), 2, ".", "") ?></td>
                                            <td><?php echo number_format(floatval(($total)), 2, ".", "") ?></td>
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
        window.location.href = base_url+"/reports/rooms?fecha_inicio=" + $('#fechainicio').val() + 
            "&fecha_fin="+ $('#fechafin').val();
    };
</script>


<?php footerAdmin($data); ?>