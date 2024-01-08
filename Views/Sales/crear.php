<?php headerAdmin($data);

?>
<main>

    
<div class="wrapper">
<div class="content-page">
<?php require_once("Libraries/Core/Open.php");
    $con = new Mysql();

    $productos = "SELECT d.idmovimiento_producto,d.productoid, p.nombre, p.precio_venta, a.nombre_almacen,sum(d.cantidad) as stock, (d.cantidad*p.precio_venta) as subtotal FROM movimiento_producto d INNER JOIN producto p on d.productoid = p.idProducto INNER JOIN almacen a ON d.almacenid = a.idalmacen INNER JOIN categoria_producto c ON p.categoriaid = c.idcategoria WHERE unidadMedida = 'NIU' GROUP BY p.nombre";
    $requestProductos = $con->listar($productos);
    
    $servicios = "SELECT p.idProducto, p.nombre, c.descripcion, p.precio_venta FROM producto p INNER JOIN categoria_servicio c ON p.categoriaid = c.idcategoria WHERE p.unidadMedida = 'ZZ' AND p.nombre != 'AUMENTO DE ESTADIA' AND p.nombre != 'SERVICIO DE HOSPEDAJE' GROUP BY p.nombre";
    $requestServicio = $con->listar($servicios);


?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Dashboard/dashboard">Inicio</a></li>
                                    <li class="breadcrumb-item active">Ventas</li>
                                    <li class="breadcrumb-item active">Crear</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Ventas</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->
                <form id="formSale" name="formSale">
                <input type="hidden" id="idventa" name="idventa">
                <input type="hidden" id="User" name="User" value="<?php echo $_SESSION['userData']['nombres']?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class= "col-lg 6">
                                            <div class="mb-3">
                                                <label for="example-placeholder" class="form-label">Identificacion:</label>
                                                <input onkeyup="searchHuesped();" type="text" id="identificacion" class="form-control" placeholder="Ingrese el n° de documento"
                                                name="identificacion" value="11111111">
                                            </div>
                                        </div>
                                        <div class= "col-lg 6">
                                            <div class="mb-3">
                                                <label for="example-placeholder" class="form-label">Nombre del cliente:</label>
                                                <input type="text" id="nombre_cliente" class="form-control" placeholder="Ingrese el nombre del cliente"
                                                name="nombre_cliente" value="CLIENTES VARIOS">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class= "col-lg 6">
                                            <div class="mb-3">
                                                <label for="example-placeholder" class="form-label">Correo del cliente:</label>
                                                <input type="text" id="correo" class="form-control" placeholder="Ingrese el email"
                                                name="correo" value="clientesvarios@gmail.com">
                                            </div>
                                        </div>
                                        <div class= "col-lg 6">
                                            <div class="mb-3">
                                                <label for="example-placeholder" class="form-label">Direccion del cliente:</label>
                                                <input type="text" id="direccion" class="form-control" placeholder="Ingrese la direccion"
                                                name="direccion" value="Direccion General">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Productos</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Servicios</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div data-simplebar style="max-height: 273px;">
                                                <div class="table-responsive" style="overflow-x:hidden">
                                                    <div class="row">
                                                        <p>
                                                        <?php
                                                            if($requestProductos != null){
                                                                foreach ($requestProductos as $producto):
                                                                    $idProducto = $producto['productoid'];
                                                                    $nombreProducto = $producto['nombre'];
                                                                    $stock = $producto['stock'];
                                                                    $precioVenta = $producto['precio_venta'];
                                                                if($stock>0){
                                                        ?>
                                                        <div class="col-md-5 col-lg-3">
                                                            <div class="card border-info border" style="background-color: #ffff;">
                                                                <div class="card">
                                                                    <br>
                                                                    <div style= "text-align: center">
                                                                        <h5 class="card-title "><b>S/ <?= $precioVenta?></b></h5>
                                                                    </div>
                                                                    <div style= "text-align: center">
                                                                        <h5 class="card-title text-dark"><?= $nombreProducto?></h5>
                                                                        <p class="card-text"> Stock: 
                                                                            <b class="card-title text-dark"><?= $stock?></b>
                                                                        </p>
                                                                        <a class="btn btn-info mt-2 stretched-link" onclick="agregarProducto(<?= $idProducto?>, '<?= $nombreProducto?>', <?= $precioVenta?>)"><i class="dripicons-plus" ></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            }
                                                                endforeach;
                                                            }else{
                                                        ?>
                                                        <div class="col-md-5 col-lg-3">
                                                            <div class="card border-info border">
                                                                <div class="card-body">
                                                                    <br>
                                                                    <div style= "text-align: center">
                                                                        <h5 class="card-title text-dark">No hay Productos</h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div data-simplebar style="max-height: 273px;">
                                                <div class="table-responsive" style="overflow-x:hidden">
                                                    <div class="row">
                                                        <p>
                                                        <?php
                                                            if($requestServicio != null){
                                                                foreach ($requestServicio as $producto):
                                                                    $idProducto = $producto['idProducto'];
                                                                    $nombreProducto = $producto['nombre'];
                                                                    $precioVenta = $producto['precio_venta'];
                                                        ?>
                                                        <div class="col-md-5 col-lg-3">
                                                            <div class="card border-info border" style="background-color: #ffff;">
                                                                <div class="card">
                                                                    <br>
                                                                    <div style= "text-align: center">
                                                                        <h5 class="card-title "><b>S/ <?= $precioVenta?></b></h5>
                                                                    </div>
                                                                    <div style= "text-align: center">
                                                                        <h5 class="card-title text-dark"><?= $nombreProducto?></h5>
                                                                        <a class="btn btn-info mt-2 stretched-link" onclick="agregarProducto(<?= $idProducto?>, '<?= $nombreProducto?>', <?= $precioVenta?>)"><i class="dripicons-plus" ></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                                endforeach;
                                                            }else{
                                                        ?>
                                                        <div class="col-md-5 col-lg-3">
                                                            <div class="card border-info border">
                                                                <div class="card-body">
                                                                    <br>
                                                                    <div style= "text-align: center">
                                                                        <h5 class="card-title text-dark">No hay servicio</h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>      
                                        </div>
                                    </div>
                                </div>
                            </div>        
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class=row >
                                        <div data-simplebar style="max-height: 164px;">
                                            <div class="table-responsive" >
                                            <table id="detalles" class="table table-sm table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Opción</th>
                                                        <th>Producto</th>
                                                        <th>Cant.</th>
                                                        <th>Precio</th>
                                                        <th>Importe</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            </div>      
                                        </div>
                                        <hr>
                                        <div class="col">
                                            <strong>SubTotal: </strong><span id="subtotal"></span><input type="hidden" name="subtotal_venta" id="subtotal_venta">
                                        </div>
                                        <div class="col">
                                            <strong>IGV(10%): </strong><span id="impuestos"></span><input type="hidden" name="impuestos_venta" id="impuestos_venta">
                                        </div>
                                        <div class="col">
                                            <strong >Total: </strong><span id="total"></span><input type="hidden" name="total_venta" id="total_venta"></span>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select  class="form-select"  data-live-search="true" id="medio_pago" name="medio_pago" placeholder="Medio pago">
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="montoPago" name="montoPago" class="form-control" placeholder="Monto"> &nbsp;&nbsp;
                                        </div>
                                        <div class="col-md-4">
                                            <button onclick="agregarPago();" type="button" id="btnAgregarPago" class="btn btn-light btn-sm">AGREGAR</button>
                                        </div>
                                        <div data-simplebar style="max-height: 150px;">
                                            <div style="display:none" id="tablamediopago">
                                                <div class="table-responsive">
                                                    <table id="detallesPago" class="table table-sm table-centered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Eliminar</th>
                                                                <th>Medio de Pago</th>
                                                                <th>Editar Monto</th>
                                                                <th>Monto a Pagar</th>
                                                            </tr>
                                                        </thead>                     
                                                        <tfoot>
                                                            <input type="hidden" id="total_pago" name="total_pago"> &nbsp;&nbsp;
                                                        </tfoot>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button onclick="pagar(1);" type="button" id="btnFactura" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> FACTURA</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button onclick="pagar(2);" type="button" id="btnBoleta" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> BOLETA</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button onclick="pagar(3);" type="button" id="btnTicket" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> TICKET</button>
                                        </div>
                                    </div>
                                </div>
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
    var now = new Date();
    var day =("0"+now.getDate()).slice(-2);
    var month=("0"+(now.getMonth()+1)).slice(-2);
    var today=now.getFullYear()+"-"+(month)+"-"+(day);
    $("#ingreso").val(today);
</script>
<?php footerAdmin($data); ?>