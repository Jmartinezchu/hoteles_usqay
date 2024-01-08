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
                                    <li class="breadcrumb-item active">Configurar</li>
                                    <li class="breadcrumb-item active">Operaciones diarias</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Operaciones diarias</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->

                <div class="row">
                        <div class="card">
                            <div class="card-body">
                            <form id="formTurnOpening" name="formTurnOpening">
                            <input type="hidden" id="idTurnOpening" name="idTurnOpening">

                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Caja:</label>
                                            <select class="form-select" id="cajas" name="cajas">
                                            </select>
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Turno:</label>
                                            <select class="form-select" id="turnos" name="turnos">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                        <label for="example-placeholder" class="form-label">Monto:</label>
                                            <input type="text" id="monto_inicial" class="form-control" placeholder="Ingresar Monto"
                                            name="monto_inicial" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarOpening()" ><span id="btnText">Guardar</span></button>&nbsp;
                                    <button type="button" id="btnCancelar" class="btn btn-light" onclick="cancelar()">Cancelar</button>
                                </div>
                            </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php footerAdmin($data); ?>