<?php 
  // getModal("modalEstadia", $data); 
  headerAdmin($data);
  getModal("modalHospedarConsumo", $data); 
  getModal("modalDesecharConsumo",$data);
  getModal("modalEstadia",$data);
  require_once("Libraries/Core/Mysql.php");
?>
<?php
$con = new Mysql();

$pisoUno = "SELECT * FROM piso_habitacion WHERE idpiso = 1";
$requestPisoUno = $con->buscar($pisoUno);

$habitacionUno ="SELECT * FROM habitacion WHERE idpiso = 1";
$requestHabitacionUno = $con->listar($habitacionUno);

$pisos = "SELECT idpiso, nombrepiso FROM piso_habitacion WHERE idpiso !=1";
$requestPisos = $con->listar($pisos);

?>
<main>
<div class="wrapper">
<div class="content-page">
<?php require_once("Libraries/Core/Open.php") ?>
<?php 
  
  $idreservacion = $_REQUEST['id'];
  $con = new Mysql();
  $reservacion = "SELECT r.total, r.costoHabitacion, re.id_reservacionestado, r.cliente, u.nombres,u.identificacion, h.nombre_habitacion, h.capacidad, o.nombre, re.nombre as estado,fecha_inicio as inicio,r.fecha_fin as fin, r.descuento, u.identificacion, u.email_user, u.direccion,  h.idhabitacion FROM reservaciones r INNER JOIN origen_reservacion o ON r.reservacion_origen_id = o.idorigen_reservacion INNER JOIN reservaciones_estados re ON r.reservacion_estado_id = re.id_reservacionestado INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion INNER JOIN usuario u ON r.cliente=u.idusuario WHERE r.id_reservacion = $idreservacion";
  $request_reservacion = $con->buscar($reservacion);

  // var_dump($request_reservacion);

  $identificacion = $request_reservacion['identificacion'];
  // var_dump($identificacion);

  $idcliente = $request_reservacion['cliente'];
  $totalReserva = $request_reservacion['total'];

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

 $sqlTotal = "SELECT *, SUM(total_consumo) as total_consumo FROM consumos WHERE reservaid = $idreservacion and tipo_comprobante != 10";
 $request_consumo_total = $con->buscar($sqlTotal);

 if(empty($request_consumo_total['total_consumo'])){
  $total_consumo_tot = 0;
  }else{
  $total_consumo_tot = $request_consumo_total['total_consumo'];
  // var_dump($total_consumo);exit;
  }
  // var_dump($monto_total_tot);

