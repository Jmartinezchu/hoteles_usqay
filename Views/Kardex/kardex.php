<?php headerAdmin($data);?>


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
                            <li class="breadcrumb-item active">Almacenes</li>
                            <li class="breadcrumb-item active">Kardex</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <div class="row">
            <div class="col-12">+
                <div class="card">
                <div class="card-body">
                            <!-- <h4>
                            <strong >Crear Habitación: </strong><span id="total" class="text-dark"></span><input type="hidden" name="total_venta" id="total_venta" style="height=">
                            
                            </h4>
                            <br> -->
                            <form id="kardex" name="kardex">
                                <div class="row">
                                <h4 class="page-title">Kardex de Productos</h4>
                                    <div class="col-lg 3">
                                        <!-- <label for="example-select" class="form-label">Movimiento:</label> -->
                                        <select class="form-select" id="almacenes" name="almacenes">
                                        </select>
                                    </div>
                                    <div class="col-lg 3">
                                        <button type="button" class="btn btn-primary" id="btnActionForm" onclick="buscarKardex()">
                                            <i class="dripicons-search">
                                            </i>
                                            <span id="btnText">Buscar</span>
                                        </button>&nbsp;
                                    </div>

                                    

                                </div>
                            </form>    
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
                                <table id="tableKardex" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th>Almacen</th>
                                            <th>Stock</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
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