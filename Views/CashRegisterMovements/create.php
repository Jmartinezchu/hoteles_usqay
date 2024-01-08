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
                                    <li class="breadcrumb-item active">Movimientos</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Movimiento de caja</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->


                        <div class="card">
                            <div class="card-body">
                            <form id="formMovementCash" name="formMovementCash">
                                <div class="row">
                                    <input type="hidden" id="idmovementcash" name="idmovementcash">
                                    <input type="hidden" id="usuarioid" name="usuarioid" value="<?= $_SESSION['userData']['idusuario'] ?>">
                                    <input type="hidden" id="turnoid" name="turnoid" value="<?php  $number = 1; echo $number ?>">
                                    <div class= "col-lg 6">
                                            <div class="mb-3">
                                                <label for="example-select" class="form-label">Tipo de Movimiento:</label>
                                                <select class="form-select" data-live-search="true" id="tipo_movimiento" name="tipo_movimiento">
                                                </select>
                                            </div>
                                        </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Caja:</label>
                                            <select class="form-select" data-live-search="true" id="cajas" name="cajas">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Moneda:</label>
                                            <select class="form-select" data-live-search="true" id="moneda" name="moneda">
                                            </select>
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Metodo de Pago:</label>
                                            <select class="form-select" data-live-search="true" id="metodo_pago" name="metodo_pago">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Monto:</label>
                                            <input onkeyup="this.value=numeros(this.value)" type="text" id="monto" class="form-control" placeholder="Ingrese Monto"
                                            name="monto">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Descripcion:</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Ingrese descripcion"
                                            name="descripcion">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarMovimiento()"><span id="btnText">Guardar</span></button>&nbsp;
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