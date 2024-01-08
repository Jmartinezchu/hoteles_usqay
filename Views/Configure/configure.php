<?php
   headerAdmin($data);
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                                    <li class="breadcrumb-item active">Configuracion</li>
                                    <li class="breadcrumb-item active">Información de la empresa</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Información de la empresa</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->

                <div class="row">
                        <div class="card">
                            <div class="card-body">
                            <form id="formConfiguracion" name="formConfiguracion">
                            <input type="hidden" id="idConfig" name="idConfig" value="1">
                            <input type="hidden" id="fecha_cierre" name="fecha_cierre">
                                <div class="row">
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre de la empresa:</label>
                                            <input type="text" id="nombre_empresa" class="form-control" placeholder="Nombre de la empresa"
                                            name="nombre_empresa">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">RUC de la empresa:</label>
                                            <input onkeyup="this.value=numeros(this.value)"  type="text" id="ruc" class="form-control" placeholder="Nombre de la empresa"
                                            name="ruc">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Razón Social de la empresa:</label>
                                            <input type="text" id="razon_social" class="form-control" placeholder="Razon Social de la empresa"
                                            name="razon_social">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Direccion de la empresa:</label>
                                            <input type="text" id="direccion" class="form-control" placeholder="Direccion de la empresa"
                                            name="direccion">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Telefono de la empresa:</label>
                                            <input onkeyup="this.value=numeros(this.value)" type="text" id="telefono" class="form-control" placeholder="Telefono de la empresa"
                                            name="telefono">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Correo electronico de la empresa:</label>
                                            <input type="text" id="correo_electronico" class="form-control" placeholder="Correo electronico"
                                            name="correo_electronico">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Serie de Boleta:</label>
                                            <input type="text" id="serie_boleta" class="form-control" placeholder="Serie de Boleta"
                                            name="serie_boleta">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Serie de Factura:</label>
                                            <input type="text" id="serie_factura" class="form-control" placeholder="Serie de Factura"
                                            name="serie_factura">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Token:</label>
                                            <input type="text" id="token" class="form-control" placeholder="Token"
                                            name="token">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Ruta:</label>
                                            <input type="text" id="ruta" class="form-control" placeholder="Ruta"
                                            name="ruta">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Detracción:</label>
                                            <select class="form-select" id="id_detraccion" name="id_detraccion" value="0">
                                            <?php 
                                                $con = new Mysql(); 
                                                $detraccion_act = $con->listar("SELECT * FROM configuracion");
                                                $detraccion = $con->listar("SELECT * FROM porcentaje_detraccion where porcentaje IS NOT NULL");
                                                    if(is_array($detraccion)){
                                                        foreach ($detraccion as $det){
                                                        if  ($det["id"]==$detraccion_act["id_detraccion"]){
                                                            echo "<option value='".$det["id"]."' selected>".$det["codigo"]." - ".$det["nombre"]." - ".$det["porcentaje"]." % </option>";
                                                            }else{
                                                            echo "<option value='".$det["id"]."'>".$det["codigo"]." - ".$det["nombre"]." - ".$det["porcentaje"]."% </option>";
                                                            }
                                                        }
                                                    }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Tipo de tarifas:</label>
                                            <select class="form-select" id="tarifa" name="tarifa">
                                                <option value="0">Tarifas personalizadas</option>
                                                <option value="1">Tarifa de hora y dia</option>
                                                <option value="2">Ambos tipos de tarifas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarConfiguracion()" ><span id="btnText">Guardar</span></button>&nbsp;
                                    <button type="button" id="btnCancelar" class="btn btn-light" onclick="cancelar()">Cancelar</button>
                                </div>
                            </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php footerAdmin($data); ?>