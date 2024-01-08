<?php headerAdmin($data); 
  $fechaInicio = date('Y-m-d');
    

  if(isset($_GET['fecha'])){
      $fechaInicio = $_GET['fecha'];
     
  }
  $date = date('Y-m-d');
    $bloquear_fechas_result = strtotime('+1 day', strtotime($date));
    $bloquear_fechas = date('Y-m-d', $bloquear_fechas_result);
?>

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
                                    <li class="breadcrumb-item"><a
                                            href="<?= base_url(); ?>/Dashboard/dashboard">Inicio</a></li>
                                    <li class="breadcrumb-item active">Reservas</li>
                                    <li class="breadcrumb-item active">Crear</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Reservas</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <form id="formReserva" name="formReserva">
                    <div class="row">
                        <!----------------------PARTE IZQUIERDAAAAAAAAAAAAAAA--------------->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <label for="example-select" class="form-label">Tarifas:</label>
                                    <ul type="select" class="nav nav-pills bg-nav-pills nav-justified mb-3"
                                        id="tarifas">
                                        <li class="nav-item" data-target="dias_reserva" value="2">
                                            <a href="#D" data-bs-toggle="tab" aria-expanded="false"
                                                class="nav-link rounded-0">
                                                <i class="mdi mdi-account-clock d-md-none d-block"> Por día</i>
                                                <span class="d-none d-md-block">Por día</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <?php
                                        $idTarifa = 2;
                                    ?>
                                    <input id="idTarifasjajaja" name="idTarifasjajaja" type="hidden"
                                        value="<?= $idTarifa ?>">

                                    <!-- FIN Seccion para seleccón de Tarifas -->

                                    <input type="hidden" id="idreservacion" name="idreservacion">
                                    <!-- <h4 class="header-title mb-1">Tarifas</h4> -->
                                    <label class="mt-0 mb-1">Tiempo de estadia: <small
                                            id="tiempo_estadia"></small></label>
                                    <input type="hidden" id="tiempo" name="tiempo">


                                    <div class="tab-content">
                                        <div class="table-responsive">
                                            <div data-simplebar="" data-simplebar-primary="" style="max-height: 560px;">
                                                <div class="tab-content">
                                                    <div class="table-pane" id="H">
                                                        <p>
                                                        <div id="horas_reserva" style="display: none">
                                                            <select onchange="calcularHoras()" class="form-select"
                                                                id="horas">
                                                                <option value="1">1 horas</option>
                                                                <option value="2">2 horas</option>
                                                                <option value="3">3 horas</option>
                                                                <option value="4">4 horas </option>
                                                                <option value="5">5 horas </option>
                                                            </select>
                                                        </div>
                                                        </p>


                                                    </div>
                                                    <div class="tab-pane" id="D">
                                                        <p>

                                                        <div class="row" id="dias_reserva">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="example-date" class="form-label">Desde</label>
                                                                <input onchange="calcularFecha()"
                                                                    min="<?= $bloquear_fechas ?>" class="form-control"
                                                                    id="ingreso" type="date" name="ingreso"
                                                                    value="<?php echo  $fechaInicio; ?>">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="example-date" class="form-label">Hasta</label>
                                                                <input onchange="calcularFecha()"
                                                                    min="<?= $fechaInicio ?>" class="form-control"
                                                                    id="salida" type="date" name="salida" value="">
                                                            </div>
                                                        </div>

                                                        </p>
                                                        <div class="col-md-3" id="foodrooms">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->


                                    <select data-live-search="true" style="display:none" id="estados_reservaciones"
                                        name="estados_reservaciones"></select>
                                    <div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="mt-0 mb-1">Origen:</label>
                                            <select class="form-select" data-live-search="true" id="origen_reserva"
                                            name="origen_reserva"></select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mt-0 mb-1">Huesped Docuemnto:</label>
                                            <input onkeyup="searchHuesped()" type="text" id="identificacion"
                                            class="form-control" placeholder="N° Doc." name="identificacion">
                                        </div>
                                        <!-- <br> -->
                                        <div class="col-md-12">
                                            <label class="mt-0 mb-1">Huesped Titular:</label>
                                            <input type="text" id="huesped" class="form-control" placeholder="huesped"
                                            name="huesped">
                                        </div>
                                    </div>

<!--                                     
                                    <br>
                                    
                                    <br> -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="example-select" class="form-label">Correo
                                                    electronico:</label>
                                                <input type="text" id="correo" class="form-control" name="correo"
                                                    value="clientesvarios@gmail.com">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="example-select" class="form-label">Direccion:</label>
                                                <input type="text" id="direccion" class="form-control" name="direccion"
                                                    value="Direccion General">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="mt-0 mb-1">Habitaciones: <small id="n_habitaciones"><b>
                                                </b></small></label>
                                            <div id="habitaciones">
                                                <p class="font-13 text-muted" id="no_disp">Ninguna habitación seleccionada</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p id="precios">Precios:</p>
                                            <div id="precios-tarifa">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <input id="diasTotal" name="diasTotal" type="hidden">
                                    <input id="horasTotal" name="horasTotal" type="hidden">
                                    <input id="minutosTotal" name="minutosTotal" type="hidden">
                                    <input id="totales" type="hidden">
                                    <input id="total_reserva" name="total_reserva" type="hidden">
                                    <input id="total_habitacion" name="total_habitacion" type="hidden">
                                    <p>Total: <small id="total" style="margin-left:10%"></small>
                                    </p>
                                    <hr>
                                    <div style="text-align:center">
                                        <button id="btnActionForm" onclick="guardarReservacion()"
                                            class="btn btn-primary mb-2"> <span id="btnText">Reservar</span></button>
                                    </div>


                                </div>

                            </div>
                        </div>


                        <!----------------------PARTE DERECHAAAAAAAAAAAAAAAAA--------------->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row" id="foodroomsDays">
                                    </div>
                                    <div class="col-md-12" id="foodrooms">
                                    </div>
                                </div> <!-- end tab-content-->
                            </div>
                        </div>
                    </div>
            </div>
            </form>

        </div>

    </div>
    <!-- content -->
</div>
</div>

<script>
// Función para actualizar el valor mínimo de #salidaant
function actualizarFechaMinimaSalida() {
    var ingresoAntInput = document.getElementById("ingreso");
    var salidaAntInput = document.getElementById("salida");

    // Establecer el valor mínimo de salida como el valor seleccionado en ingreso
    salidaAntInput.min = ingresoAntInput.value;
}

// Asignar el evento onchange a #ingresoant
document.getElementById("ingreso").addEventListener("change", actualizarFechaMinimaSalida);
</script>
<script>
var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);
var today = now.getFullYear() + "-" + (month) + "-" + (day);
$("#ingreso").val(today);
</script>

<?php footerAdmin($data); ?>