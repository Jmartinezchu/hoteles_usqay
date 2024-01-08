
<?php 
  require_once("Libraries/Core/Mysql.php");
  $con = new Mysql();
  $yape = 0;
  $visa = 0;
  $mastercard = 0;
  $plin = 0;
  $efectivo = 0;
  $montoOpen = 0;
  $total_caja_day = 0;
  $reservacion_pagos = 0;
  $total_ventas_day = 0;
  $total_efectivo_day = 0;
  $transferencia = 0;
  $total_egresos_efectivo = 0;
  $total_egresos_visa = 0;
  $total_egresos_yape = 0;
  $total_egresos_plin = 0;
  $total_egresos_mastercard = 0;
  $total_egresos_transferencia = 0;
  $total_ingresos_day = 0;
  $total_egresos = 0;
  $total_egresos = 0;
  $utilidadCaja = 0;
  $total_egresos_cash = 0;


  $fechaInicio = date('Y-m-d');

  if(isset($_GET['fecha'])){
    $fechaInicio = $_GET['fecha'];
  }

  $conf = "SELECT * FROM configuracion WHERE id = 1";
  $request_confg = $con->buscar($conf);
  $fecha_cierre = $request_confg["fecha_cierre"];
  $hoy = $request_confg["fecha_cierre"];


  $medios_pago = "SELECT idmediopago,nombre FROM medio_pago WHERE estado != 0";
  $request_medios_pago = $con->listar($medios_pago);


  if(isset($_GET['fecha']) && !empty($_GET['fecha'])){
      $fecha_cierre = $_GET['fecha'];
  }

  $sql_caja = "SELECT * FROM caja";
  $request_caja = $con->listar($sql_caja);
  $wherein = "(";
  foreach ($request_caja as $c) {
        $wherein .= $c["id_caja"] . ",";
  }
  $wherein = substr($wherein, 0, -1);
  $wherein .= ")";

  $total_ventas = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 3 AND estado = 1 AND fecha = '".$fechaInicio."'";
  $request_ventas = $con->buscar($total_ventas);
  $total_ventas_day = $request_ventas['total'];

  $openMoney = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 1 and estado = 1 and fecha = '".$fechaInicio."'" ;
  $request_open = $con->buscar($openMoney);
  $montoOpen = $request_open["total"];


  $box_open = "SELECT * FROM movimiento_caja WHERE tipomovimientocaja_id = 1 and estado = 1 and fecha = '".$fechaInicio."'" ;
  $request_box_open = $con->buscar($box_open);


  $total_pago_reservacion = "SELECT SUM(monto) as reservacion FROM movimiento_caja WHERE tipomovimientocaja_id = 2 and estado = 1 and fecha = '".$fechaInicio."'";
  $request_reservacion = $con->buscar($total_pago_reservacion);
  $reservacion_pagos = $request_reservacion['reservacion'];
  
  $total_otro_tipo_ingreso = "SELECT SUM(monto) as ingresos FROM movimiento_caja WHERE tipomovimientocaja_id = 11 and estado = 1 and fecha = '".$fechaInicio."'";
  $request_ingresos = $con->buscar($total_otro_tipo_ingreso);
  $total_ingresos_day = $request_ingresos['ingresos'] ;

  $total_efectivo = "SELECT SUM(monto) as efectivo FROM movimiento_caja WHERE mediopagoid = 1 and descripcion = 'Pago de venta'  and fecha = '".$fechaInicio."'";
  $request_efectivo = $con->buscar($total_efectivo);
  $total_efectivo_reserv = "SELECT SUM(monto) as efectivo FROM movimiento_caja WHERE mediopagoid = 1 and descripcion = 'Pago de reservacion'  and fecha = '".$fechaInicio."'";
  $request_efectivo_reserv = $con->buscar($total_efectivo_reserv);
  $total_efectivo_day = $request_efectivo['efectivo'] + $request_efectivo_reserv['efectivo'];

  $efectivo_salidas = "SELECT SUM(monto) as efectivo_salidas FROM movimiento_caja WHERE mediopagoid = 1 and estado = 2 and fecha = '".$fechaInicio."'";
  $request_efectivo_salidas = $con->buscar($efectivo_salidas);
  $total_salidas_efectivo = $request_efectivo_salidas['efectivo_salidas'];

  $efectivoF =  $total_efectivo_day + $total_salidas_efectivo; 

  $efectivo_egresos = "SELECT SUM(monto) as egresos_efectivo FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and mediopagoid = 1 and fecha = '".$fechaInicio."'";
  $request_egresos_efectivo = $con->buscar($efectivo_egresos);
  $total_egresos_efectivo = $request_egresos_efectivo['egresos_efectivo'];

  $egresos_visa = "SELECT SUM(monto) as egresos_visa FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 2 and estado = 2 and fecha = '".$fechaInicio."'";
  $request_egresos_visa = $con->buscar($egresos_visa);
  $total_egresos_visa = $request_egresos_visa['egresos_visa'];

  $egresos_yape = "SELECT SUM(monto) as egresos_yape FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 5 and estado = 2 and fecha = '".$fechaInicio."'";
  $request_egresos_yape= $con->buscar($egresos_yape);
  $total_egresos_yape = $request_egresos_yape['egresos_yape'];

  $egresos_plin = "SELECT SUM(monto) as egresos_plin FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 6 and estado = 2 and fecha = '".$fechaInicio."'";
  $request_egresos_plin = $con->buscar($egresos_plin);
  $total_egresos_plin= $request_egresos_plin['egresos_plin'];

  $egresos_mastercard = "SELECT SUM(monto) as egresos_mastercard FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 5 and estado = 3 and fecha = '".$fechaInicio."'";
  $request_egresos_mastercard= $con->buscar($egresos_mastercard);
  $total_egresos_mastercard = $request_egresos_mastercard['egresos_mastercard'];

  $egresos_transferencia = "SELECT SUM(monto) as egresos_transferencia FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 4 and estado = 2 and fecha = '".$fechaInicio."'";
  $request_egresos_transferencia = $con->buscar($egresos_transferencia);
  $total_egresos_transferencia = $request_egresos_transferencia['egresos_transferencia'];

  $total_visa = "SELECT SUM(monto) as visa FROM movimiento_caja WHERE mediopagoid = 2  and fecha = '".$fechaInicio."'";
  $request_visa = $con->buscar($total_visa);
  $visa = $request_visa['visa'];

  $total_yape = "SELECT SUM(monto) as yape FROM movimiento_caja WHERE mediopagoid = 5  and fecha = '".$fechaInicio."'";
  $request_yape = $con->buscar($total_yape);
  $yape = $request_yape['yape'];

  $total_plin = "SELECT SUM(monto) as plin FROM movimiento_caja WHERE mediopagoid = 6  and fecha = '".$fechaInicio."'";
  $request_plin = $con->buscar($total_plin);
  $plin = $request_plin['plin'];

  $total_transferencia = "SELECT SUM(monto) as transferencia FROM movimiento_caja WHERE mediopagoid = 4  and fecha = '".$fechaInicio."'";
  $request_transferencia = $con->buscar($total_transferencia);
  $transferencia = $request_transferencia['transferencia'];
  

  $total_mastercard = "SELECT SUM(monto) as mastercard FROM movimiento_caja WHERE mediopagoid = 3   and fecha = '".$fechaInicio."'";
  $request_mastercard = $con->buscar($total_mastercard);
  $mastercard = $request_mastercard['mastercard'];
  


  $total_egresos = "SELECT SUM(monto) as egresos FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and estado = 2 and fecha = '".$fechaInicio."'";
  $request_egresos = $con->buscar($total_egresos);
  $total_egresos = $request_egresos['egresos'];


  $salidas = "SELECT SUM(monto) as salidas_dinero FROM movimiento_caja WHERE mediopagoid != 0 and estado = 2 and fecha ='".$request_confg["fecha_cierre"]."'";
  $request_salidas = $con->buscar($salidas);
  $total_salidas = $request_salidas['salidas_dinero'];

