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
                            <li class="breadcrumb-item active">Servicio</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                <form id="formProducto" name="formProducto">
                    <input type="hidden" id="idProducto" name="idProducto">
                    <input type="hidden" id="uni_de_medida" name="uni_de_medida" value="ZZ">
                <div class="card-body">
                            <!-- <h4>
                                <strong >Crear Habitación: </strong><span id="total" class="text-dark"></span><input type="hidden" name="total_venta" id="total_venta" style="height=">
                                
                            </h4>
                            <br> -->
                                <div class="row">
                                <h4 class="page-title">Crear Servicio</h4>
                                    <div class="col-lg 3">
                                        <label for="example-select" class="form-label">Categoria:</label>
                                        <select class="form-select" data-live-search="true" id="codecategoria" name="codecategoria">
                                        </select>
                                    </div>
                                    <div class="col-lg 3">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre servicio:</label>
                                            <input type="text" id="nombre" class="form-control" placeholder="Nombre" name="nombre">
                                        </div>
                                    </div>
                                    <div class="col-lg 3">
                                        <label for="example-select" class="form-label">Código:</label>
                                        <select class="form-select" data-live-search="true" id="codesunat" name="codesunat">
                                        </select>
                                    </div>
                                    <div class="col-lg 3">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Precio venta:</label>
                                            <input onkeyup="this.value=numeros(this.value)" type="text" id="precio_venta" class="form-control" placeholder="Precio" name="precio_venta">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarProductos()"><span id="btnText">Guardar</span></button>&nbsp;
                                    <button type="button" id="btnCancelar" class="btn btn-light" data-dismiss="modal" onclick="cancelar()">Cancelar</button>
                                </div>
                            </div>
                            </form>
            </div><!-- end col-->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="card-header">
                        <div class="tab-content">         
                            <div class="table-responsive">
                                <table id="tableProductos" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Categoria</th>
                                            <th>Sunat</th>
                                            <th>Nombre</th>
                                            <th>Precio venta</th>
                                            <th>Estado</th>
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