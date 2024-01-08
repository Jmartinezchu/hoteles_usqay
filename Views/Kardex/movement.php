<?php headerAdmin($data);
getModal("modalEditTurns",$data);
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
                                            <li class="breadcrumb-item active">Almacen</li>
                                            <li class="breadcrumb-item active">Kardex</li>
                                            <li class="breadcrumb-item active">Movimientos</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detalle de movimiento de productos</h4>
                                </div>
                            </div>
        </div>     
        <!-- end page title -->

        <div class="row">

                            <div class="col-12">
                                
                                <div class="card">
                                    
                                
                                    <div class="card-body">
                                    <input type="hidden" id="kardex" name="kardex" value="<?php echo $_GET['id'] ?>">
                                    <input type="hidden" id="productoid" name="productoid" value="<?php echo $_GET['productoid'] ?>">
                                    <div class="card-header">
                                        <div class="tab-content">
                                        
                                            <div class="table-responsive">
                                                <table id="tableKardexSeguimiento" class="table dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                        <th>Almacen</th>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Total</th>
                                                        <th>Tipo Movimiento</th>
                                                        <th>Fecha</th>
                                                        <th>Descripcion</th>
                                                        </tr>
                                                    </thead>
                                                
                                                    <tbody >
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