<?php headerAdmin($data); ?>
<link href="<?= media();?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

<main>
    <div class="d-flex-footer">
        <a href="<?= base_url(); ?>/users" style="color:black;" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="card" style="border: 1px solid transparent">
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <select class="inputfila" class="form-control" id="tipoDoc" name="tipoDoc">
                                <option>Efectivo</option>
                                <option>Visa</option>
                                <option>Mastercard</option>
                                <option>Transferencia</option>
                                <option>Yape</option>
                                <option>Lukita</option>
                                <option>Ruc</option>
                                <option>Plin</option>
                            </select>
                        </div>
                        <div class="col">
                            <input class="inputfila" type="text" min="0" class="form-control input-lg" name="montooId" placeholder="Monto" required>
                        </div>


                    </div>
                    <br>
                    <div class="col">

                        <textarea type="text" class="form-control" id="nombreHabitacion" name="nombreHabitacion" placeholder="Descripcion"></textarea>

                    </div>

                    <div class="form-check form-switch" style="margin-top:5px;">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Generar impresión</label>
                    </div>
                    <br>


                    <div class="row">
                        <div class="col">
                            <th>Subtotal</th>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <th>IGV (10%)</th>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <th>Total vendido</th>
                        </div>
                    </div>
                    <br>




                    <br>
                    <div class="col-md-4">
                        <div>
                            <button style="width: 150px; padding: 5px 20px 5px 20px; margin:8px" id="btnActionForm" class="buven">Nota venta</button>
                        </div>
                        <div>
                            <button style="width: 150px; padding: 5px 20px 5px 20px;margin:8px" id="btnActionForm" class="buven">Boleta</button>
                        </div>
                        <div>
                            <button style="width: 150px; padding: 5px 20px 5px 20px;margin:8px" id="btnActionForm" class="buven">Factura</button>
                        </div>
                        <div>
                            <button style="width: 150px; padding: 5px 20px 5px 20px;margin:8px" id="btnActionForm" class="zpta">Cancelar</button>
                        </div>
                    </div>

                    <br>



                </div>



            </div>
        </div>


        <div class="col-sm-5">
            <div class="card" style="border:1px solid transparent">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" style="color:black">Item</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false" style="color:black">Cliente</button>
                        </div>
                    </nav>


                    <div class="tab-content" id="nav-tabContent" >
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <br>
                            <div class="form-group">
                                
                                <div class="row">
                                    <div class="col-xs-8 pull-right">
                                        <div style="text-align:center">
                                        <i class="fa-solid fa-face-frown fa-2x" style="color: #0F4B81;"></i>
                                        <p >Ningún ítem seleccionado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <br>
                            <div class="row">

                                <div class="col">
                                        
                                    <select class="inputfila" class="form-control" id="tipoDoc" name="tipoDoc">
                                        <option>DNI</option>
                                        <option>Pasaporte</option>
                                        <option>Ruc</option>
                                        <option>Carnet Ext.</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input class="inputfila" type="text" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Nº Doc:" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <br>
                                    <input type="text" class="inputfila" class="form-control input-lg" name="nuevoCliente" placeholder="Nombres" required>
                                </div>
                                <div class="col">
                                    <br>
                                    <input type="text" class="inputfila" class="form-control input-lg" name="nuevoCliente" placeholder="Apellidos" required>
                                </div>
                            </div>

                        
                        </div>
                    </div>

                </div>
            </div>
            <br>

            <div class="col-sm-12">
                <div class="card" style="border:1px solid transparent">
                    <br>
                    <div class="col-md-2">
                        <div class="box-footer" style="margin-left:40px; margin-right:50px; width:200px">

                            <button style="padding-left: 60px; padding-right:70px" id="btnActionForm" class="buven">Pagar</button>
                        </div>
                        <div class="box-footer" style="width:200px">

                            <button style="padding-left: 60px; padding-right:40px" id="btnActionForm" class="zpta">Consumo</button>
                        </div>
                    </div>
                    <br>
                </div>



            </div>
        </div>



    </div>

</main>
<?php footerAdmin($data); ?>
<script src="<?= media();?>/plugins/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= media();?>/js/popper.min.js" crossorigin="anonymous"></script>
<script src="<?= media();?>/plugins/bootstrap/js/bootstrap.min.js" crossorigin="anonymous"></script>