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

$sql = "SELECT dc.id_detalle_consumo, dc.cantidadActual, dc.precio_venta, p.nombre, dc.cantidadConsumoDesechado, dc.descripcionConsumoDesechado, dc.created_at FROM detalle_consumo dc inner join producto p on p.idProducto = dc.idarticulo WHERE p.nombre != 'SERVICIO DE HOSPEDAJE' AND dc.reservaid = ".$_GET['id'];

$request_sql = $con->listar($sql);

$reservaid = $_GET['id'];

var_dump($reservaid);
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
                    <h4 class="page-title">Reporte de detalle consumos</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="card-header">
                        <div class="tab-content">         
                            <div class="table-responsive">
                                <table id="tableConsumos" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th># </th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Venta</th>
                                            <th>Fecha</th>
                                            <th>Productos desechados</th>
                                            <th>Motivo</th>
                                            <th>Total Perdido</th>
                                            <th>Subtotal</th>
                                            <th>IGV </th>
                                            <th>Total </th>
                                        </tr>
                                    </thead>
                                                
                                    <tbody style="text-align: center;">
                                    <?php 
                                        foreach($request_sql as $list):

                                    ?>
                                        <tr>
                                            <td><?= $list['id_detalle_consumo']?></td>
                                            <td><?= $list['nombre']?></td>
                                            <td><?= $list['cantidadActual']?></td>
                                            <td><?= $list['precio_venta']?></td>
                                            <td><?= $list['created_at']?></td>
                                            <td><?= $list['cantidadConsumoDesechado']?></td>
                                            <td><?= $list['descripcionConsumoDesechado']?></td>
                                            <td><?= number_format($list['precio_venta'] * $list['cantidadConsumoDesechado'],2)?></td>
                                            <td><?=number_format(((($list['precio_venta'] * $list['cantidadActual'])/110)*100), 2, ".", "")?></td>
                                            <td><?=number_format(((($list['precio_venta'] * $list['cantidadActual'])/110)*10), 2, ".", "")?></td>
                                            <td><?=number_format($list['precio_venta'] * $list['cantidadActual'],2)?></td>
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

<?php footerAdmin($data); ?>