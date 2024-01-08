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
                            <li class="breadcrumb-item active">Movimiento</li>
                        </ol>
                    </div>
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
                            <form id="formMovimiento" name="formMovimiento">
                                <div class="row">
                                <h4 class="page-title">Crear Movimiento</h4>
                                <input type="hidden" id="idmovimiento" name="idmovimiento">
                                    <div class="col-lg 3">
                                        <label for="example-select" class="form-label">Movimiento:</label>
                                        <select class="form-select" id="tipo_movimiento" name="tipo_movimiento">
                                            <option value="1">Ingreso</option>
                                            <option value="2">Salida</option>
                                        </select>
                                    </div>
                                    <div class="col-lg 3">
                                        <label for="example-select" class="form-label">Almacenes:</label>
                                        <select class="form-select" data-live-search="true" id="almacenes" name="almacenes">
                                        </select>
                                    </div>

                                    <div class="col-lg 3">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Descripción:</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Descripción" name="descripcion">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarStoreHouseMovement()"><span id="btnText">Guardar</span></button>&nbsp;
                                        <button type="button" id="btnCancelar" class="btn btn-light" data-dismiss="modal" onclick="cancelar()">Cancelar</button>
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
                                <table id="tableMovimiento" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo movimiento</th>
                                            <th>Almacen</th>
                                            <th>Motivo</th>
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
<!-- <script src="../public/js/JsBarcode.all.min.js"></script>
 <script src="../public/js/jquery.PrintArea.js"></script>  -->




<?php footerAdmin($data); ?>