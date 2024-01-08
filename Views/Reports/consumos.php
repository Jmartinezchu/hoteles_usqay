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

$sql = "SELECT c.idconsumo, c.reservaid, r.total as total_consumo, h.nombre_habitacion, c.created_at FROM consumos c inner join reservaciones r on r.id_reservacion = c.reservaid inner join habitacion h on h.idhabitacion = r.habitacion_id GROUP BY c.reservaid";


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
                            <li class="breadcrumb-item active">Reportes</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Reporte de Consumos</h4>
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
                                <table id="tableConsumos" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th># Reservacion</th>
                                            <th>Habitacion</th>
                                            <th>Fecha</th>
                                            <th>Subtotal</th>
                                            <th>IGV</th>
                                            <th>Total</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                                
                                    <tbody style="text-align: center;">
                                    <?php 
                                        foreach($request_sql as $list):
                                    ?>
                                        <tr>
                                            <td><?= $list['reservaid']?></td>
                                            <td><?= $list['nombre_habitacion']?></td>
                                            <td><?= $list['created_at']?></td>
                                            <td><?= number_format((($list['total_consumo']/110)*100), 2)?></td>
                                            <td><?= number_format((($list['total_consumo']/110)*10), 2)?></td>
                                            <td><?= number_format($list['total_consumo'], 2)?></td>
                                            <td>
                                            <a style="border:none; background:transparent; cursor:pointer;" href="<?= base_url(); ?>/reports/detallesconsumos?id=<?= $list['reservaid'] ?>" title="Ver detalle">Ver detalle</a>&nbsp;
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
        window.location.href = base_url+"/reports/consumos?fecha_inicio=" + $('#fechainicio').val() + 
            "&fecha_fin="+ $('#fechafin').val();
    }
</script>


<?php footerAdmin($data); ?>