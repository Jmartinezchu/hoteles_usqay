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
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
    <form id="formAlmacen">
    <input type="hidden" id="idAlmacen" name="idAlmacen" value="">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-body">
                            <!-- <h4>
                                <strong >Crear Habitación: </strong><span id="total" class="text-dark"></span><input type="hidden" name="total_venta" id="total_venta" style="height=">
                                
                            </h4>
                            <br> -->
                                <div class="row">
                                <h4 class="page-title">Crear Almacen</h4>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre:</label>
                                            <input type="text" id="nombre" class="form-control" placeholder="Nombre almacen" name="nombre">
                                        </div>
                                    </div>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Ubicación:</label>
                                            <input type="text" id="ubicacion" class="form-control" placeholder="Ubicación almacen" name="ubicacion">
                                        </div>
                                    </div>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-palaceholder" class="form-label">Descripcion:</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Descripcion" name="descripcion">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarAlmacen()"><span id="btnText">Guardar</span></button>&nbsp;
                                    <button type="button" id="btnCancelar" class="btn btn-light" data-dismiss="modal" onclick="cancelar()">Cancelar</button>
                                </div>
                            </div>
            </div><!-- end col-->
        </div>
    </form>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="card-header">
                        <div class="tab-content">         
                            <div class="table-responsive">
                                <table id="tableAlmacen" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Ubicacion</th>
                                        <th>Descripcion</th>
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