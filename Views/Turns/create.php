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
                                    <li class="breadcrumb-item active">Turnos</li>
                                    <li class="breadcrumb-item active">Crear</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Crear Turno</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->

                <div class="row">
                        <div class="card">
                            <div class="card-body">
                            <form id="formTurns" name="formTurns">
                            <input type="hidden" id="idturno" name="idturno">
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre:</label>
                                            <input type="text" id="nombre_turno" class="form-control" placeholder="Nombre del Turno"
                                            name="nombre_turno">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                            <div class="mb-3">
                                                <label for="example-select" class="form-label">Hora Inicio:</label>
                                                <input type="time" id="hora_inicio" class="form-control" placeholder="Ingresar Hora Inicio"
                                                name="hora_inicio">
                                            </div>
                                        </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Hora Fin:</label>
                                            <input type="time" id="hora_fin" class="form-control" placeholder="Ingresar Hora Fin"
                                            name="hora_fin">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarTurno()" ><span id="btnText">Guardar</span></button>&nbsp;
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