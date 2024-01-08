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
                                    <li class="breadcrumb-item active">Habitaciones</li>
                                    <li class="breadcrumb-item active">Crear</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Crear Habitación</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->

                <div class="row">
                        <div class="card">
                            <div class="card-body">
                            <form id="formHabitacion" name="formHabitacion">
                            <input type="hidden" id="idhabitacion" name="idhabitacion">
                            <!-- <h4>
                                <strong >Crear Habitación: </strong><span id="total" class="text-dark"></span><input type="hidden" name="total_venta" id="total_venta" style="height=">
                                
                            </h4>
                            <br> -->
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre:</label>
                                            <input type="text" id="nombre" class="form-control" placeholder="Nombre de la habitación"
                                            name="nombre">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Categoría:</label>
                                            <select class="form-select" data-live-search="true" id="categoria" name="categoria">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Estado:</label>
                                            <select class="form-select" id="estado" name="estado">
                                                <option value="Disponible">Disponible</option>
                                                <option value="Ocupada">Ocupada</option>
                                                <option value="Disponible">Mantenimiento</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Capacidad:</label>
                                            <input onkeyup="this.value=numeros(this.value)" type="text" id="capacidad" class="form-control" placeholder="Capacidad de la habitación"
                                            name="capacidad">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Descripción:</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Descripción de la habitación"
                                            name="descripcion">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Piso:</label>
                                            <select class="form-select" data-live-search="true" id="piso" name="piso">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarHabitacion()" ><span id="btnText">Guardar</span></button>&nbsp;
                                    <button type="button" id="btnCancelar" class="btn btn-light" onclick="cancelarHabitacion()">Cancelar</button>
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