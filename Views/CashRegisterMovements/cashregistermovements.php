<?php headerAdmin($data);
getModal("modalEditReservations",$data);?>
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
                                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Dashboard/dashboard">Inicio</a></li>
                                            <li class="breadcrumb-item active">Cajas</li>
                                            <li class="breadcrumb-item active">Movimientos</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Movimientos</h4>
                                </div>
                            </div>
        </div>     
        <!-- end page title -->

        <div class="row">

            <div class="col-12">
                                
                <div class="card">
                                    
                                
                    <div class="card-body">
                                    
                    <div class="card-header">
                    <button onclick="openCreate();" type="submit" class="btn btn-primary mb-2">Crear</button>
                        <div class="tab-content">
                                        
                            <div class="table-responsive">
                                <table id="tableCashRegisterMovements" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th>Total</th>
                                        <th></th>
                                        </tr>
                                    </thead>
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