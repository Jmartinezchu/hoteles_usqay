<?php
 
   headerAdmin($data);
 ?>
<main>
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
                                    <li class="breadcrumb-item active">Cajas</li>
                                    <li class="breadcrumb-item active">Crear</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Crear Caja</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->


                        <div class="card">
                            <div class="card-body">
                            <form id="formCaja" name="formCaja">
                                <div class="row">
                                    <input type="hidden" id="idCaja" name="idCaja">
                                    <div class= "col-lg 12">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre:</label>
                                            <input type="text" id="nombre_caja" class="form-control" placeholder="Nombre de caja"
                                            name="nombre_caja">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 12">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Ubicación:</label>
                                            <input type="text" id="ubicacion" class="form-control" placeholder="Ubicación de caja"
                                            name="ubicacion">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 12">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Descripción:</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Descripción de caja"
                                            name="descripcion">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarCaja()"><span id="btnText">Guardar</span></button>&nbsp;
                                    <button type="button" id="btnCancelar" class="btn btn-light" data-dismiss="modal" onclick="cancelar()">Cancelar</button>
                                </div>
                            </form>    
                        </div>
             
            </div>
        </div>
    </div>
</div>
</main>
<?php footerAdmin($data); ?>