<?php 
 
$con = new Mysql();
$conf = "SELECT * FROM configuracion WHERE id = 1";
$request_conf = $con->buscar($conf);

$request = array();

$idventa = $_REQUEST['id'];
//  var_dump($idventa);

$sql = "SELECT v.idventa, v.clienteid, u.identificacion, u.nombres, v.subtotal, v.total_impuestos, DATE_FORMAT(v.created_at, '%d %M %Y ') as fecha, e.nombre, tc.descripcion, v.usuario FROM venta v  INNER JOIN ventas_estado e ON v.venta_estado_id = e.id_venta_estado INNER JOIN tipo_comprobante_sunat tc ON v.tipo_comprobante = tc.id_tipo_comprobante
INNER JOIN usuario u ON v.clienteid = u.idusuario
WHERE v.idventa =  $idventa";

$requestVenta = $con->buscar($sql);
if(!empty($requestVenta))
{
    $sql_detalle = "SELECT d.id_detalle_venta, d.ventaid, p.nombre, d.cantidad, d.precio_venta FROM detalle_venta d 
    INNER JOIN producto p ON d.idarticulo = p.idProducto
    INNER JOIN venta v ON d.ventaid = v.idventa
    WHERE d.ventaid = $idventa";
    $requestProductos = $con->listar($sql_detalle);
    $request = array(
                        'venta' => $requestVenta,
                        'detalle' => $requestProductos
                    );
    
}
$venta = $request['venta'];
$detalle = $request['detalle'];

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
        <p><?= $request_conf['direccion'] ?> <br>
        RUC: <?= $request_conf['ruc'] ?> <br>
        Telefono: <?= $request_conf['telefono'] ?> <br>
        Email: <?= $request_conf['correoElectronico'] ?>
        </p>
    </div>
    <hr>
    <p class="title">BOLETA DE VENTA ELECTRONICA</p>
    <p class="title"><b><?= $request_conf['serie_boleta']; ?> - <?php echo str_pad($venta['idventa'], 8, "0", STR_PAD_LEFT); ?></b></p>
    <p class="title"><?php echo $venta['fecha'] ?></p>
    <hr>
    <table align="center">
        <tr>
            <td>Fecha de emision</td>
            <td>: <?php echo $venta['fecha'] ?></td>
        </tr>
        <tr>
            <td>Moneda</td>
            <td>: Soles</td>
        </tr>
        <tr>
            <td>RUC</td>
            <td>: <?php echo $venta['identificacion'] ?></td>
        </tr>
        <tr>
            <td>RAZON</td>
            <td>: <?php echo $venta['nombres'] ?></td>
        </tr>
   </table>
   <hr>

   <table align="center" class="productos">
        <thead>
			<tr>
				<th class="wd55">Producto</th>
				<th class="wd15 text-right">Precio</th>
				<th class="wd15 text-center">Cantidad</th>
				<th class="wd15 text-right">Importe</th>
			</tr>
		</thead>
        <tbody>
           <?php 
              $subtotal = 0;
              foreach($detalle as $producto){
                  $importe = $producto['precio_venta'] * $producto['cantidad'];
                  $subtotal = $subtotal + $importe;
                ?>
                <tr>
				<td><?= $producto['nombre'] ?></td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($producto['precio_venta']) ?></td>
				<td class="text-center"><?= $producto['cantidad'] ?></td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($importe) ?></td>
			</tr>
              <?php } ?>
        </tbody>
        <tfoot>
			<tr>
				<td colspan="3" class="text-right">GRAVADA:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($venta['subtotal']) ?></td>
			</tr>

            <tr>
				<td colspan="3" class="text-right">I.G.V:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($venta['total_impuestos']) ?></td>
			</tr>
		
			<tr>
				<td colspan="3" class="text-right">Total:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($subtotal); ?></td>
			</tr>
		</tfoot>
   </table>
   <div class="text-center">
		<p>Usted ha sido atendido por <?= $venta['usuario']?> <br> ¡Gracias por su Preferencia! </p>
        <p>Representacion impresa de la BOLETA DE VENTA ELECTRONICA</p>
        <p>Para ver el documento visita https://usqay.pse.pe</p>
        <p>Autorizado por la SUNAT mediante Resolucion de Intendencia No. <b>034-0050005315</b></p>
        <br>
        <p><b>USQAY</b>, es Facturacion Electronica <br>Visitanos en www.sistemausaqy.com o www.facebook.com/UsqayPeru</p>
        <?php 
            $medios = "select * from venta_medio_pago vm inner join venta v on v.idventa = vm.mediopago inner join medio_pago mp on mp.idmediopago=vm.mediopago where vm.id_venta = ".$requestVenta['idventa'];
            $rquest_medios = $con->listar($medios);
            foreach($rquest_medios as $mediospago){
        ?>
        <p><b>FORMA DE PAGO:</b></p>
        <p><b><?= $mediospago['nombre']?></b></p>
       <?php } ?>
	</div>


    <?php
       $code_qr = "".$request_conf['ruc']." | 03** | ".$request_conf['serie_boleta']." |".str_pad($venta['idventa'], 8, "0", STR_PAD_LEFT)." | ".$venta['total_impuestos']." | ".$subtotal." | ".date("d/m/Y")." | 1* | ".$venta['clienteid']." | ";

    //    var_dump($code_qr);
    ?>

    <center>
        <img src="<?= base_url() ?>/prints/qrgen?data=<?= urlencode($code_qr) ?>" style="width:130px !important;" alt="<?= base_url() ?>/prints/qrgen.php?data=<?php echo urlencode($code_qr) ?>">
    </center>

</body>
</html>