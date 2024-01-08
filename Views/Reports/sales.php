<?php  headerAdmin($data);   
     
 $con = new Mysql();
 $sql = "SELECT v.idventa, CONCAT(U.nombres, U.apellidos) as usuario, mp.nombre as medio, v.created_at as fecha, v.total_venta as total, ve.nombre as estado, t.descripcion, t.id_tipo_comprobante as tipocomprobante, b.serie as serie_boleta FROM venta v 
 INNER JOIN ventas_estado ve ON v.venta_estado_id = ve.id_venta_estado 
 INNER JOIN usuario u ON v.usuario = u.nombres 
 INNER JOIN tipo_comprobante_sunat t ON v.tipo_comprobante = t.id_tipo_comprobante
 LEFT JOIN factura f ON v.idventa = f.id_venta 
 LEFT JOIN boleta b ON v.idventa = b.id_venta 
 LEFT JOIN venta_medio_pago vmp ON v.idventa = vmp.id_venta 
 LEFT JOIN medio_pago mp ON mp.idmediopago = vmp.mediopago
 WHERE v.venta_estado_id != 3  BETWEEN '". $inicio ." 00:00:00' AND '".$fin." 23:59:59'
 GROUP BY v.idventa";
 $request_sql = $con->listar($sql);
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
                            <h4 class="page-title">Reporte de ventas</h4>
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
                                            <input class="form-control" id="fechainicio" type="date" name="fechainicio"
                                                value="<?php echo  $fechaInicio; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-date" class="form-label">Fecha fin: </label>
                                            <input class="form-control" id="fechafin" type="date" name="fechafin"
                                                value="<?php echo  $fechaFin; ?>">
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
                                                <table id="tableSales" class="table dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>ID</th>
                                                            <th>Comprobante</th>
                                                            <th>Serie</th>
                                                            <th>Cliente</th>
                                                            <th>Fecha</th>
                                                            <th>Tipo</th>
                                                            <?php foreach ($totales as $tot) : ?>
                                                            <th><?php echo $tot["nombre"]; ?></th>
                                                            <?php endforeach; ?>
                                                            <th>Subtotal</th>
                                                            <th>IGV</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php 
                                            foreach($request_sql as $ventas):
                                        ?>
                                                        <tr>
                                                            <?php
                                                $ventasid =  $ventas['idventa'];
                                                $btnPrint = '';
                                                if($ventas['tipocomprobante'] == 3){
                                                    $btnPrint .= '<a title="Imprimir" href="'.base_url().'/prints/reimpresion?id='. $ventasid.'" target="_blank" style="color:black">
                                                    <i class="fa-solid fa-print"></i>
                                                    </a>';
                                                }else if($ventas['tipocomprobante'] == 1){
                                                    $btnPrint .= '<a title="Imprimir" href="'.base_url().'/prints/facturares?id='.$ventasid.'" target="_blank" style="color:black">
                                                    <i class="fa-solid fa-print"></i>
                                                    </a>';
                                                }else if($ventas['tipocomprobante'] == 2){
                                                    $btnPrint .= '<a title="Imprimir" href="'.base_url().'/prints/boletares?id='.$ventasid.'" target="_blank" style="color:black">
                                                    <i class="fa-solid fa-print"></i>
                                                    </a>';
                                                }else{
                                                    echo "";
                                                }
                                            ?>
                                                            <td><?php echo $btnPrint?></td>
                                                            <td><?= $ventas['idventa']?></td>
                                                            <td><?php
                                                if($ventas['tipocomprobante'] == 3){
                                                    echo "TICKET";
                                                }else if($ventas['tipocomprobante'] == 1){
                                                    echo "FACTURA";
                                                }else if($ventas['tipocomprobante'] == 2){
                                                    echo  "BOLETA";
                                                }else{
                                                    echo "SIN COMPROBANTE";
                                                }
                                            ?>
                                                            </td>
                                                            <td><?php
                                                if($ventas['tipocomprobante'] == 3){
                                                    echo "";
                                                }else if($ventas['tipocomprobante'] == 1){
                                                    echo $ventas['serie_factura'];
                                                }else if($ventas['tipocomprobante'] == 2){
                                                    echo $ventas['serie_boleta'];
                                                }else{
                                                    echo "SIN COMPROBANTE";
                                                }
                                            ?>
                                                            </td>

                                                            <td><?= $ventas['usuario']?></td>
                                                            <td><?= $ventas['fecha']?></td>
                                                            <td><?= $ventas['descripcion']?></td>

                                                            <?php
                                            foreach ($totales as $tot) {
                                                $query_parcial = "SELECT SUM(monto) as parcial FROM venta_medio_pago where id_venta = '" . $ventas['idventa'] . "'  AND  mediopago = '" . $tot["idmediopago"] . "'";
                                                
                                                $r_parcial = $con->listar($query_parcial);
                                                
                                                foreach($r_parcial as $row){
                                                    echo "<td>";
                                                    echo number_format(floatval($row['parcial']), 2, '.', ' ');
                                                    echo "</td>";
                                                }
                                            }
                                            ?>

                                                            <td><?php echo number_format(floatval(($ventas['total']/110)*100), 2, ".", "") ?>
                                                            </td>
                                                            <td><?php echo number_format(floatval(($ventas['total']/110)*10), 2, ".", "") ?>
                                                            </td>
                                                            <td><?php echo number_format(floatval(($ventas['total'])), 2, ".", "") ?>
                                                            </td>
                                                            <td><?= $ventas['estado']?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
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
            window.location.href = base_url + "/reports/sales?fecha_inicio=" + $('#fechainicio').val() +
                "&fecha_fin=" + $('#fechafin').val();
        }
        </script>


        <?php footerAdmin($data); ?>