//   $total_cash_reservaciones = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 2";
//   $request_ventas = $con->buscar($total_cash_reservaciones);
//   $total_ventas_day = $request_ventas['total'];

  $total_caja_day = $reservacion_pagos + $total_ventas_day + $montoOpen +  $total_ingresos_day - abs($total_salidas);
  $total_ingresos = $total_ventas_day + $reservacion_pagos + $total_ingresos_day - abs($total_salidas);
  $utilidadCaja = $total_caja_day - abs($total_egresos) - abs($montoOpen);

//   $total_egresos_cash = $total_egresos + $total_egresos_efectivo + $total_egresos_plin + $total_egresos_visa + $total_egresos_yape; 
?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?= $data['page_title']?></title>
    <link rel="icon" href="<?= media(); ?>/images/usqay-icon.svg" type="image/x-icon"/>
</head>
<style>
            body,
            table{
                font-family: "Lucida Console", Monaco, monospace;
                line-height: 1.0 !important;             
            }
            
            body{
                font-size: 12px;
                font-weight: 200;
            }
            table{
                font-size: 12px;
                font-weight: 300;
            }
            body{
                zoom: 200%;
            }

            p{
                font-size: 11px;
            }
        </style>
<style type="text/css" media="print">
    @page {
        margin: 0;
    }
