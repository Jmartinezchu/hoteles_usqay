<?php
  $idreservacion = $_GET['id'];
  $con = new Mysql();
  $consulta_reserva = "SELECT * FROM reservaciones WHERE id_reservacion = $idreservacion";
  $request_consulta_reserva = $con->buscar($consulta_reserva);

  $id_habitacion = $request_consulta_reserva['habitacion_id'];
  $fecha_final = $request_consulta_reserva['fecha_fin'];
  $montoActualReserva = $request_consulta_reserva['total'];

  $bloquear_fechas_result = strtotime ( '+1 day' , strtotime ($fecha_final) ) ; 
  $bloquear_fechas = date ( 'Y-m-d H:i:s' , $bloquear_fechas_result);

  $tipo_estadia = "SELECT estadia_dias_horas FROM configuracion WHERE id = 1";
  $request_tipo_estadia = $con->buscar($tipo_estadia);
  $estadia = $request_tipo_estadia['estadia_dias_horas']; 
?>

<div class="modal fade" id="modalEstadia" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aumentar Estadia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <?php
        if($estadia == 2){
            $sql_tarifas = "SELECT t.idTarifa, t.nombreTarifa FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE h.idhabitacion = $id_habitacion GROUP BY t.nombreTarifa";
            $request_tarifas = $con->listar($sql_tarifas);
        ?>
        <div class="modal-body">
                <form id="formEstadia" name="formEstadia">
                <input type="hidden" id="idreservacion" name="idreservacion" value="<?=$idreservacion?>">
                <input type="hidden" id="tiempoDias" name="tiempoDias">
                <input type="hidden" id="tiempoHoras" name="tiempoHoras">
                <input type="hidden" id="tiempoMinutos" name="tiempoMinutos">
                <input type="hidden" id="fechaSalidaAnterior" name="fechaSalidaAnterior" value="<?=$fecha_final?>">
                <input type="hidden" id="idhabitacion" name="idhabitacion" value="<?= $id_habitacion?>">
                    <div class="form-group mb-0">
                        <label for="example-select" class="form-control-label">Tarifas:</label>
                        <select  onchange="tarifario()" class="form-control" id="idTarifas" name="idTarifas"> 
                            <option value="0">Seleccionar...</option>
                            <?php
                            if($request_tarifas != null){
                                foreach ($request_tarifas as $tarifaHabitacion):
                                    $idTarifa = $tarifaHabitacion['idTarifa'];
                                    $nombreTarifa = $tarifaHabitacion['nombreTarifa'];
                            ?>
                                <option value="<?= $idTarifa?>"><?=$nombreTarifa?></option>
                            <?php
                                endforeach;
                                }else{
                            ?>
                            <?php  
                                }
                            ?>
                        </select>  
                     </div>
                     <br>
                    <p id="precios" style="display:none">Precios:</p>
                    <div id="precios-tarifa">
                    </div>
                    <div id="tiempoDeTarifas" style="display:none">
                        <p><label for="example-select" class="form-label">Tiempo de estadia:</label></p>
                        <span>Dias: <span id="diaTar" name="diaTar"></span></span>
                        <span>Horas: <span id="horaTar" name="horaTar"></span></span>
                        <span>Minutos: <span id="minTar" name="minTar"></span></span>
                    </div>
                    <br>
                    <div id="horas_reserva" style="display:none">
                        <div class="form-group mb-0">
                            <label for="example-select" class="form-label">Tiempo estadia:</label>
                            <select onchange="calcularHoras()" class="form-select" id="horas" name="horas">
                                <option value="1">1 hora</option>
                                <option value="2">2 horas</option>
                                <option value="3">3 horas</option>
                                <option value="4">4 horas</option>
                                <option value="5">5 horas</option>
                            </select>
                        </div>
                    </div>

                    <input onchange="calcularFecha()" type="hidden" id="ingreso" class="form-control" name="ingreso" value="<?php echo  $fecha_final; ?>">

                    <div id="dias_reserva" style="display:none">
                        <div class="form-group mb-0">
                                <p>Tiempo de estadia: <small id="tiempo" name="tiempo"></small></p>         
                        </div>

                        <div class="form-group mb-0">
                            <label for="example-select" class="form-label">Salida:</label>
                            <input onchange="calcularFecha()" step="1" min="<?=$bloquear_fechas?>" type="Datetime-local" id="salida" class="form-control" placeholder="Salida" name="salida" value="<?php echo  $bloquear_fechas; ?>">
                        </div>
                    </div>
                 
                    <div>
                        <input id="diasTotal" name="diasTotal" type="hidden">
                        <input id="horasTotal" name="horasTotal" type="hidden">
                        <input id="minutosTotal" name="minutosTotal" type="hidden">
                        <input id="totales" type="hidden">
                        <input id="montoActualReservacion" name="montoActualReservacion" type="hidden">
                        <input id="total_reserva" name="total_reserva" type="hidden" value="<?=  $montoActualReserva?>">
                        <input id="total_aumento" name="total_aumento" type="hidden" ">
                        <p>Monto de reservacion: <small id="total_anterior" name="total_anterior">S/. <?=  $montoActualReserva?></small></p>
                        <p>Total a Aumentar: <small id="total" name="total"></small></p>
                        <p>Monto Actual: <small id="total_actual" name="total_actual"></small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarAuemntoEstadia(<?=$idreservacion?>)">Guardar</button>
                    </div>
                </form>
            </div>
       
       </div>
       <?php
       }else if($estadia == 0){
        $sql_tarifas = "SELECT t.idTarifa, t.nombreTarifa FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE h.idhabitacion = $id_habitacion AND t.idTarifa != 1 AND t.idTarifa != 2 GROUP BY t.nombreTarifa";
        $request_tarifas = $con->listar($sql_tarifas);
       ?>
       <div class="modal-body">
                <form id="formEstadia" name="formEstadia">
                <input type="hidden" id="idreservacion" name="idreservacion" value="<?=$idreservacion?>">
                <input type="hidden" id="tiempoDias" name="tiempoDias">
                <input type="hidden" id="tiempoHoras" name="tiempoHoras">
                <input type="hidden" id="tiempoMinutos" name="tiempoMinutos">
                <input type="hidden" id="fechaSalidaAnterior" name="fechaSalidaAnterior" value="<?=$fecha_final?>">
                <input type="hidden" id="idhabitacion" name="idhabitacion" value="<?= $id_habitacion?>">
                    <div class="form-group mb-0">
                        <label for="example-select" class="form-control-label">Tarifas:</label>
                        <select  onchange="tarifario()" class="form-control" id="idTarifas" name="idTarifas" > 
                            <option value="0">Seleccionar...</option>
                            <?php
                            if($request_tarifas != null){
                                foreach ($request_tarifas as $tarifaHabitacion):
                                    $idTarifa = $tarifaHabitacion['idTarifa'];
                                    $nombreTarifa = $tarifaHabitacion['nombreTarifa'];
                            ?>
                                <option value="<?= $idTarifa?>"><?=$nombreTarifa?></option>
                            <?php
                                endforeach;
                                }else{
                            ?>
                            <?php  
                                }
                            ?>
                        </select>  
                     </div>
                     <br>
                    <p id="precios" style="display:none">Precios:</p>
                    <div id="precios-tarifa">
                    </div>
                    <br>
                    <div id="tiempoDeTarifas" style="display:none">
                        <p><label for="example-select" class="form-label">Tiempo de estadia:</label></p>
                        <span>Dias: <span id="diaTar" name="diaTar"></span></span>
                        <span>Horas: <span id="horaTar" name="horaTar"></span></span>
                        <span>Minutos: <span id="minTar" name="minTar"></span></span>
                    </div>           
                    <br>        
                    <div>
                        <input id="diasTotal" name="diasTotal" type="hidden">
                        <input id="horasTotal" name="horasTotal" type="hidden">
                        <input id="minutosTotal" name="minutosTotal" type="hidden">
                        <input id="totales" type="hidden">
                        <input id="montoActualReservacion" name="montoActualReservacion" type="hidden">
                        <input id="total_reserva" name="total_reserva" type="hidden" value="<?=  $montoActualReserva?>">
                        <input id="total_aumento" name="total_aumento" type="hidden" ">
                        <p>Monto de reservacion: <small id="total_anterior" name="total_anterior">S/. <?=  $montoActualReserva?></small></p>
                        <p>Total a Aumentar: <small id="total" name="total"></small></p>
                        <p>Monto Actual: <small id="total_actual" name="total_actual"></small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarAuemntoEstadia(<?=$idreservacion?>)">Guardar</button>
                    </div>
                </form>
            </div>
       
       </div>
       <?php
       }else if($estadia == 1){
        $sql_tarifas = "SELECT t.idTarifa, t.nombreTarifa FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE h.idhabitacion = $id_habitacion AND t.idTarifa = 1 OR t.idTarifa = 2 GROUP BY t.nombreTarifa";
        $request_tarifas = $con->listar($sql_tarifas);
        ?>
        <div class="modal-body">
                <form id="formEstadia" name="formEstadia">
                <input type="hidden" id="idreservacion" name="idreservacion" value="<?=$idreservacion?>">
                <input type="hidden" id="tiempoDias" name="tiempoDias">
                <input type="hidden" id="tiempoHoras" name="tiempoHoras">
                <input type="hidden" id="tiempoMinutos" name="tiempoMinutos">
                <input type="hidden" id="fechaSalidaAnterior" name="fechaSalidaAnterior" value="<?=$fecha_final?>">
                <input type="hidden" id="idhabitacion" name="idhabitacion" value="<?= $id_habitacion?>">
                    <div class="form-group mb-0">
                        <label for="example-select" class="form-control-label">Tarifas:</label>
                        <select  onchange="tarifario()" class="form-control" id="idTarifas" name="idTarifas" > 
                            <option value="0">Seleccionar...</option>
                            <?php
                            if($request_tarifas != null){
                                foreach ($request_tarifas as $tarifaHabitacion):
                                    $idTarifa = $tarifaHabitacion['idTarifa'];
                                    $nombreTarifa = $tarifaHabitacion['nombreTarifa'];
                            ?>
                                <option value="<?= $idTarifa?>"><?=$nombreTarifa?></option>
                            <?php
                                endforeach;
                                }else{
                            ?>
                            <?php  
                                }
                            ?>
                        </select>  
                     </div>
                    <br>
                    <p id="precios" style="display:none">Precios:</p>
                    <div id="precios-tarifa">
                    </div>
                    <div id="horas_reserva" style="display:none">
                        <div class="form-group mb-0">
                            <label for="example-select" class="form-label">Tiempo estadia:</label>
                            <select onchange="calcularHoras()" class="form-select" id="horas" name="horas">
                                <option value="1">1 hora</option>
                                <option value="2">2 horas</option>
                                <option value="3">3 horas</option>
                                <option value="4">4 horas</option>
                                <option value="5">5 horas</option>
                            </select>
                        </div>
                    </div>

                    <input onchange="calcularFecha()" type="hidden" id="ingreso" class="form-control" name="ingreso" value="<?php echo  $fecha_final; ?>">
                    <br>
                    <div id="dias_reserva" style="display:none">
                        <div class="form-group mb-0">
                                <p>Tiempo de estadia: <small id="tiempo" name="tiempo"></small></p>         
                        </div>

                        <div class="form-group mb-0">
                            <label for="example-select" class="form-label">Salida:</label>
                            <input onchange="calcularFecha()" min="<?=$bloquear_fechas?>" type="date" id="salida" class="form-control" placeholder="Salida" name="salida" value="<?php echo  $bloquear_fechas; ?>">    
                        </div>
                    </div>
                   <br>
                   <div>
                        <input id="diasTotal" name="diasTotal" type="hidden">
                        <input id="horasTotal" name="horasTotal" type="hidden">
                        <input id="minutosTotal" name="minutosTotal" type="hidden">
                        <input id="totales" type="hidden">
                        <input id="montoActualReservacion" name="montoActualReservacion" type="hidden">
                        <input id="total_reserva" name="total_reserva" type="hidden" value="<?=  $montoActualReserva?>">
                        <input id="total_aumento" name="total_aumento" type="hidden" ">
                        <p>Monto de reservacion: <small id="total_anterior" name="total_anterior">S/. <?=  $montoActualReserva?></small></p>
                        <p>Total a Aumentar: <small id="total" name="total"></small></p>
                        <p>Monto Actual: <small id="total_actual" name="total_actual"></small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarAuemntoEstadia(<?=$idreservacion?>)">Guardar</button>
                    </div>
                </form>
            </div>
       
       </div>
       <?php
       }
       ?>
    </div>
</div>
