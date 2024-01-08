<?php 
 
//  $venta = $data['venta'];
//  $detalle = $data['detalle'];

$con = new Mysql();
$conf = "SELECT * FROM configuracion WHERE id = 1";
$request_conf = $con->buscar($conf);

$request = array();

$idreservacion = $_REQUEST['id'];
//  var_dump($idventa);

$sql = "SELECT r.id_reservacion, h.precio_dia, h.nombre_habitacion, h.precio_hora, r.tiempo, u.nombres, u.identificacion, r.total, DATE_FORMAT(r.created_at, '%d %M %Y ') as fecha, p.descripcion, r.descuento FROM reservaciones r  INNER JOIN reservaciones_payments p ON r.id_reservacion = p.reservacionid INNER JOIN habitacion h ON r.habitacion_id=h.idhabitacion INNER JOIN usuario u ON r.cliente = u.idusuario WHERE r.id_reservacion =  $idreservacion";
$requestVenta = $con->buscar($sql);
// var_dump($requestVenta);


$pagos_reservacion = "SELECT *, total as monto_pagado FROM reservaciones_payments WHERE reservacionid = $idreservacion order by id desc limit 1";
$request_pagos_reservacion = $con->buscar($pagos_reservacion);

// var_dump($requestVenta);
// var_dump($requestVenta['total']);
// var_dump($request_pagos_reservacion['monto_pagado']);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Venta</title>
    <link rel="icon" href="<?= media(); ?>/images/usqay-icon.svg" type="image/x-icon"/>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        .marca-agua{
            opacity: 90;
            position: relative;
        }
       
        table td, table th{
            font-size: 15px;
        }
        h4{
            margin-bottom: 0px;
        }

        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .productos td {
            text-align: center;
            font-size: 10px;
        }

        .productos .precio {
            text-align: right;
        }


        .wd33{
            width: 33.33%;
        }
        .tbl-trabajador{
            border: 1px solid #CCC;
            border-radius: 10px;
            padding: 5px;
        }
        .wd40{
            width: 40%;
        }
        .wd60{
            width: 60%;
        }
        .wd55{
            width: 55%;
        }
        .wd20{
            width: 20%;
        }
        .wd25{
            width: 25%;
        }

        .tbl-detalle-reserva{
            border-collapse: collapse;
        }

        .tbl-detalle-reserva thead th{
            padding: 5px;
            background-color: #CCC;
            color: black;
        }

        .tbl-detalle-reserva tbody td{
            border-bottom: 1px solid #CCC;
            padding: 5px;
        }

        .tbl-detalle-reserva tfoot td{
            padding: 5px;
        }

        .title {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 1px;
            margin-top: 1px;
        }

        .productos td {
            text-align: center;
            font-size: 12px;
        }

        .productos tfoot td {
                 font-size: 12px;
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
</head>
<body onload="imprimir()">
   <div style="text-align:center">
   <!--<img src="<?php echo media(); ?>/images/nice.png" alt="logo" style="height: 80px; width: 230px">-->
   <h2><strong><?= $request_conf['nombre_negocio'] ?></strong></h2>
   <h4><strong>EL QUINCHE</strong></h4>
    <p><h5>AIMACAÑA YAULI MIGUEL ARCENIO</h5></p>
    <p><?= $request_conf['direccion'] ?> <br>
    RUC: <?= $request_conf['ruc'] ?> <br>
    Telefono: <?= $request_conf['telefono'] ?> <br>
    Email: <?= $request_conf['correoElectronico'] ?>
    </p>
   </div>
   <hr>
   <p class="title"><b>NOTA DE VENTA </b></p>
   <p class="title"><b> <?php echo str_pad($requestVenta['id_reservacion'], 8, "0", STR_PAD_LEFT); ?></b></p>
   <hr>
   <table align="center">
      <tr>
          <td>Fecha de emision</td>
          <td>: <?php setlocale(LC_TIME, "spanish");
          echo strftime("%A, %d de %B de %Y");?></td>
      </tr>
      <tr>
          <td>Moneda</td>
          <td>: Soles</td>
      </tr>
      <tr>
          <td>Documento</td>
          <td>: <?php echo $requestVenta['identificacion'] ?></td>
      </tr>
      <tr>
          <td>Cliente</td>
          <td>: <?php echo $requestVenta['nombres'] ?></td>
      </tr>
   </table>

   <hr>
   <table align="center" class="productos">
        <thead>
			<tr>
				<th class="wd55"tyle="padding:4px;">Descripcion</th>
				<th class="wd15 text-center"tyle="padding:4px;">Precio</th>
				<th class="wd15 text-center"tyle="padding:4px;">Cantidad</th>
				<th class="wd15 text-center" style="padding:4px;">Total</th>
			</tr>
		</thead>
        <tbody>
              <!-- $subtotal = 0; -->
                <tr>
                <!-- <?php if(empty($requestVenta['descripcion'])): ?>
				<td><?php echo "Pago de reservacion"; ?></td>
                <?php else: ?>
                    <?php endif; ?> -->
                <td>Habitacion <?=  $requestVenta['nombre_habitacion']; ?></td>
				<td ><?= SMONEY.' '.formatMoney(($requestVenta['total']+$requestVenta['descuento'])) ?></td>
				<td class="text-center">1 </td>
				<td class="text-center"><?= SMONEY.' '.formatMoney($requestVenta['total']+$requestVenta['descuento']) ?></td> 
			    </tr>
        </tbody>
        <?php 
            $sql = "SELECT *, SUM(total_consumo) as total_consumo FROM consumos WHERE tipo_comprobante != 10 and reservaid = $idreservacion";
            $request_consumo = $con->buscar($sql);
            ?>
        <?php
          $reservacion = $_REQUEST['id'];
          if($reservacion != null){
            $sql = "SELECT dc.id_detalle_consumo, dc.consumoid, dc.cantidadActual, p.nombre, c.total_consumo, dc.precio_venta FROM consumos c INNER JOIN detalle_consumo dc ON c.idconsumo = dc.consumoid INNER JOIN producto p ON dc.idarticulo = p.idProducto WHERE c.tipo_comprobante != 10 and c.reservaid = $reservacion and dc.estado != 0";
            $request = $con->listar($sql);
            foreach($request as $consumo):
        
              $cantidad = $consumo['cantidadActual'];
              $nombre = $consumo['nombre'];
              $precio =  $consumo['cantidadActual']*$consumo['precio_venta'];
          ?>
             
              <tr>
                <td><?=$nombre?></td>
                <td>$ <?= $precio?></td>
                <td>  <?= $cantidad?></td>
                <td> $ <?= formatMoney($precio)?></td>
              </tr>
          <?php
            endforeach;
          }else{
          ?>

          <?php
          }
         ?>
          <?php $total_pago  = $requestVenta['total'] + $request_consumo['total_consumo']; ?>
         <tfoot>
             <tr>
				<td colspan="3" class="text-right" style="padding-top: 10px"><b>SUBTOTAL:</b></td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($total_pago / 110 * 100) ?></td>
			</tr>

            <tr>
				<td colspan="3" class="text-right"><b>IGV 10%:</b></td>
				<td class="text-right"><?= SMONEY.' '.formatMoney(($total_pago/110)*10) ?></td>
			</tr>
            <?php 
                if($requestVenta['descuento'] > 0){
            ?>
            <tr>
				<td colspan="3" class="text-right"><b>DESCUENTO: </b></td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($requestVenta['descuento']) ?></td>
			</tr>
            <?php } ?>
            <tr>
               
                <td colspan="3" class="text-right" ><b>TOTAL: </b></td>
                <td class="text-right"><?= SMONEY.' '.formatMoney( $total_pago ) ?></td>
            </tr>
         </tfoot>
   </table>
   <hr>
   <div class="text-center">
		<!-- <p> ¡ELITE Experiencias Sin Limites! </p> -->
        <p>Representacion impresa de un Ticket </p>
        <?php 
            $medios = "select * from reserva_medio_pago vm inner join reservaciones r on r.id_reservacion=vm.id_venta inner join medio_pago mp on mp.id=vm.mediopago where vm.id_venta = ".$requestVenta['id_reservacion'];
            $rquest_medios = $con->listar($medios);
            foreach($rquest_medios as $mediospago){
        ?>
        <p><b>FORMA DE PAGO:</b></p>
        <p><b><?= $mediospago['nombre']?></b></p>
       <?php } ?>
	</div>
    
</body>
</html>