<?php
$con = new Mysql();
$tipo_estadia = "SELECT estadia_dias_horas FROM configuracion WHERE id = 1";
$request_tipo_estadia = $con->buscar($tipo_estadia);
$estadia = $request_tipo_estadia['estadia_dias_horas'];
?>
<div class="wrapper">
    <div class="leftside-menu">

        <!-- LOGO -->
        <a onclick="openCreate();" class="logo text-center logo-light">
            <span class="logo-lg">
                <img src="<?= media(); ?>/images/logo-inverse.png" alt="" height="48">
            </span>
            <span class="logo-sm">
                <img src="<?= media(); ?>/images/logo_s.svg" alt="" height="40">
            </span>
        </a>

        <!-- LOGO -->
        <a onclick="openCreate();" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="<?= media(); ?>/images/logo-inverse.png" alt="" height="48">
            </span>
            <span class="logo-sm">
                <img src="<?= media(); ?>/images/logo_s.svg" alt="" height="40">
            </span>
        </a>

        <div class="h-100" id="leftside-menu-container" data-simplebar="">

            <!--- Sidemenu -->
            <ul class="side-nav">

                <!-- <li class="side-nav-title side-nav-item">Navigation</li> -->
                <li class="side-nav-item">
                    <br>
                    <a href="<?= base_url(); ?>/dashboard" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <!-- <span class="badge bg-success float-end">4</span> -->
                        <span> Dashboard </span>
                    </a>
                </li>

                <!-- <li class="side-nav-title side-nav-item">Operaciones</li> -->

                <li class="side-nav-item">
                    <a href="<?= base_url(); ?>/hospedar" class="side-nav-link">
                        <i class="uil-calender"></i>
                        <span> Hospedar </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarReservas" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> Reservas </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarReservas">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/reservations">Listar</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reservations/create">Crear</a>
                            </li>
                            <li>
                                <a target="_blank" href="<?= base_url(); ?>/reports/calendar">Agenda</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarVentas" aria-expanded="false" aria-controls="sidebarEmail" class="side-nav-link">
                        <i class="uil-envelope"></i>
                        <span> Ventas </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarVentas">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/sales">Listar</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/sales/crear">Crear</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarHabitaciones" aria-expanded="false" aria-controls="sidebarProjects" class="side-nav-link">
                        <i class="uil-briefcase"></i>
                        <span> Habitaciones </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarHabitaciones">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/rooms">Listar</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/rooms/create">Crear</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/categoryRoom">Categoria de habitaciones</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarTarifas" aria-expanded="false" aria-controls="sidebarTarifas" class="side-nav-link">
                        <i class="uil-print"></i>
                        <span> Tarifas </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarTarifas">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/tarifasRooms">Tarifas</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/priceRooms">Crear Precio Tarifas</a>
                            </li>
                            <!-- <li>
                                <a href="<?= base_url(); ?>/PriceRooms/priceDayHourRooms">Lista Precios</a>
                            </li> -->
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarCajas" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                        <i class="uil-clipboard-alt"></i>
                        <span> Cajas </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCajas">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/cashRegister">Listar</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/cashRegister/create">Crear</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/cashregistermovements">Movimientos</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarAlmacen" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                        <i class="uil-clipboard-alt"></i>
                        <span> Almacen </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAlmacen">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/almacen">Almacenes</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/producto">Productos</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/Producto/servicio">Servicios</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/storeHouseMovement">Movimientos</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/kardex">Kardex</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- <li class="side-nav-title side-nav-item">Procedimientos</li> -->

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false" aria-controls="sidebarPages" class="side-nav-link">
                        <i class="uil-copy-alt"></i>
                        <span> PSE </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarPages">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/reports/boletasales">Boletas de ventas</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reports/facturasales">Facturas de ventas</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reports/boletares">Boletas de reservas</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reports/facturares">Facturas de reservas</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                        <i class="uil-window"></i>
                        <span> Reportes </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/reports/rooms">Reporte de reservaciones</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reports/sales">Reporte de ventas</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reports/consumos">Reporte de consumos</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/reports/dayli">Cuadre diario</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="false" aria-controls="sidebarBaseUI" class="side-nav-link">
                        <i class="uil-box"></i>
                        <span> Configurar </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseUI">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>/pisoHabitacion">Salones</a>
                            </li>
                            <!-- <li>
                                <a href="<?= base_url(); ?>/categoryRoom">Categoria de habitaciones</a>
                            </li> -->
                            <!-- <li>
                                <a href="<?= base_url(); ?>/tarifasRooms">Tarifas de habitaciones</a>
                            </li> -->
                            <!-- <?php
                                    if ($estadia == 0) {
                                    ?>
                                <li>
                                    <a href="<?= base_url(); ?>/priceRooms">Precios tarifa de habitaciones</a>
                                </li>
                            <?php
                                    } else if ($estadia == 1) {
                            ?>
                                <li>
                                    <a href="<?= base_url(); ?>/PriceRooms/priceDayHourRooms">Precios dia y hora de habitaciones Old</a>
                                </li>
                            <?php
                                    } elseif ($estadia == 2) {
                            ?>
                                <li>
                                    <a href="<?= base_url(); ?>/PriceRooms/priceDayHourRooms">Precios dia y hora de habitaciones OLD</a>
                                </li>
                                <li>
                                    <a href="<?= base_url(); ?>/priceRooms">Precios tarifa de habitaciones</a>
                                </li>
                            <?php
                                    }
                            ?> -->
                            <li>
                                <a href="<?= base_url(); ?>/cateProduct">Categoria de productos</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/cateServicio">Categoria de servicios</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/turns">Turnos</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/rol">Roles y Permisos</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/users">Usuarios</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/medioPago">Medio de pago</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/turnOpening">Operaciones diarias</a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/configure">Configuraciones del sistema</a>
                            </li>

                        </ul>
                    </div>
                </li>

            </ul>

            <!-- Help Box -->

            <!-- end Help Box -->
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
</div>
</div>
<script>
    function openCreate() {
        location.href = base_url + "/dashboard";
    }
</script>