?> 
<form id="formReservationPayment" name="formReservationPayment">
    
    
    <div class="row">
      <!---------------------- INICIO PARTE IZQUIERDAAAAAAAAAAAAAAA--------------->
      <div class="col-lg-4">
                <div class="card">
                  <div class="card-body">
                    <!-- Seccion para seleccón de Tarifas -->
                    <input type="hidden" id="idUser" name="idUser" value="<?= $_SESSION['idUser'] ?>">
                    <input type="hidden" id="documento" name="documento" value="<?= $identificacion ?>">
                    <h4 class="text-dark"><input type="hidden" id="idReservacion" name="idReservacion" value="<?= $idreservacion ?>">Reservación #<?php echo $idreservacion ?></h4>
                    <br>
                    <b class="card-title">Titular: </b>
                    <small><?= $request_reservacion['nombres']?></small>
                    <br>
                    <b class="card-title">Documento: </b>
                    <small><?= $request_reservacion['identificacion']?></small>
                    <br>
                    <b class="card-title">Correo: </b>
                    <small><?= $request_reservacion['email_user']?></small>
                    <br>
                    <b class="card-title">Direccion: </b>
                    <small><?= $request_reservacion['direccion']?></small>
                    <br>
                    <p>
                    <b class="card-title">Ingreso: </b>
                    <small><?=  $fecha_inicio ?></small>
                    <br>
                    <b class="card-title">Salida: </b>
                    <small><?=  $fecha_fin ?></small>
                    <br>
                    <b class="card-title">Origen: </b>
                    <small>Directa</small>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                          <b class="card-title">Estado: </b>
                          <small><?= $request_reservacion['estado']?></small>
                          </p>
                      </div>
                      <div class="col-md-6">
                      <input value="<?= $request_reservacion['id_reservacionestado']?>" id="estado" type="hidden">
                      <?php 
                        if($request_reservacion['id_reservacionestado'] == 2 ){ 
                      ?>
                      <button onclick="cambiarEstadoHabitacion();" type="button" id="btnCambiarEstado" class="btn btn-primary btn-sm"> Checkout </button>
                      <?php }else if($request_reservacion['id_reservacionestado']==1){  ?>
                        <button onclick="cambiarEstadoHabitacionCheckIn();" type="button" id="btnCambiarEstado" class="btn btn-primary btn-sm"> CheckIn </button>
                      <?php } ?>
                      </div>
                    </div>
                   
                    <hr>
                    <h4 class="text-dark">Habitación: <?php echo $request_reservacion['nombre_habitacion']?></h4>
                    <tr id="fila'+cont+'">
                      <td>
                        <input type="hidden"  value="'+idhabitacion+'">
                        <input type="hidden"  id="habitacionesid" value="<?php echo $request_reservacion['idhabitacion'] ?>">
                        <b class="card-title">CAPACIDAD <?= $request_reservacion['capacidad']?>
                        </b>
                        <input type="hidden" id="precio" value="">
                      </td>
                      <td>

                      </td>
                    </tr>
                    <hr>
                    <h4 class="text-dark">Pagos</h4>
                    <br>
                    <p><b class="card-title">Costo de habitacion: <small>S/ <?= formatMoney($request_reservacion['costoHabitacion'])?></small></b>
                    </p>
                    <?php
                    if($request_reservacion['descuento']>0){
                    ?>    
                    <p><b class="card-title">Descuento :
                      <small>S/ <?= formatMoney($request_reservacion['descuento'])?></small></b>
                      <button type="button" class="btn btn-light btn-sm" style="border:none; border-radius:10px;" onclick="eliminarDescuento(<?=$idreservacion?>, <?=$request_reservacion['descuento']?>)"><i style="color:red;" class="fa-solid fa-trash"></i></button>
                    </p>
                    <?php
                    }
                    ?>
                    <hr>

                    <h4 class="text-dark">Consumos</h4>
                    <br>
                    <?php 
                        $sql = "SELECT *, SUM(total_consumo) as total_consumo FROM consumos WHERE reservaid = $idreservacion and tipo_comprobante != 10 and total_consumo != 0";
                        $request_consumo = $con->buscar($sql);
                        if(empty($request_consumo['total_consumo'])):
                    ?>
                    <p><b class="card-title">Ningun consumo registrado</b></p>
                    <?php else: ?>
                      <p><b class="card-title">Total consumo: 
                        <small>S/ <?= formatMoney($request_consumo['total_consumo'])?>
                        </small>
                        </b>
                      </p>
                      <?php endif; ?>
                    <?php  $reservacion = $_REQUEST['id'];
                        $sql_payment = "SELECT * FROM reservaciones_payments WHERE reservacionid = $reservacion";
                        $request_sql_payment = $con->buscar($sql_payment);  ?>

                  </div>
                  
                  <div class="row">
                  
                      <div class="card-body">
                        <div class="tab-content">
                        <div data-simplebar style="max-height: 210px;">
                          <div class="table-responsive">
                            
                            <table id="tableConsumoProducto" class="table table-sm table-centered mb-0">

                                <tbody>
                                <?php
                                    $reservacion = $_REQUEST['id'];
                                    if($reservacion != null){
                                      $sql = "SELECT dc.id_detalle_consumo, dc.consumoid, dc.cantidadActual, p.nombre, c.total_consumo, dc.precio_venta, dc.cantidadConsumoDesechado, p.unidadMedida FROM consumos c INNER JOIN detalle_consumo dc ON c.idconsumo = dc.consumoid INNER JOIN producto p ON dc.idarticulo = p.idProducto WHERE p.nombre != 'SERVICIO DE HOSPEDAJE' and c.reservaid = $reservacion and dc.estado != 0 and cantidadActual != 0";
                                      $request = $con->listar($sql);
                                      foreach($request as $consumo):
                                        $btnDeletNoReturn = '';
                                        $btnDeletReturn = '';


                                        $cantidad = $consumo['cantidadActual'];
                                        $nombre = $consumo['nombre'];
                                        $precio = $consumo['cantidadActual']*$consumo['precio_venta'];

                                        if($consumo['nombre'] == 'AUMENTO DE ESTADIA'){
                                          $btnDeletReturn .= '<button style="margin-left:20px; width:30px; height:30px; border:none; border-radius:10px;" onclick="eliminarAumentoEstadia('.$consumo['id_detalle_consumo'].','.$consumo['consumoid'].','.$reservacion.')" title="Retornar Producto"><i style="color:red;" class="fa-solid fa-trash"></i></button>';
                                    
                                          $consumo['options'] = '<div class="text-center" style="display:flex">'.$btnDeletReturn.'</div>';

                                          $opcion = $consumo['options'];
                                        }else 
                                          if($consumo['unidadMedida'] == 'NIU'){
                                            $btnDeletNoReturn .= '<button style="margin-left:20px; width:30px; height:30px; border:none; border-radius:10px;" onclick="desecharProductos('.$consumo['id_detalle_consumo'].','.$consumo['consumoid'].','.$consumo['cantidadActual'].')" title="Desechar Producto"><i style="color:blue;" class="fa-solid fa-list"></i></button>';

                                            $btnDeletReturn .= '<button style="margin-left:20px; width:30px; height:30px; border:none; border-radius:10px;" onclick="retornarProductos('.$consumo['id_detalle_consumo'].','.$consumo['consumoid'].','.$reservacion.')" title="Eliminar Aumento de Estadia"><i style="color:red;" class="fa-solid fa-trash"></i></button>';
                                      
                                            $consumo['options'] = '<div class="text-center" style="display:flex">'.$btnDeletNoReturn.''.$btnDeletReturn.'</div>';
  
                                            $opcion = $consumo['options'];
                                        }else
                                          if($consumo['nombre'] != 'AUMENTO DE ESTADIA' && $consumo['unidadMedida'] == 'ZZ'){
                                            $btnDeletReturn .= '<button style="margin-left:20px; width:30px; height:30px; border:none; border-radius:10px;" onclick="eliminarServicio('.$consumo['id_detalle_consumo'].','.$consumo['consumoid'].','.$reservacion.')" title="Eliminar Servicio"><i style="color:red;" class="fa-solid fa-trash"></i></button>';
                                    
                                            $consumo['options'] = '<div class="text-center" style="display:flex">'.$btnDeletReturn.'</div>';
  
                                            $opcion = $consumo['options'];
                                          }
                                        
                                    ?>
                                    <tr>
                                      <td><b><?=$cantidad?></b></td>
                                      <td><b><?=$nombre?></b></td>
                                      <td><b> S/. <?= formatMoney($precio)?></b></td>
                                      <td><b><?=$opcion?></b></td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>       
                            <?php
                              }else{
                              ?>

                              <?php
                              }
                            ?>                                    
                          </div> <!-- end preview-->
                          </div>  
                        </div>
              
                    </div>
                    
                  </div>
                </div>

      </div>
      
      <!---------------------- FINPARTE IZQUIERDAAAAAAAAAAAAAAA--------------->

            <!---------------------- INICIO PARTE DERECHAAAAAAAAAAAAAAAAA--------------->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">

            <a href="<?= base_url(); ?>/hospedar" title= "Regresar"><h4 class=" dripicons-arrow-thin-left " style="cursor: pointer;"> Regresar</h4>
            </a>
            <h4 style= "text-align: center"><b class="card-title" >Registro de Pago</b></h4>
            <hr>
            <div style= "text-align: center">
              <p >
                <b class= "text-dark"><i class=" dripicons-user"></i>
                <?= $request_reservacion['nombres']?>
                </b>
              </p>
            </div>
            <hr>
            <h4 ><b class="card-title" >Información de Pago</b></h4>
            <div class="row" >
              <div class="col-md-4">

              <b class="card-title text-dark">Montos totales: </b>
              <p>
                <?php 
                   $monto_total = $request_reservacion['total'];
                ?>
                <b class="card-title">S/ <?= formatMoney($monto_total)?>
                </b>
              </p>
              </div>
              <div class="col-md-4">
                <b class="card-title text-dark">Monto ingresado</b>
                <p>
                  <b class="card-title">S/ <?= formatMoney($request_pagos_reservacion['monto_pagado'])?>
                  </b>
                </p>

              </div>
              <div class="col-md-4">
                <b class="card-title text-danger">Monto faltante</b>
                <?php 
                    $monto_faltante = $monto_total - $request_pagos_reservacion['monto_pagado'];
                    if($monto_faltante < 0):
                ?>
                <p><b class="card-title text-danger">S/ <?= formatMoney(0)?></b>
                </p>
                  <?php else: ?>
                <p><b class="card-title text-danger">S/ <?= formatMoney($monto_faltante)?></b>
                </p>
                    <?php endif; ?>
              </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <select  class="form-select"  data-live-search="true" id="medio_pago" name="medio_pago" placeholder="Medio pago">
                    </select>
                </div>
                <div class="col-md-3">
                    <input  onkeydown="pulse(event)" type="hidden" id="total_reserva_pago" name="total_reserva_pago" class="form-contro" placeholder="Monto" value="<?= formatMoney($request_reservacion['total']) ?>"> 

                    <input onkeyup="this.value=numeros(this.value)" type="text" id="montoPago" name="montoPago" class="form-control" placeholder="Monto"> &nbsp;&nbsp;
                </div>
                <div class="col-md-3">
                    <button onclick="agregarPago();" type="button" id="btnAgregarPago" class="btn btn-light btn-sm"> AGREGAR </button>
                </div>
                <div data-simplebar style="max-height: 145px;">
                  <div style="display:none" id="tablamediopago">
                      <div class="table-responsive">
                          <table id="detallesPago" class="table table-sm table-centered mb-0">
                              <thead>
                                  <tr>
                                      <th>Eliminar</th>
                                      <th>Medio de Pago</th>
                                      <th>Editar Monto</th>
                                      <th>Monto a Pagar</th>
                                  </tr>
                              </thead>                     
                              <tfoot>
                                <input type="hidden" id="total_pago" name="total_pago"> &nbsp;&nbsp;
                              </tfoot>
                          </table> 
                      </div>
                  </div>
                </div>
            </div>
            <br>
            <div>
                <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripcion">
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <input onkeyup="this.value=num(this.value); searchCambiarCliente(); "type="text" id="identificacion" name="identificacion" class="form-control" placeholder="Nº Doc">
                </div>
                <div class="col-md-4">
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombres o Razon social">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <input  type="text" id="correo" name="correo" class="form-control" placeholder="Correo Electronico">
                </div>
                <div class="col-md-4">
                    <input  type="text" id="direccion" name="direccion" class="form-control" placeholder="Direccion">
                </div>
                <div class="col-md-4">
                    <button onclick="agregarClienteReservacion(<?= $idcliente?>, <?= $idreservacion?>)" type="button" id="btnAgregarPago" class="btn btn-light btn-sm">CAMBIAR CLIENTE</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                  <select onchange="seleccionarDescuento()" class="form-select" id="descuentos" name="descuentos">
                      <option value="0">Seleccionar</option>
                      <option value="1">Por monto</option>
                      <option value="2">Por porcentaje</option>
                  </select>
                </div>
                <div style="display:none" class="col-md-4" id="montoDescuento">
                    <input onkeyup="this.value=numeros(this.value)" type="text" id="mtnDesc" name="mtnDesc" class="form-control" placeholder="Ingresar Monto">
                </div>
                <div style="display:none" class="col-md-4" id="porcentajeDescuento">
                    <input onkeyup="this.value=numeros(this.value)" type="text" id="pctjDesc" name="pctjDesc" class="form-control" placeholder="Ingresar Porcentaje">
                </div>
                <div class="col-md-4">
                  <button  onclick="calcularDescuento(<?= $idreservacion?>, <?=$totalReserva?>)" type="button" id="btnAgregarDescuento" class="btn btn-light btn-sm">AÑADIR DESCUENTO</button>
                </div>
            </div>
            <br>
            <div style="display:flex">
              <label class="form-check-label"><input type="checkbox" class="form-check-input"  value="first_checkbox"  checked> Generar  impresión </label>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <br>
            
            
            
            <div class="row button-list">
              
              <?php 
                  if($request_reservacion['total'] > $request_pagos_reservacion['monto_pagado']):
              ?>
              <br>
              <?php endif;?>
              <div>

              
                <button onclick="pagar(1,<?= $monto_faltante?>);" type="button" id="btnFactura" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> FACTURA</button>

                <button onclick="pagar(2,<?= $monto_faltante?>);" type="button" id="btnBoleta" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> BOLETA</button>

                <button onclick="pagar(3,<?= $monto_faltante?>);" type="button" id="btnTicket" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> TICKET</button>
                <button onclick="precuenta(<?= $idreservacion?>);" type="button" id="btnPrecuenta" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> PRECUENTA</button>
                <!-- <button onclick="pagar(5);" type="button" id="btnPrecuenta" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> CORTESIA</button> -->

                <button onclick="agregarConsumoHabitacion();" type="button" id="btnConsumo" class="btn btn-light btn-sm"><i class="dripicons-plus"></i> Agregar Consumo</button>

                <button onclick="agregarAumentoEstadia();" type="button" id="btnConsumo" class="btn btn-light btn-sm"><i class="dripicons-plus"></i>Aumentar Estadia</button>

                <!-- <button onclick="cancelarForm();" type="button" id="btnCancelar" class="btn btn-danger btn-sm"><i class="mdi mdi-window-close"></i> ANULAR</button> -->
              </div>
            </div>




          </div>
        </div>

      </div>
             <!---------------------- FIN PARTE DERECHAAAAAAAAAAAAAAAAA--------------->           
      

    </div>
<!-- end row-->

<!-- end row-->

    </div>
    </div>
</form>

</div>
</div>
</main>
<?php footerAdmin($data); ?>

