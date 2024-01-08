<?php 

$con = new Mysql();
$id = $_GET['id'];
$consumo = "SELECT * FROM consumos c INNER JOIN reservaciones r ON r.id_reservacion=c.reservaid LEFT JOIN habitacion h ON r.habitacion_id=h.idhabitacion WHERE C.idconsumo =  $id";
$request_consumo = $con->buscar($consumo);

$id_producto = "";
$habitacion = "";
$usuario = "";

$id_consumo = $request_consumo['idconsumo'];
$habitacion = $request_consumo['nombre_habitacion'];
$usuario = $request_consumo['usuario'];
// var_dump($habitacion);


$request = array();
$sql = "SELECT * FROM consumos c INNER JOIN reservaciones r ON r.id_reservacion=c.reservaid LEFT JOIN habitacion h ON r.habitacion_id=h.idhabitacion WHERE C.idconsumo = $id";
$requestConsumo = $con->buscar($sql);
if(!empty($requestConsumo))
{
    $sql_detalle = "SELECT d.id_detalle_consumo, d.consumoid, p.nombre, d.cantidad, d.precio_venta FROM detalle_consumo d 
    INNER JOIN producto p ON d.idarticulo = p.idProducto
    INNER JOIN consumos c ON d.consumoid = c.idconsumo
    WHERE d.consumoid = $id";
    $requestProductos = $con->listar($sql_detalle);
    $request = array(
        'consumo' => $requestConsumo,
        'detalle' => $requestProductos
    );
}

$consumos = $request['consumo'];
$detalle = $request['detalle'];


?>

<!DOCTYPE html>
<html lang="es  ">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMANDA</title>
    <style>
            body{
                zoom: 200%;
            }
            .micnf {
                font-family: Arial;
                font-size: 160%;
                font-weight: bold;     
                word-wrap: break-word !important;
                width: 100%;
                display:flex;
            }
            
            .micnf1 {
                font-family: Arial;
                font-size: 14px;
                font-weight: bold;
                word-break: break-all !important;
                width: 100%;
            }
            
            .micnf2 {
                font-family: Arial;
                font-size: 140%;
                font-weight: bold;
                word-wrap: break-word !important;
                width: 100%;
            }

            .txt-center{
                text-align: center;
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
<body onload="imprimir()" style="font-family: sans-serif; margin:0px !important;">
<div class="txt-center micnf2">PEDIDO</div>
<div class="txt-center micnf2"><?php echo "N° " . $id_consumo; ?></div>
<div class="txt-center micnf2"><?php echo "HABITACION ".$request_consumo['nombre_habitacion']; ?></div>
<div style="display:flex">
<div class="txt-center micnf2" style="font-size:18px">MOZO: <?php echo $usuario;?></div>
</div>
<br>
<div class="txt-center">
    <div style="float:right;width:50%;"><?php echo date('d/m/Y'); ?></div>
    <div style="float:left;width:50%;"><?php echo date('h:i:s'); ?></div>
</div>
<br>
<div class="txt-center">
    <div style="float:left;width:15%;">Cant</div>
    <div style="float:right;width:85%;">Producto</div>
    <hr class="hr-detalle"/>
</div>
<?php 
  $subtotal = 0;
  foreach($detalle as $producto):
    $importe = $producto['precio_venta']*$producto['cantidad'];
    $subtotal = $subtotal + $importe;

?>
<div class="txt-center micnf" style="margin-top:10px;">
    <div style="float:left; width: 15%;font-size:15px"><?php echo (integer) $producto["cantidad"]; ?></div>
    <div style="float:right; width: 85%; font-size:15px"><?php echo $producto['nombre']; ?></div>
</div>
<?php endforeach ?>
</body>
</html>