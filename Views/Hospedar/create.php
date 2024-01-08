<?php headerAdmin($data);
$fechaInicio = date('Y-m-d');
$con = new Mysql();
$id_habitacion = $_GET['id'];
$date = date('Y-m-d');
$bloquear_fechas_result = strtotime('+1 day', strtotime($date));
$bloquear_fechas = date('Y-m-d', $bloquear_fechas_result);

// var_dump($bloquear_fechas);

//   var_dump($id_habitacion);
$habitacion = "SELECT * FROM habitacion WHERE idhabitacion =  $id_habitacion ";
$request_habitacion = $con->buscar($habitacion);

$tipo_estadia = "SELECT estadia_dias_horas FROM configuracion WHERE id = 1";
$request_tipo_estadia = $con->buscar($tipo_estadia);
$estadia = $request_tipo_estadia['estadia_dias_horas'];
// var_dump($estadia);


$tarifaSelecciona = 0;
// var_dump($request_tarifas);
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
                                        <li class="breadcrumb-item active">Hospedar</li>
                                        <li class="breadcrumb-item active">Crear</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Crear hospedaje</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <form id="formReserva" name="formReserva">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg 6">
                                                <?php
                                                $id = $_GET['id'];
                                                $nombre_habitacion = $_GET['habitacion'];
                                                ?>
                                                <div class="mb-3">
                                                    <label for="example-placeholder" class="form-label">Habitacion: <b><?= $nombre_habitacion ?></b></label>
                                                    <input type="hidden" id="idhabitacion" name="idhabitacion" value="<?= $_GET['id'] ?>">
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="example-select" class="form-label">HUESPED:</label>
                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Nº Documento:</label>
                                                        <!-- <input onkeyup="this.value=numeros(this.value); searchHuesped()" type="text" id="identificacion" class="form-control" name="identificacion" value="11111111"> -->
                                                        <input onkeyup="this.value; searchHuesped()" type="text" id="identificacion" class="form-control" name="identificacion" value="11111111">
                                                    </div>

                                                </div>
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Nombres o Razon Social:</label>
                                                        <input type="text" id="huesped" class="form-control" name="huesped" value="CLIENTES VARIOS">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Correo electronico:</label>
                                                        <input type="text" id="correo" class="form-control" name="correo" value="clientesvarios@gmail.com">
                                                    </div>
                                                </div>
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Direccion:</label>
                                                        <input type="text" id="direccion" class="form-control" name="direccion" value="Direccion General">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <?php
                                    if ($estadia == 2) {
                                        $sql_tarifas = "SELECT t.idTarifa, t.nombreTarifa FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE h.idhabitacion = $id_habitacion GROUP BY t.nombreTarifa";
                                        $request_tarifas = $con->listar($sql_tarifas);
                                    ?>
                                        <div class="card-body">
                                            <!-- <?php var_dump($request_tarifas); ?> -->
                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Tarifas:</label>
                                                        <select class="form-select" onchange="tarifario()" id="idTarifas" name="idTarifas">
                                                            <option value="0">Seleccionar...</option>
                                                            <!-- <option value="0">jajajaj...</option> -->
                                                            <?php
                                                            if ($request_tarifas != null) {
                                                                foreach ($request_tarifas as $tarifaHabitacion) :
                                                                    $idTarifa = $tarifaHabitacion['idTarifa'];
                                                                    $nombreTarifa = $tarifaHabitacion['nombreTarifa'];
                                                            ?>
                                                                    <option value="<?= $idTarifa ?>"><?= $nombreTarifa ?></option>
                                                                <?php
                                                                endforeach;
                                                            } else {
                                                                ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="idreservacion" name="idreservacion">
                                                <input type="hidden" id="tiempoDias" name="tiempoDias">
                                                <input type="hidden" id="tiempoHoras" name="tiempoHoras">
                                                <input type="hidden" id="tiempoMinutos" name="tiempoMinutos">
                                                <input type="hidden" id="estados_reservaciones" name="estados_reservaciones" value="2">
                                            </div>
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
                                            <div id="horas_reserva" style="display:none">
                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
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
                                                </div>
                                            </div>

                                            <input onchange="calcularFecha()" type="hidden" id="ingreso" class="form-control" name="ingreso" value="<?php echo  $fechaInicio; ?>">

                                            <div id="dias_reserva" style="display:none">
                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <p>Tiempo de estadia: <small id="tiempo" name="tiempo"></small></p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Salida:</label>
                                                            <input onchange="calcularFecha()" min="<?= $bloquear_fechas ?>" type="date" id="salida" class="form-control" placeholder="Salida" name="salida" value="<?php echo  $bloquear_fechas; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="reserva_anticipada" style="display:none">
                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <p>Tiempo de estadia: <small id="tiempoant" name="tiempoant"></small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <input onchange="calcularFecha()"  id="ingresoant" class="form-control" name="ingresoant" value="<?php echo  $fechaInicio; ?>"> -->
                                                <!-- <h3>es Annticipada</h3> -->

                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Ingreso:</label>
                                                            <input onchange="calcularFechaanticipada()" min="<?= $bloquear_fechas ?>" type="date" id="ingresoant" class="form-control" placeholder="Ingreso" name="ingresoant" value="<?php echo  $fechaInicio; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Salida:</label>
                                                            <input onchange="calcularFechaanticipada()" min="<?= $fechaInicio ?>" type="date" id="salidaant" class="form-control" placeholder="Salida" name="salida" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Origen Reservacion:</label>
                                                        <select class="form-select" data-live-search="true" id="origen_reserva" name="origen_reserva">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <input id="diasTotal" name="diasTotal" type="hidden">
                                                <input id="horasTotal" name="horasTotal" type="hidden">
                                                <input id="minutosTotal" name="minutosTotal" type="hidden">
                                                <input id="totales" type="hidden">
                                                <input id="total_reserva" name="total_reserva" type="hidden">
                                                <input id="total_habitacion" name="total_habitacion" type="hidden">
                                                <p>Total: <small id="total" name="total"></small></p>
                                            </div>

                                            <div class="modal-footer">
                                                <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarReservacion()"><span id="btnText">Reservar</span></button>&nbsp;
                                            </div>

                                        </div>
                                    <?php
                                    } else if ($estadia == 0) {
                                        $sql_tarifas = "SELECT t.idTarifa, t.nombreTarifa FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE h.idhabitacion = $id_habitacion AND t.estado != 0 GROUP BY t.nombreTarifa";
                                        $request_tarifas = $con->listar($sql_tarifas);
                                    ?>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Tarifas:</label>
                                                        <select class="form-select" onchange="tarifario()" id="idTarifas" name="idTarifas">
                                                            <option value="0">Seleccionar...</option>
                                                            <!-- <option value="0">jajajaj...</option> -->

                                                            <?php
                                                            if ($request_tarifas != null) {
                                                                foreach ($request_tarifas as $tarifaHabitacion) :
                                                                    $idTarifa = $tarifaHabitacion['idTarifa'];
                                                                    $nombreTarifa = $tarifaHabitacion['nombreTarifa'];
                                                            ?>
                                                                    <option value="<?= $idTarifa ?>"><?= $nombreTarifa ?></option>
                                                                <?php
                                                                endforeach;
                                                            } else {
                                                                ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="idreservacion" name="idreservacion">
                                                <input type="hidden" id="tiempoDias" name="tiempoDias">
                                                <input type="hidden" id="tiempoHoras" name="tiempoHoras">
                                                <input type="hidden" id="tiempoMinutos" name="tiempoMinutos">
                                                <input type="hidden" id="estados_reservaciones" name="estados_reservaciones" value="2">
                                            </div>
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

                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Origen Reservacion:</label>
                                                        <select class="form-select" data-live-search="true" id="origen_reserva" name="origen_reserva">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <input id="diasTotal" name="diasTotal" type="hidden">
                                                <input id="horasTotal" name="horasTotal" type="hidden">
                                                <input id="minutosTotal" name="minutosTotal" type="hidden">
                                                <input id="totales" type="hidden">
                                                <input id="total_reserva" name="total_reserva" type="hidden">
                                                <input id="total_habitacion" name="total_habitacion" type="hidden">
                                                <p>Total: <small id="total" name="total"></small></p>
                                            </div>

                                            <div class="modal-footer">
                                                <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarReservacion()"><span id="btnText">Reservar</span></button>&nbsp;
                                            </div>



                                        </div>
                                    <?php
                                    } else if ($estadia == 1) {
                                        $sql_tarifas = "SELECT t.idTarifa, t.nombreTarifa FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE h.idhabitacion = $id_habitacion GROUP BY t.nombreTarifa";
                                        $request_tarifas = $con->listar($sql_tarifas);
                                    ?>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Tarifas:</label>
                                                        <select class="form-select" onchange="tarifario()" id="idTarifas" name="idTarifas">
                                                            <option value="0">Seleccionar...</option>
                                                            <?php
                                                            if ($request_tarifas != null) {
                                                                foreach ($request_tarifas as $tarifaHabitacion) :
                                                                    $idTarifa = $tarifaHabitacion['idTarifa'];
                                                                    $nombreTarifa = $tarifaHabitacion['nombreTarifa'];
                                                            ?>
                                                                    <option value="<?= $idTarifa ?>"><?= $nombreTarifa ?></option>
                                                                <?php
                                                                endforeach;
                                                            } else {
                                                                ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="idreservacion" name="idreservacion">
                                                <input type="hidden" id="tiempoDias" name="tiempoDias">
                                                <input type="hidden" id="tiempoHoras" name="tiempoHoras">
                                                <input type="hidden" id="tiempoMinutos" name="tiempoMinutos">
                                                <input type="hidden" id="estados_reservaciones" name="estados_reservaciones" value="2">
                                            </div>
                                            <p id="precios" style="display:none">Precios:</p>
                                            <div id="precios-tarifa">
                                            </div>
                                            <div id="horas_reserva" style="display:none">
                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
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
                                                </div>
                                            </div>

                                            <input onchange="calcularFecha()" type="hidden" id="ingreso" class="form-control" name="ingreso" value="<?php echo  $fechaInicio; ?>">

                                            <div id="dias_reserva" style="display:none">
                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <p>Tiempo de estadia: <small id="tiempo" name="tiempo"></small></p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Salida:</label>
                                                            <input onchange="calcularFecha()" min="<?= $bloquear_fechas ?>" type="date" id="salida" class="form-control" placeholder="Salida" name="salida" value="<?php echo  $bloquear_fechas; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="reserva_anticipada" style="display:none">
                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <p>Tiempo de estadia: <small id="tiempo" name="tiempo"></small></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg 6">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Salida:</label>
                                                            <input onchange="calcularFecha()" min="<?= $bloquear_fechas ?>" type="date" id="salida" class="form-control" placeholder="Salida" name="salida" value="<?php echo  $bloquear_fechas; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg 6">
                                                    <div class="mb-3">
                                                        <label for="example-select" class="form-label">Origen Reservacion:</label>
                                                        <select class="form-select" data-live-search="true" id="origen_reserva" name="origen_reserva">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <input id="diasTotal" name="diasTotal" type="hidden">
                                                <input id="horasTotal" name="horasTotal" type="hidden">
                                                <input id="minutosTotal" name="minutosTotal" type="hidden">
                                                <input id="totales" type="hidden">
                                                <input id="total_reserva" name="total_reserva" type="hidden">
                                                <input id="total_habitacion" name="total_habitacion" type="hidden">
                                                <p>Total: <small id="total" name="total"></small></p>
                                            </div>

                                            <div class="modal-footer">
                                                <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarReservacion()"><span id="btnText">Reservar</span></button>&nbsp;
                                            </div>

                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    // Función para actualizar el valor mínimo de #salidaant
    function actualizarFechaMinimaSalida() {
        var ingresoAntInput = document.getElementById("ingresoant");
        var salidaAntInput = document.getElementById("salidaant");
        
        // Establecer el valor mínimo de salida como el valor seleccionado en ingreso
        salidaAntInput.min = ingresoAntInput.value;
    }

    // Asignar el evento onchange a #ingresoant
    document.getElementById("ingresoant").addEventListener("change", actualizarFechaMinimaSalida);
</script>
<script>
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#ingreso").val(today);
</script>
<?php footerAdmin($data); ?>