<?php 
$idreservacion = $_GET['id'];
$con = new Mysql();

$productos = "SELECT d.idmovimiento_producto,d.productoid, p.nombre, c.descripcion, p.precio_venta, a.nombre_almacen, sum(d.cantidad) as stock, (d.cantidad*p.precio_venta) as subtotal FROM movimiento_producto d INNER JOIN producto p on d.productoid = p.idProducto INNER JOIN almacen a ON d.almacenid = a.idalmacen INNER JOIN categoria_producto c ON p.categoriaid = c.idcategoria GROUP BY p.nombre ORDER BY p.nombre ASC";
$requestProductos = $con->listar($productos);

$servicios = "SELECT p.idProducto, p.nombre, c.descripcion, p.precio_venta FROM producto p INNER JOIN categoria_servicio c ON p.categoriaid = c.idcategoria WHERE p.unidadMedida = 'ZZ' AND p.nombre != 'AUMENTO DE ESTADIA' AND p.nombre != 'SERVICIO DE HOSPEDAJE' GROUP BY p.nombre";
$requestServicio = $con->listar($servicios);

$categoryProduct = "SELECT * FROM categoria_producto ORDER BY descripcion ASC";
$requestCategoryProduct = $con->listar($categoryProduct);
?>

<div class="modal fade" id="modalHospedarConsumo" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar consumos a la habitacion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
            <div class="modal-body">
                <form id="formHospedarConsumo" name="formHospedarConsumo">
                        <input type="hidden" id="idventa" name="idventa">
                        <input type="hidden" id="User" name="User" value="<?php echo $_SESSION['userData']['nombres']?>">
                        <input type="hidden" id="habitacionConsumo" name="habitacionConsumo" value="<?= $idreservacion?>">
                   
                    <div class="form-group mb-0">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Productos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Servicios</button>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                <div data-simplebar style="max-height: 330px;">
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
                                                <div data-simplebar style="max-height: 330px;">
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
                                        <div class=row>
                                            <div data-simplebar style="max-height: 244px;">
                                                <div class="table-responsive">
                                                    <table id="detalles" class="table table-sm table-centered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Elim.</th>
                                                                <th>Produc.</th>
                                                                <th>Actualiz. cant.</th>
                                                                <th>Actualiz. Prec.</th>
                                                                <th>Precio</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>      
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="col">
                                                <strong>SubTotal: </strong><span id="subtotal"></span><input type="hidden" name="subtotal_venta" id="subtotal_venta">
                                            </div>
                                            <div class="col">
                                                <strong>IGV(10%): </strong><span id="impuestos"></span><input type="hidden" name="impuestos_venta" id="impuestos_venta">
                                            </div>
                                            <div class="col">
                                                <strong >Total: </strong><span id="total_consumo"></span><input type="hidden" name="total_venta" id="total_venta"></span>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="pagarConsumo(<?= $idreservacion?>)">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
