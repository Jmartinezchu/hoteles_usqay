<?php
headerAdmin($data);
getModal("modalEstadoHabitacion", $data);
require_once("Libraries/Core/Mysql.php");
?>
<?php
$con = new Mysql();

$pisoUno = "SELECT * FROM piso_habitacion WHERE idpiso = 1";
$requestPisoUno = $con->buscar($pisoUno);

$habitacionUno = "SELECT * FROM habitacion WHERE idpiso = 1";
$requestHabitacionUno = $con->listar($habitacionUno);

$pisos = "SELECT idpiso, nombrepiso FROM piso_habitacion WHERE idpiso !=1";
$requestPisos = $con->listar($pisos);

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
                                        <li class="breadcrumb-item"><a
                                                href="<?= base_url(); ?>/Dashboard/dashboard">Inicio</a></li>
                                        <li class="breadcrumb-item active">Hospedar</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Hospedar</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <?php
                if ($requestPisoUno != null) {
                ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                        aria-selected="true"><?= $requestPisoUno['nombrepiso'] ?></button>
                                </li>
                                <?php
                } else {
                ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-0-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-0" type="button" role="tab" aria-controls="pills-0"
                                        aria-selected="true">Piso sin registrar</button>
                                </li>
                                <?php
                }
                ?>
                                <?php
                if ($requestPisos != null) {
                  foreach ($requestPisos as $varios) :
                ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-<?= $varios['idpiso'] ?>-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-<?= $varios['idpiso'] ?>"
                                        type="button" role="tab" aria-controls="pills-<?= $varios['idpiso'] ?>"
                                        aria-selected="false"><?= $varios['nombrepiso'] ?></button>
                                </li>
                                <?php
                  endforeach;
                }
                ?>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-<?= $requestPisoUno['idpiso'] ?>"
                                    role="tabpanel" aria-labelledby="pills-<?= $requestPisoUno['idpiso'] ?>-tab">
                                    <div class="row">
                                        <?php
                    if ($requestHabitacionUno != null) {
                      foreach ($requestHabitacionUno as $habitacionesPisoUno) :
                        $idHabitacion = $habitacionesPisoUno['idhabitacion'];
                        $nombreHabitacion = $habitacionesPisoUno['nombre_habitacion'];

                        $sql_categoria_habitacion = "SELECT c.nombre_categoria_habitacion FROM habitacion h INNER JOIN categoria_habitacion c ON h.categoriahabitacionid=c.id_categoria_habitacion WHERE h.idhabitacion =  $idHabitacion";
                        $request_categoria_habitacion = $con->buscar($sql_categoria_habitacion);

                        $datosReserva = "SELECT r.id_reservacion, h.nombre_habitacion, h.idhabitacion, e.nombre as estado_reserva, r.fecha_hora_checkIn FROM reservaciones r INNER JOIN reservaciones_estados e ON r.reservacion_estado_id = e.id_reservacionestado INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion WHERE h.idhabitacion =  $idHabitacion ORDER BY r.fecha_hora_checkIn DESC LIMIT 1";
                        $requestReserva = $con->buscar($datosReserva);
                        if ($requestReserva != null) {
                          $idReservacion = $requestReserva['id_reservacion'];
                        }

                        if ($habitacionesPisoUno['estado_habitacion'] == 'Disponible') {
                    ?>
                                        <div class="col-md-3" id="<?= $habitacionesPisoUno['idhabitacion'] ?>">
                                            <div class="card border-success border">
                                                <div class="card-body" style="text-align: center">
                                                    <!-- <h5 class="card-title text-success">00:00:00 </h5> -->


                                                    <h5 class="card-title text-success">
                                                        <?= $habitacionesPisoUno['estado_habitacion'] ?></h5>
                                                    <p class="card-text"> Categoria:
                                                        <b
                                                            class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text"> Habitación:
                                                        <b
                                                            class="card-title"><?= $habitacionesPisoUno['nombre_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $habitacionesPisoUno['capacidad'] ?></b>
                                                    </h4>
                                                    </p>
                                                    <a href="javascript: void(0);" class="btn btn-success btn-sm"
                                                        onclick="hospedarHabitacion(<?= $idHabitacion ?>,'<?= $nombreHabitacion ?>')">Reservar</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>

                                        <?php
                        } else if ($habitacionesPisoUno['estado_habitacion'] == 'Mantenimiento') {
                        ?>
                                        <div class="col-md-3" id="<?= $habitacionesPisoUno['idhabitacion'] ?>">
                                            <div class="card border-warning border">
                                                <div class="card-body" style="text-align: center">
                                                    <!-- <h5 class="card-title text-warning">00:00:00 </h5> -->
                                                    <h5 class="card-title text-warning">
                                                        <?= $habitacionesPisoUno['estado_habitacion'] ?></h5>
                                                    <p class="card-text"> Categoria:
                                                        <b
                                                            class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text">Habitación:
                                                        <b
                                                            class="card-title"><?= $habitacionesPisoUno['nombre_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $habitacionesPisoUno['capacidad'] ?></b>
                                                    </h4>

                                                    <!-- <br> -->
                                                    </p>


                                                    <a href="javascript: void(0);" class="btn btn-warning btn-sm"
                                                        onclick="cambiarEstadoHabitacion(<?= $idHabitacion ?>)">Habilitar</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>
                                        <?php
                        } else if ($habitacionesPisoUno['estado_habitacion'] == 'Ocupada' &&  $requestReserva['estado_reserva'] == 'Checked In') {
                        ?>
                                        <div class="col-md-3" id="<?= $habitacionesPisoUno['idhabitacion'] ?>">
                                            <div class="card border-danger border"
                                                style="max-height: 250px; min-height: 216px;">
                                                <div class="card-body" style="text-align: center">

                                                    <div timer-room="<?= $requestReserva['fecha_hora_checkIn'] ?>"
                                                        identificador="<?= $habitacionesPisoUno['idhabitacion'] ?>"
                                                        estado="<?= $requestReserva['estado_reserva'] ?>"
                                                        id="stopwatch<?= $habitacionesPisoUno['idhabitacion'] ?>"
                                                        class="stopwatch card-title text-danger"> <b>00:00:00</b></div>
                                                    <h5 class="card-title text-danger">
                                                        <?= $habitacionesPisoUno['estado_habitacion'] ?></h5>

                                                    <!-- <p class="card-text"> Categoria: 
                                      <b class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                    </p> -->
                                                    <p class="card-text">Habitación:
                                                        <b
                                                            class="card-title"><?= $habitacionesPisoUno['nombre_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $habitacionesPisoUno['capacidad'] ?></b>
                                                    </h4>
                                                    </p>
                                                    <a href="javascript: void(0);" class="btn btn-danger btn-sm"
                                                        onclick="verReserva(<?= $idReservacion ?>)">Ver</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>

                                        <?php
                        } else if ($habitacionesPisoUno['estado_habitacion'] == 'Ocupada') {
                        ?>
                                        <div class="col-md-3" id="<?= $habitacionesPisoUno['idhabitacion'] ?>">
                                            <div class="card border-danger border"
                                                style="max-height: 250px; min-height: 216px;">
                                                <div class="card-body" style="text-align: center">
                                                    <h5 class="card-title text-danger">
                                                        <?= $habitacionesPisoUno['estado_habitacion'] ?></h5>

                                                    <p class="card-text"> Categoria:
                                                        <b
                                                            class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                                    </p>
                                                    <p class="card-text">Habitación:
                                                        <b
                                                            class="card-title"><?= $habitacionesPisoUno['nombre_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $habitacionesPisoUno['capacidad'] ?></b>
                                                    </h4>

                                                    </p>
                                                    <a href="javascript: void(0);" class="btn btn-danger btn-sm"
                                                        onclick="verReserva(<?= $requestReservacion['id_reservacion'] ?>)">Ver</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>
                                        <?php
                        }
                      endforeach;
                    } else {
                      ?>
                                        <div class="col-md-3">
                                            <div class="card border-danger border">
                                                <div class="card-body" style="text-align: center">
                                                    <h5 class="card-title text-info">No hay habitaciones</h5>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-body-->
                                        <?php
                    }
                    ?>
                                    </div>
                                    <!-- end-row -->
                                </div>
                                <!-- end-div-habitaciones-del-piso-1 -->
                                <?php
                foreach ($requestPisos as $varios) :
                  $idPiso = $varios['idpiso'];
                  $habitaciones = "SELECT * FROM habitacion WHERE idpiso = $idPiso";
                  $requestHabitaciones = $con->listar($habitaciones);
                ?>
                                <div class="tab-pane fade" id="pills-<?= $varios['idpiso'] ?>" role="tabpanel"
                                    aria-labelledby="pills-<?= $varios['idpiso'] ?>-tab">
                                    <div class="row">
                                        <?php
                      if ($requestHabitaciones != null) {
                        foreach ($requestHabitaciones as $variasHabitaciones) :
                          $idHabitacion = $variasHabitaciones['idhabitacion'];
                          $reservaciones = "SELECT * FROM reservaciones WHERE habitacion_id = $idHabitacion";
                          $requestReservacion = $con->buscar($reservaciones);

                          $sql_categoria_habitacion = "SELECT c.nombre_categoria_habitacion FROM habitacion h INNER JOIN categoria_habitacion c ON h.categoriahabitacionid=c.id_categoria_habitacion WHERE h.idhabitacion =  $idHabitacion";
                          $request_categoria_habitacion = $con->buscar($sql_categoria_habitacion);
                          $datosReserva = "SELECT  r.id_reservacion, h.nombre_habitacion, h.idhabitacion, e.nombre as estado_reserva, r.fecha_hora_checkIn FROM reservaciones r INNER JOIN reservaciones_estados e ON r.reservacion_estado_id = e.id_reservacionestado INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion WHERE idhabitacion =  $idHabitacion ORDER BY r.fecha_hora_checkIn DESC LIMIT 1";
                          $requestReserva = $con->buscar($datosReserva);

                          if ($requestReserva != null) {
                            $idReservacion = $requestReserva['id_reservacion'];
                          }

                          if ($variasHabitaciones['estado_habitacion'] == 'Disponible') {
                      ?>
                                        <div class="col-md-3" id="<?= $variasHabitaciones['idhabitacion'] ?>">
                                            <div class="card border-success border">
                                                <div class="card-body" style="text-align: center">
                                                    <!-- <h5 class="card-title text-success">00:00:00 </h5> -->


                                                    <h5 class="card-title text-success">
                                                        <?= $variasHabitaciones['estado_habitacion'] ?></h5>

                                                    <p class="card-text"> Categoria:
                                                        <b
                                                            class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text"> Habitación:
                                                        <b
                                                            class="card-title"><?= $variasHabitaciones['nombre_habitacion'] ?></b>
                                                    </p>
                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $variasHabitaciones['capacidad'] ?></b>
                                                    </h4>

                                                    <br>
                                                    </p>


                                                    <a href="javascript: void(0);" class="btn btn-success btn-sm"
                                                        onclick="hospedarHabitacion(<?= $idHabitacion ?>,'<?= $variasHabitaciones['nombre_habitacion'] ?>')">Reservar</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>
                                        <?php
                          } else if ($variasHabitaciones['estado_habitacion'] == 'Mantenimiento') {
                          ?>
                                        <div class="col-md-3" id="<?= $variasHabitaciones['idhabitacion'] ?>">
                                            <div class="card border-warning border">
                                                <div class="card-body" style="text-align: center">
                                                    <!-- <h5 class="card-title text-warning">00:00:00 </h5> -->
                                                    <h5 class="card-title text-warning">
                                                        <?= $variasHabitaciones['estado_habitacion'] ?></h5>
                                                    <p class="card-text"> Categoria:
                                                        <b
                                                            class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                                    </p>

                                                    <p class="card-text">Habitación:
                                                        <b
                                                            class="card-title"><?= $variasHabitaciones['nombre_habitacion'] ?></b>
                                                    </p>
                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $variasHabitaciones['capacidad'] ?></b>
                                                    </h4>

                                                    <br>
                                                    </p>


                                                    <a href="javascript: void(0);" class="btn btn-warning btn-sm"
                                                        onclick="cambiarEstadoHabitacion(<?= $variasHabitaciones['idhabitacion'] ?>)">Habilitar</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>
                                        <?php
                          } else if ($variasHabitaciones['estado_habitacion'] == 'Ocupada' &&  $requestReserva['estado_reserva'] == 'Checked In') {
                          ?>
                                        <div class="col-md-3" id="<?= $variasHabitaciones['idhabitacion'] ?>">
                                            <div class="card border-danger border"
                                                style="max-height: 250px; min-height: 216px;">
                                                <div class="card-body" style="text-align: center">

                                                    <div timer-room="<?= $requestReserva['fecha_hora_checkIn'] ?>"
                                                        identificador="<?= $variasHabitaciones['idhabitacion'] ?>"
                                                        estado="<?= $requestReserva['estado_reserva'] ?>"
                                                        id="stopwatch<?= $variasHabitaciones['idhabitacion'] ?>"
                                                        class="stopwatch card-title text-danger"> <b>00:00:00</b></div>
                                                    <h5 class="card-title text-danger">
                                                        <?= $variasHabitaciones['estado_habitacion'] ?></h5>

                                                    <!-- <p class="card-text"> Categoria: 
                                      <b class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                    </p> -->

                                                    <p class="card-text">Habitación:
                                                        <b
                                                            class="card-title"><?= $variasHabitaciones['nombre_habitacion'] ?></b>
                                                    </p>
                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $variasHabitaciones['capacidad'] ?></b>
                                                    </h4>
                                                    </p>
                                                    <a href="javascript: void(0);" class="btn btn-danger btn-sm"
                                                        onclick="verReserva(<?= $idReservacion ?>)">Ver</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>
                                        <?php
                          } else if ($variasHabitaciones['estado_habitacion'] == 'Ocupada') {
                          ?>
                                        <div class="col-md-3" id="<?= $variasHabitaciones['idhabitacion'] ?>">
                                            <div class="card border-danger border"
                                                style="max-height: 250px; min-height: 216px;">
                                                <div class="card-body" style="text-align: center">
                                                    <h5 class="card-title text-danger">
                                                        <?= $variasHabitaciones['estado_habitacion'] ?></h5>
                                                    <p class="card-text"> Categoria:
                                                        <b
                                                            class="card-title"><?= $request_categoria_habitacion['nombre_categoria_habitacion'] ?></b>
                                                    </p>
                                                    <p class="card-text">Habitación:
                                                        <b
                                                            class="card-title"><?= $variasHabitaciones['nombre_habitacion'] ?></b>
                                                    </p>
                                                    <p class="card-text">
                                                    <h4>
                                                        <i class="dripicons-user-group">
                                                        </i><b
                                                            class="card-title"><?= $variasHabitaciones['capacidad'] ?></b>
                                                    </h4>

                                                    </p>
                                                    <a href="javascript: void(0);" class="btn btn-danger btn-sm"
                                                        onclick="verReserva(<?= $idReservacion ?>)">Ver</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div>
                                        <?php
                          }
                        endforeach;
                      } else {
                        ?>
                                        <div class="col-md-3">
                                            <div class="card border-danger border">
                                                <div class="card-body" style="text-align: center">
                                                    <h5 class="card-title text-info">No hay habitaciones</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                      }
                      ?>
                                    </div>

                                </div>
                                <!-- end-row -->
                                <?php
                endforeach;
                ?>
                            </div>
                            <!-- end div -->


                        </div>
                    </div>
                </div>
                <!-- end-card -->


            </div>
        </div>
    </div>
    </div>
</main>

<?php footerAdmin($data); ?>