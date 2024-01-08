<?php headerAdmin($data); getModal("modalReservaciones", $data);

?>

<main>
    <div class="columns">
        <div class="izq">
            <p>Tiempo de estadia: <small id="tiempo_estadia"> 3 horas(s)</small> </p>
            <br>
            <div class="fila" class="col-md-4">
                <input class="inputfila" type="datetime-local" class="form-control" placeholder="Ingreso" id="ingreso" name="ingreso" value="<?php echo date("Y-m-d H:i"); ?>">
            </div>
            <div class="fila" class="col-md-4">
                <input class="inputfila" type="datetime-local" class="form-control" placeholder="Salida" id="salida" name="salida">
            </div>
            <div class="fila" class="col-md-4">
                <select class="inputfila" data-live-search="true" id="origen_reserva" name="origen_reserva"></select>
            </div>
            <br>
            <p>Huespedes:</p>
            <br>
            <div class="col-md-2">
                <div>
                      <select class="inputfila" id="tipo_documento" name="tipo_documento" >
                                <option value="1">DNI</option>
                                <option value="2">RUC</option>
                                <option value="3">Carnet Ext.</option>
                                <option value="4">Pasaporte</option>
                      </select>
                </div>
                <div>
                    <input onkeyup="searchHuesped()" class="inputfila" type="text" class="form-control" placeholder="N° Doc." id="documento" name="documento">
                </div>
                
                <div style="padding-top:10px">
                    <input class="inputfila" type="text" class="form-control" placeholder="Nombres" id="nombres" name="nombres">
                </div>
                <div style="padding-top:10px">
                    <input class="inputfila" type="text" class="form-control" placeholder="Apellidos" id="apellidos" name="apellidos">
                </div>
              
            </div>
             
                <div style="padding-top:10px">
                    <input class="inputfila" type="email" class="form-control" placeholder="Correo" id="correo" name="correo">
                </div>
                <br>
                <p>Habitaciones: </p>
                <br>
                <div>
                    <?php 
                      $total = 0;
                      if(isset($_SESSION['arrReservationRoom']) and count($_SESSION['arrReservationRoom']) > 0){
                    ?>

                    <?php 
                        foreach($_SESSION['arrReservationRoom'] as $room){
                    ?>
                     <div id="<?= $room['idhabitacion']?>" onclick="delRoom(this)">
                        <h4><?= $room['nombre_habitacion'] ?></h4>
                        <p>S/. <?= $room['precio_dia']?></p>
                     </div>
                     
                    <?php } ?>

                    <?php } ?>
                    <p>Ninguna habitación seleccionada</p>
                </div>
                <br>
                <hr>
                <div class="col-md-2" style="margin-left: 120px">
                        <button id="btnActionForm" class="btn-usqay"><i class="fa fa-save"></i> <span id="btnText">Reservar</span></button>&nbsp;
                </div>
        </div>

        <div class="der">
            <div class="col-md-3">
                <select class="inputfila" id="categoria" name="categoria">
                </select>
                <br>
            </div>
            <div class="col-md-3" id="foodrooms">
               <?php
                   if(count($data['rooms']) > 0){
                     foreach($data['rooms'] as $room) {
                   
               ?>
                
                <a href="#" class="reservar" id="<?= $room['idhabitacion']  ?>">
                    <input type="hidden" id="idroom" name="idroom" value="<?= $room['idhabitacion'] ?>">
                    <p>Habitacion <?= $room['nombre_habitacion'] ?></p>
                    <p><i class="fa fa-users" aria-hidden="true"></i> <?= $room['capacidad']?></p>
                </a>
                <?php }
                   }
                ?>
            </div>
            <div class="col-md-3" id="foo">
                
            </div>
        </div>
    </div>
</main>


<script>
    var now = new Date();
    var day =("0"+now.getDate()).slice(-2);
    var month=("0"+(now.getMonth()+1)).slice(-2);
    var hour = now.getHours();
    var minutes = now.getMinutes();
    var today=now.getFullYear()+"-"+(month)+"-"+(day)+" "+(hour)+":"(minute);
    $("#ingreso").val(today);
   
</script>
<?php footerAdmin($data); ?>