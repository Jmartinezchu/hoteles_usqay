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
                            <li class="breadcrumb-item active">Detalle</li>
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
                            <form id="formDetalleMovimiento" name="formDetalleMovimiento">
                            <input type="hidden" id="detallemovimiento" name="detallemovimiento">
                            <input type="hidden" id="idmovimiento" name="idmovimiento" value="<?php echo $_GET['id'] ?>">
                            <input type="hidden" id="almacenid" name="almacenid" value="<?php echo $_GET['almacen'] ?>">
                            <input type="hidden" id="usuario" name="usuario" value="<?= $_SESSION['userData']['nombres']?>">
                                <div class="row">
                                <h4 class="page-title">Agregar producto</h4>
                                    <div class="col-lg 3">
                                        <label for="example-select" class="form-label">Producto:</label>
                                        <select class="form-select" data-live-search="true" id="productos" name="productos" placeholder="Seleccionar Producto">
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Cantidad:</label>
                                            <input onkeyup="this.value=numeros(this.value)" type="text" id="cantidad" class="form-control" placeholder="Ingresar Cantidad" name="cantidad">
                                        </div>

                                    <div class="col-lg 3">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Descripción:</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Descripción" name="descripcion">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarDetailMovement()"><span id="btnText">Guardar</span></button>&nbsp;
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
                                <table id="tableDetalleMovimiento" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Descripcion</th>
                                        <th>Fecha</th>
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