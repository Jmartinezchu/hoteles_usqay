<?php 
 
 $venta = $data['venta'];
 $detalle = $data['detalle'];

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
            font-size: 10px;
        }

        .productos .precio {
            text-align: right;
        }
    </style>
</head>
<body>

<!-- <?php dep($data); ?> -->
   <div style="text-align:center">
   <img src="<?php echo media(); ?>/images/logo.png" alt="logo" style="height: 80px; width: 230px">
   <h4><strong><?= NOMBRE_EMPRESA ?></strong></h4>
    <p><?= DIRECCION ?> <br>
    RUC: <?= RUC_EMPRESA ?> <br>
    Telefono: <?= TELEFONO_EMPRESA ?> <br>
    Email: <?= EMAIL_EMPRESA ?>
    </p>
   </div>
   <hr>
   <p class="title"><b>Venta - <?php echo str_pad($venta['idventa'], 8, "0", STR_PAD_LEFT) ?></b></p>
   <hr>
   <table align="center">
      <tr>
          <td>Fecha de emision</td>
          <td>: <?php echo $venta['fecha'] ?></td>
      </tr>
      <tr>
          <td>Cédula</td>
          <td>: <?php echo $venta['identificacion'] ?></td>
      </tr>
      <tr>
          <td>Cliente</td>
          <td>: <?php echo $venta['nombres'] ?></td>
      </tr>
   </table>

   <hr>
   <table align="center" class="tbl-detalle">
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
				<td colspan="3" class="text-right">Subtotal:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($subtotal) ?></td>
			</tr>
		
			<tr>
				<td colspan="3" class="text-right">Total:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($subtotal); ?></td>
			</tr>
		</tfoot>
   </table>
   <div class="text-center">
		<p>Usted ha sido atendido por <?= $venta['usuario']?> <br> ¡Gracias por su Preferencia! </p>
        <p>Representacion impresa de un Ticket <br> el cual puede canjear por un
        comprobante electronico</p>
        <p>Usqay, es Facturacion Electronica <br> visitanos en www.sistemausqay.com <br> o www.facebook.com/UsqayPeru</p>
	</div>
    
</body>
</html>