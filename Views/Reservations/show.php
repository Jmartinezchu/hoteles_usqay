<?php headerAdmin($data); ?>
<style>
  .card-venta {
    display: flex;
    align-items: center;
    border-bottom: 1px solid #f0f0f0;
  }

  .card-venta button {
    background: #00395E;
    border-radius: 5px;
    color: #fff;
    font-size: .8rem;
    padding: .5rem;
    border: 1px solid #00395E;


  }
</style>

<main>
  <?php require_once("Libraries/Core/Open.php") ?>

  <div class="d-flex-footer">
    <a href="<?= base_url(); ?>/reservations" style="color:black;" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
  </div>
  <?php

  $idreservacion = $_REQUEST['id'];
  $con = new Mysql();
  $reservacion = "SELECT r.total, u.nombres,u.identificacion, h.nombre_habitacion, h.capacidad, o.nombre, re.nombre as estado,DATE_FORMAT(r.fecha_inicio,'%d %M.%Y') as inicio, DATE_FORMAT(r.fecha_fin,'%d %M.%Y') as fin FROM reservaciones r INNER JOIN origen_reservacion o ON r.reservacion_origen_id = o.idorigen_reservacion INNER JOIN reservaciones_estados re ON r.reservacion_estado_id = re.id_reservacionestado INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion INNER JOIN usuario u ON r.cliente=u.idusuario WHERE r.id_reservacion = $idreservacion";
  $request_reservacion = $con->buscar($reservacion);

  $pagos_reservacion = "SELECT *, SUM(total) as monto_pagado FROM reservaciones_payments WHERE reservacionid = $idreservacion ";
  $request_pagos_reservacion = $con->buscar($pagos_reservacion);

  // var_dump($request_pagos_reservacion['monto_pagado']);
  $fecha_inicio = $request_reservacion['inicio'];
  $fecha_fin = $request_reservacion['fin'];

  $dateDiference = abs(strtotime($fecha_fin) -  strtotime($fecha_inicio));
  $years = floor($dateDiference / (365 * 60 * 60 * 24));
  $months = floor(($dateDiference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
  $days = floor(($dateDiference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

  // var_dump($request_reservacion);

  ?>
  <form id="formReservationPayment" name="formReservationPayment">
    <div class="columns" style="margin-left: 120px;">
      <div class="izq">
        <input type="hidden" id="idUser" name="idUser" value="<?= $_SESSION['idUser'] ?>">
        <h4><input type="hidden" id="idReservacion" name="idReservacion" value="<?= $idreservacion ?>">Reservación #<?php echo $idreservacion ?></h4>
        <br>
        <p><b style="color:grey">Ingreso</b> <small style="margin-left:180px"><?= $fecha_inicio ?></small></p>
        <p><b style="color:grey">Salida</b> <small style="margin-left:190px"><?= $fecha_fin ?></small></p>
        <p><b style="color:grey">Tiempo de estadía</b> <small style="margin-left:165px"><?= $days . ' dia(s)' ?></small></p>
        <p><b style="color:grey">Titular</b> <small style="margin-left:120px"><?= $request_reservacion['nombres'] ?></small></p>
        <p><b style="color:grey">Origen</b> <small style="margin-left:264px">Directa</small></p>
        <p><b style="color:grey">Estado</b> <small style="margin-left:247px"><?= $request_reservacion['estado'] ?></small></p>
        <hr>
        <h4>Habitación</h4>
        <br>
        <tr class="filas" id="fila'+cont+'">
          <td><input type="hidden" value="'+idhabitacion+'"><b style="color:grey">HABITACION <?= $request_reservacion['nombre_habitacion'] ?> - CAPACIDAD <?= $request_reservacion['capacidad'] ?></b><input type="hidden" id="precio" value=""></td>
          <td></td>
        </tr>

        <hr>
        <h4>Pagos</h4>
        <br>
        <p><b style="color:grey">Total por alquiler <small style="margin-left:175px">S/. <?= formatMoney($request_reservacion['total']) ?></small></b></p>

        <p><b style="color:grey">Total cancelado <small style="margin-left:180px">S/. <?= formatMoney($request_pagos_reservacion['monto_pagado']) ?></small></b></p>
        <hr>
        <h4>Consumos</h4>
        <br>
        <?php
        $sql = "SELECT * FROM consumos WHERE reservaid = $idreservacion";
        $request_consumo = $con->buscar($sql);
        // var_dump($request_consumo['total_consumo']);
        if (empty($request_consumo['total_consumo'])) :
        ?>
          <p><b style="color:grey">Ningun consumo registrado</b></p>
        <?php else : ?>
          <p><b style="color:grey">Total consumo <small style="margin-left: 180px"> S/. <?= formatMoney($request_consumo['total_consumo']) ?></small></b></p>
        <?php endif; ?>
        <br>
        <?php $reservacion = $_REQUEST['id'];
        $sql_payment = "SELECT * FROM reservaciones_payments WHERE reservacionid = $reservacion";
        $request_sql_payment = $con->buscar($sql_payment);  ?>
        <!-- <div class="col-md-2" style="margin-left: 120px">
                    <button disabled id="btnActionForm" class="btn-usqay"><i class="fa fa-add"></i> <span id="btnText">
                      <?php
                      if ($request_sql_payment > 0) {
                        echo 'PAGADO';
                      } else {
                        echo 'PAGO PENDIENTE';
                      }
                      ?>
                    </span></button>&nbsp;
            </div> -->
      </div>
      <div class="der">
        <h4><b style="color:grey">Registro de Pago</b></h4>
        <hr>
        <div style="display:flex">
          <p><b><i class="fa-solid fa-user"></i> <?= $request_reservacion['nombres'] ?></b></p>
        </div>
        <hr>
        <h4><b style="color:grey">Información de Pago</b></h4>
        <br>
        <div class="col-md-12" style="display:flex;justify-content:center">
          <div class="col-md-3">
            <h4>Montos totales</h4>
            <p>
              <?php
              if (empty($request_consumo['total_consumo'])) {
                $total_consumo = 0;
              } else {
                $total_consumo = $request_consumo['total_consumo'];
                // var_dump($total_consumo);exit;

              }
              $monto_total = $request_reservacion['total'] + $total_consumo;
              ?>
              <b style="color:grey">S/. <?= formatMoney($monto_total) ?></b>
            </p>
          </div>
          <div class="col-md-3">
            <h4>Monto ingresado</h4>
            <p><b style="color:grey">S/. <?= formatMoney($request_pagos_reservacion['monto_pagado']) ?></b></p>
            <!-- <p><b style="color:grey" id="monto_ingresado"></b></p> -->
          </div>
          <div class="col-md-3">
            <h4 style="color:#FBBABA">Monto faltante</h4>
            <?php
            $monto_faltante = $monto_total - $request_pagos_reservacion['monto_pagado'];
            if ($monto_faltante < 0) :
            ?>
              <p><b style="color:#FBBABA">S/. <?= formatMoney(0) ?></b></p>
            <?php else : ?>
              <p><b style="color:#FBBABA">S/. <?= formatMoney($monto_faltante) ?></b></p>
            <?php endif; ?>
          </div>
        </div>
        <br>

        <div style="display:flex">
          <!-- <input onkeydown="pulse(event)" type="text" id="total" name="total" class="inputfila" value="<?= formatMoney($request_reservacion['total']) ?>"> &nbsp;&nbsp; -->
          <input onkeydown="pulse(event)" type="hidden" id="total_reserva_pago" class="inputfila" placeholder="Monto" value="<?= formatMoney($request_reservacion['total']) ?>">
          <input style="width:200px" type="text" id="monto" class="inputfila" placeholder="Monto"> &nbsp;&nbsp;
          <!-- <input  onkeydown="pulse(event)" type="text" id="adelanto"  class="inputfila" placeholder="Paga con"> -->
          <div style="margin-left:160px; width:30%">
            <select width="100px" class="inputfila" data-live-search="true" id="medio_pago" name="medio_pago" placeholder="Medio pago" style="margin-left:-140px; width:200px">
            </select>
          </div>
          <button onclick="agregarPago();" type="button" id="btnAgregarPago" style="background-color: #00395E; color:white; border-radius:5px;margin-left:-200px; width:30%; border: #00395E; width:100px">
            AGREGAR
          </button>
        </div>
        <br>
        <div style="display:none" id="tablamediopago">
          <div class="table-responsive">
            <table id="detalles" width="100%" style="text-align:center">
              <thead style="background-color:  #00395E;">
                <th style="text-align:center; color: white; padding: 3px 0px 3px 0px;">OPCIONES</th>
                <th style="text-align:center; color: white; padding: 3px 0px 3px 0px;">MEDIO DE PAGO - MONEDA SOLES</th>
                <th style="text-align:center; color: white; padding: 3px 0px 3px 0px;"></th>
                <th style="text-align:center; color: white;  padding: 3px 0px 3px 0px;">MONTO</th>
              </thead>
              <tbody style="text-align:center;">

              </tbody>
              <tfoot>
                <input style="width:200px" type="hidden" id="total_pago" name="total_pago" class="inputfila"> &nbsp;&nbsp;
                <!-- <input style="width:200px"  type="text" id="total_venta" name="total_venta" class="inputfila"> &nbsp;&nbsp; -->
              </tfoot>


            </table>
          </div>
        </div>
        <br>
        <input type="text" id="descripcion" name="descripcion" class="inputfila" placeholder="Descripcion">
        <br><br>
        <div id="div_descuento" style="display: none;">
          <input onkeyup="calcularPago()" onkeydown="pulse(event)" type="text" id="valor_descuento" class="inputfila" placeholder="Descuento">
        </div>
        <br><br>

        <div style="display:flex">
          <label><input type="checkbox" value="first_checkbox" checked> Generar impresión </label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="checkbox" id="descuento" value="first_checkbox"> Descuento </label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="checkbox" id="descuento" value="first_checkbox"> Detraccion </label><br>
        </div>


        <br>
        <!-- <div class="card-venta" style="text-align:center">
            <?php
            if ($request_sql_payment > 0) :
            ?>
            <div id="botonesArturo" style="display:none">

            </div>
            <?php else : ?>
              <div id="botonesArturo" >

               </div>
               <button onclick="cancelarForm();" type="button" id="btnCancelar" >
                    <i class="fa fa-times-circle"></i> ANULAR</button>
            <?php endif; ?>
          </div> -->
        <div class="card-venta" style="text-align:center">

          <?php
          if ($request_reservacion['total'] > $request_pagos_reservacion['monto_pagado']) :
          ?>
            <div id="botonesArturo">

            </div>
          <?php endif; ?>
          <button onclick="cancelarForm();" type="button" id="btnCancelar">
            <i class="fa fa-times-circle"></i> ANULAR</button>

        </div>
        <br>

        <!-- 
          <?php

          if ($request_sql_payment > 0) {
            echo '<h3>Total pagado S/.' . $request_sql_payment['total'] . ' </h3>';
          }
          ?> -->
      </div>
    </div>
  </form>

</main>

<script>
  $('#descuento').click(function() {
    document.getElementById("descuento").checked = true;
    let div_descuento = document.getElementById("div_descuento");
    div_descuento.style.display = 'flex';
  })

  function calcularPago() {
    let valor_descuento = document.getElementById("valor_descuento").value;
    let total_reserva = document.getElementById("total_reserva_pago").value;
    let total = document.getElementById("total");
    var ecuacion, text;
    if (valor_descuento != '') {
      ecuacion = parseFloat(total_reserva) - parseFloat(valor_descuento);
      text = ecuacion;
      total.value = text + ',00';
    }

  }
</script>
<?php footerAdmin($data); ?>