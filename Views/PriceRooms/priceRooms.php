<?php headerAdmin($data); ?>



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
                                    <li class="breadcrumb-item active">Tarifas</li>
                                    <li class="breadcrumb-item active">Crear</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <form id="formPriceRooms" name="formPriceRooms">
                    <input type="hidden" id="idPrecio" name="idPrecio" value="">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h4 class="page-title">Crear Precios</h4>
                                        <div class="row">
                                            <div class="col-lg 6">
                                                <div class="mb-3">
                                                    <label for="example-select" class="form-label">Habitacion:</label>
                                                    <select class="form-select" data-live-search="true" id="idRoom" name="idRoom">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg 6">
                                                <div class="mb-3">
                                                    <label for="example-select" class="form-label">Tarifa:</label>
                                                    <select class="form-select" data-live-search="true" id="idTarifas" name="idTarifas">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg 6">
                                                <div class="mb-3">
                                                    <label for="example-placeholder" class="form-label">Precio:</label>
                                                    <input onkeyup="this.value=numeros(this.value)" type="text" id="price" class="form-control" placeholder="Ingresar Precio" name="price">
                                                </div>
                                            </div>
                                            <div class="col-lg 6">
                                                <div class="mb-3">
                                                    <label for="example-placeholder" class="form-label">Dias:</label>
                                                    <input onkeyup="this.value=num(this.value)" type="text" id="days" class="form-control" placeholder="Ingresar dia" name="days">
                                                </div>
                                            </div>
                                            <div class="col-lg 6">
                                                <div class="mb-3">
                                                    <label for="example-placeholder" class="form-label">Horas:</label>
                                                    <input onkeyup="this.value=num(this.value)" type="text" id="hours" class="form-control" placeholder="Ingresar horas" name="hours">
                                                </div>
                                            </div>
                                            <div class="col-lg 6">
                                                <div class="mb-3">
                                                    <label for="example-placeholder" class="form-label">Minutos:</label>
                                                    <input onkeyup="this.value=num(this.value)" type="text" id="minutes" class="form-control" placeholder="Ingresar minutos" name="minutes">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarPrecio()"><span id="btnText">Guardar</span></button>&nbsp;
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
                                    <!-- <button onclick="openCreate();" type="submit" class="btn btn-primary mb-2">Crear</button> -->
                                    <div class="tab-content">
                                        <div class="table-responsive">
                                            <table id="tablePriceHabitacion" class="table dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre Habitacion</th>
                                                        <th>Nombre Tarifa</th>
                                                        <th>Precio</th>
                                                        <th>Dias</th>
                                                        <th>Horas</th>
                                                        <th>Minutos</th>
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
            </div> <!-- end tab-content-->

        </div> <!-- end card body-->
    </div> <!-- end card -->
</div><!-- end col-->
</div>

</div> -->
</div>
<!-- content -->
</div>
</div>

<?php footerAdmin($data); ?>