</style>
<script type="text/javascript">
            function imprimir() {
                if (window.print) {
                    window.print();
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
            }
        </script>
<body onload="imprimir()">
    <div style="text-align:center">
        <h4><strong><?= $request_confg['nombre_negocio'] ?></strong></h4>
          <p><?= $request_confg['direccion'] ?> <br>
        </p>
   </div>
   <hr>
     <p style="">Cajero: <?= $_SESSION['userData']['nombres']?> <br>
      Caja: Principal <br>
     Fecha: <?php echo $fecha_cierre; ?></p>
   <hr>
   <p style="font-size: 12px;margin-top: -5px;margin-bottom: 15px;">REPORTE CIERRE DE CAJA</p>
    <hr>
    
    <p>TOTALES</p>
    <p>EFECTIVO: <?= formatMoney(abs($efectivoF)) ?> <br>
       VISA: <?= formatMoney(abs($visa));?> <br>
       YAPE: <?= formatMoney(abs($yape));?> <br>
       PLIN: <?= formatMoney(abs($plin));?> <br>
       MASTERCARD: <?= formatMoney(abs($mastercard)); ?> <br>
       TRANSFERENCIA: <?= formatMoney(abs($transferencia)); ?><br>
    </p>

    <hr>
    <p>INGRESO VENTAS</p>
    <p>Resumen: <?= formatMoney(abs($total_ventas_day) - abs($total_salidas));?></p>
    <hr>
    <p>INGRESO RESERVACIONES</p>
    <?php 
                           if(empty($reservacion_pagos)){
                              $reservas = $reservacion_pagos;
                           }else{
                              $reservas = abs($reservacion_pagos) - abs($total_salidas); 
                           }
                        ?>
    <p>Resumen: <?= formatMoney(abs($reservas)) ?> </p>
    <hr>
    <p>INGRESOS ADICIONALES</p>
    <p>EFECTIVO: <?= formatMoney(abs($efectivoF)) ?> <br>
       VISA: <?= formatMoney(abs($visa));?> <br>
       YAPE: <?= formatMoney(abs($yape));?> <br>
       PLIN: <?= formatMoney(abs($plin));?> <br>
       MASTERCARD: <?= formatMoney(abs($mastercard)); ?> <br>
       TRANSFERENCIA: <?= formatMoney(abs($transferencia)); ?><br>
    </p>
    <hr>
    <p>EGRESOS</p>
    <p>EFECTIVO: <?= formatMoney(abs($total_egresos_efectivo))?> <br>
       VISA: <?= formatMoney(abs($total_egresos_visa));?> <br>
       YAPE: <?= formatMoney(abs($total_egresos_yape));?> <br>
       PLIN: <?= formatMoney(abs($total_egresos_plin));?> <br>
       MASTERCARD: <?= formatMoney(abs($total_egresos_mastercard)); ?> <br>
       TRANSFERENCIA: <?= formatMoney(abs($total_egresos_transferencia))?> <br>
    </p>
    <hr>
    <p>MONTO INICIAL</p>
    <p>Sol Peruano: <?= formatMoney($montoOpen);?> </p>
    <hr>
    <p>RESUMEN DE CAJA</p>
    <p>Utilidad en caja:  <?= formatMoney($utilidadCaja);?> <br>
       Total en caja: <?= formatMoney($total_caja_day);?> </p>

    <!-- <table align="center">
        <tr>
            <td>Total en caja</td>
            <td class="precio"><?= formatMoney($total_caja_day)?></td>
        </tr>
        <tr>
            <td>Utilidad en caja</td>
            <td class="precio"><?= formatMoney($utilidadCaja);?></td>
        </tr>
        <tr>
            <td>Total de ingresos</td>
            <td class="precio"><?= formatMoney($total_ingresos)?></td>
        </tr>
        <tr>
            <td>Total de egresos</td>
            <td class="precio"><?= formatMoney(abs($total_egresos_cash));?></td>
        </tr>
        <tr>
            <td>Monto inicial</td>
            <td class="precio"><?= formatMoney($montoOpen);?></td>
        </tr>
        <tr>
            <td>Pago de reservaciones</td>
            <td class="precio"></td>
        </tr>
        <tr>
            <td>Pago de ventas</td>
            <td class="precio"><?= formatMoney(abs($total_ventas_day));?></td>
        </tr>
        <tr>
            <td>Efectivo</td>
            <td class="precio"><?= formatMoney(abs($total_efectivo_day));?></td>
        </tr>
        <tr>
            <td>Visa</td>
            <td class="precio"><?= formatMoney(abs($visa));?></td>
        </tr>
        <tr>
            <td>Yape</td>
            <td class="precio"><?= formatMoney(abs($yape));?></td>
        </tr>
        <tr>
            <td>Plin</td>
            <td class="precio"><?= formatMoney(abs($plin));?></td>
        </tr>
    </table>
    <br>
    <br>

    <p class="title">IMPRESO POR: <?= $_SESSION['userData']['nombres']?></p>
    <br> -->
</body>
</html>
