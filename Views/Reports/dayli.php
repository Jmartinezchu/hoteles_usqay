<?php 
  require_once("Libraries/Core/Mysql.php");
  headerAdmin($data);
  $con = new Mysql();
  $date = date('Y-m-d');
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

  $total_ventas = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 3 AND estado = 1 AND created_at = '".$fechaInicio."'";
  $request_ventas = $con->buscar($total_ventas);
  $total_ventas_day = $request_ventas['total'];

  $openMoney = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 1 and estado = 1 and created_at = '".$fechaInicio."'" ;
  $request_open = $con->buscar($openMoney);
  $montoOpen = $request_open["total"];


  $box_open = "SELECT * FROM movimiento_caja WHERE tipomovimientocaja_id = 1 and estado = 1 and created_at = '".$fechaInicio."'" ;
  $request_box_open = $con->buscar($box_open);


  $total_pago_reservacion = "SELECT SUM(monto) as reservacion FROM movimiento_caja WHERE tipomovimientocaja_id = 2 and estado = 1 and created_at = '".$fechaInicio."'";
  $request_reservacion = $con->buscar($total_pago_reservacion);
  $reservacion_pagos = $request_reservacion['reservacion'];
  
  $total_otro_tipo_ingreso = "SELECT SUM(monto) as ingresos FROM movimiento_caja WHERE tipomovimientocaja_id = 11 and estado = 1 and created_at = '".$fechaInicio."'";
  $request_ingresos = $con->buscar($total_otro_tipo_ingreso);
  $total_ingresos_day = $request_ingresos['ingresos'] ;

  $total_efectivo = "SELECT SUM(monto) as efectivo FROM movimiento_caja WHERE mediopagoid = 1 and descripcion = 'Pago de venta'  and created_at = '".$fechaInicio."'";
  $request_efectivo = $con->buscar($total_efectivo);
  $total_efectivo_reserv = "SELECT SUM(monto) as efectivo FROM movimiento_caja WHERE mediopagoid = 1 and descripcion = 'Pago de reservacion'  and created_at = '".$fechaInicio."'";
  $request_efectivo_reserv = $con->buscar($total_efectivo_reserv);
  $total_efectivo_day = $request_efectivo['efectivo'] + $request_efectivo_reserv['efectivo'];

  $efectivo_salidas = "SELECT SUM(monto) as efectivo_salidas FROM movimiento_caja WHERE mediopagoid = 1 and estado = 2 and created_at = '".$fechaInicio."'";
  $request_efectivo_salidas = $con->buscar($efectivo_salidas);
  $total_salidas_efectivo = $request_efectivo_salidas['efectivo_salidas'];

  $efectivoF =  $total_efectivo_day + $total_salidas_efectivo; 

  $efectivo_egresos = "SELECT SUM(monto) as egresos_efectivo FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and mediopagoid = 1 and created_at = '".$fechaInicio."'";
  $request_egresos_efectivo = $con->buscar($efectivo_egresos);
  $total_egresos_efectivo = $request_egresos_efectivo['egresos_efectivo'];

  $egresos_visa = "SELECT SUM(monto) as egresos_visa FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 2 and estado = 2 and created_at = '".$fechaInicio."'";
  $request_egresos_visa = $con->buscar($egresos_visa);
  $total_egresos_visa = $request_egresos_visa['egresos_visa'];

  $egresos_yape = "SELECT SUM(monto) as egresos_yape FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 5 and estado = 2 and created_at = '".$fechaInicio."'";
  $request_egresos_yape= $con->buscar($egresos_yape);
  $total_egresos_yape = $request_egresos_yape['egresos_yape'];

  $egresos_plin = "SELECT SUM(monto) as egresos_plin FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 6 and estado = 2 and created_at = '".$fechaInicio."'";
  $request_egresos_plin = $con->buscar($egresos_plin);
  $total_egresos_plin= $request_egresos_plin['egresos_plin'];

  $egresos_mastercard = "SELECT SUM(monto) as egresos_mastercard FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 3 and estado = 2 and created_at = '".$fechaInicio."'";
  $request_egresos_mastercard= $con->buscar($egresos_mastercard);
  $total_egresos_mastercard = $request_egresos_mastercard['egresos_mastercard'];

  $egresos_transferencia = "SELECT SUM(monto) as egresos_transferencia FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and  mediopagoid = 4 and estado = 2 and created_at = '".$fechaInicio."'";
  $request_egresos_transferencia = $con->buscar($egresos_transferencia);
  $total_egresos_transferencia = $request_egresos_transferencia['egresos_transferencia'];

  $total_visa = "SELECT SUM(monto) as visa FROM movimiento_caja WHERE mediopagoid = 2  and created_at = '".$fechaInicio."'";
  $request_visa = $con->buscar($total_visa);
  $visa = $request_visa['visa'];

  $total_yape = "SELECT SUM(monto) as yape FROM movimiento_caja WHERE mediopagoid = 5  and created_at = '".$fechaInicio."'";
  $request_yape = $con->buscar($total_yape);
  $yape = $request_yape['yape'];

  $total_plin = "SELECT SUM(monto) as plin FROM movimiento_caja WHERE mediopagoid = 6  and created_at = '".$fechaInicio."'";
  $request_plin = $con->buscar($total_plin);
  $plin = $request_plin['plin'];

  $total_transferencia = "SELECT SUM(monto) as transferencia FROM movimiento_caja WHERE mediopagoid = 4  and created_at = '".$fechaInicio."'";
  $request_transferencia = $con->buscar($total_transferencia);
  $transferencia = $request_transferencia['transferencia'];

  $total_mastercard = "SELECT SUM(monto) as mastercard FROM movimiento_caja WHERE mediopagoid = 3   and created_at = '".$fechaInicio."'";
  $request_mastercard = $con->buscar($total_mastercard);
  $mastercard = $request_mastercard['mastercard'];
  
  $total_egresos = "SELECT SUM(monto) as egresos FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and estado = 2 and created_at = '".$fechaInicio."'";
  $request_egresos = $con->buscar($total_egresos);
  $total_egresos = $request_egresos['egresos'];

  $salidas = "SELECT SUM(monto) as salidas_dinero FROM movimiento_caja WHERE mediopagoid != 0 and estado = 2 and created_at ='".$request_confg["fecha_cierre"]."'";
  $request_salidas = $con->buscar($salidas);
  $total_salidas = $request_salidas['salidas_dinero'];

  $total_caja_day = $reservacion_pagos + $total_ventas_day + $montoOpen +  $total_ingresos_day - abs($total_salidas);
  $total_ingresos = $total_ventas_day + $reservacion_pagos + $total_ingresos_day - abs($total_salidas);
  $utilidadCaja = $total_caja_day - abs($total_egresos) - abs($montoOpen);

  $cajas = "SELECT * FROM caja";
  $query_cajas = $con->listar($cajas);
?>

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
                            <li class="breadcrumb-item active">Reportes</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Cuadre diario</h4>
                </div>
            </div>
        </div>     
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                                <h4 class="page-title"> <i class=" dripicons-align-center"></i> Filtros</h4>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-date" class="form-label">Fecha: </label>
                                            <input onchange="carga_cortes()" class="form-control" id="fecha" type="date" name="fecha" value="<?php echo  $fechaInicio; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg 4">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Caja: </label>
                                            <?php
                                            $cajaid = ''; 
                                            if(isset($request_box_open['cajaid'])){
                                                $cajaid .= $request_box_open['cajaid'];    
                                            }
                                            ?>
                                            <select onchange="carga_cortes()" data-live-search="true" class="form-select" id="cajas" name="cajas">
                                            <?php
                                            if (is_array($query_cajas)) {
                                                foreach ($query_cajas as $cajas) {
                                                        echo "<option value='" . $cajas["id_caja"] . "' selected>" . $cajas["nombre_caja"] . "</option>";
                                                } 
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg 4">
                                    <div class="mb-3">
                                        <label for="example-select" class="form-label">Corte: </label>
                                            <select onchange="carga_data_cortes()" data-live-search="true" class="form-select" id="cortes" name="cortes">
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                    <button onclick="corte()" type="button" id="btnFactura" class="btn btn-light btn-sm"><i class="fa-solid fa-bolt"></i> Corte</button>

                                    <button onclick="imprimir()" type="button" id="btnBoleta" class="btn btn-light btn-sm"><i class="fa-solid fa-print"></i> Imprimir</button>

                                    <button onclick="email()" type="button" id="btnTicket" class="btn btn-light btn-sm"><i class="fa-solid fa-envelope"></i> Email</button>

                                    <button onclick="generarPDF()" type="button" id="btnTicket" class="btn btn-light btn-sm"><i class="fa-solid fa-file-lines"></i> PDF</button>
                                    </div>
                            </div>
                    </div>
            </div><!-- end col-->
        </div>
        <?php
        //Obtenemos todos los medios de pago validos
            $medios = array();
            $medios_pago = "Select mp.idmediopago, mp.nombre from medio_pago mp";
            $resultado_medios = $con->listar($medios_pago);
            if (is_array($resultado_medios)) {
                foreach ($resultado_medios as $medio) {
                    $tmp = array();
                    $tmp["nombre"] = $medio["nombre"];
                    $tmp["id_medio"] = $medio["idmediopago"];
                    $medios[] = $tmp;
                    
                }
            }
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <h4>Cuadre diario <?php echo date('d M. Y'); ?> </h4>
                        <hr>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-info" for="success-outlined">TOTALES</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">TOTAL EN CAJA S/</label>
                                    <input class="form-control" readonly type="number" id="total_caja" name="total_caja" value="0.00">
                                </div>
                            </div>
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">UTILIDAD EN CAJA S/</label>
                                    <input class="form-control" readonly type="number" id="utilidad_caja" name="utilidad_caja" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-info" for="success-outlined">MONTOS INICIALES</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">MONTO DE APERTURA S/</label>
                                    <input class="form-control" readonly type="number" id="inicial" name="inicial" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-info" for="success-outlined">RESUMEN VENTAS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">TOTAL VENDIDO</label>
                                    <input class="form-control" readonly type="number" id="vendido" name="vendido" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-info" for="success-outlined">RESUMEN RESERVAS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">TOTAL VENDIDO</label>
                                    <input class="form-control" readonly type="number" id="reservas" name="reservas" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-info" for="success-outlined">OTROS TIPO DE INGRESOS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">TOTAL</label>
                                    <input class="form-control" readonly type="number" id="ingresos_totales" name="ingresos_totales" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-danger" for="success-outlined">OTROS TIPO DE EGRESOS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">TOTAL</label>
                                    <input class="form-control" readonly type="number" id="egresos_totales" name="egresos_totales" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-info" for="success-outlined">INGRESOS DETALLADOS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ($medios as $med) : ?>
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label"><?php echo $med["nombre"]; ?></label>
                                    <input class="form-control" readonly type="number" id="ven_<?php echo $med["id_medio"] ?>" name="ven_<?php echo $med["id_medio"] ?>" value="0.00">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                            <div class="col-lg 4">
                                <div class="mb-3">
                                <label class="btn btn-danger" for="success-outlined">EGRESOS DETALLADOS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ($medios as $med) : ?>
                            <div class="col-lg 4">
                                <div class="mb-3">
                                    <label for="example-date" class="form-label"><?php echo $med["nombre"]; ?></label>
                                    <input class="form-control" readonly type="number" id="egre_<?php echo $med["id_medio"] ?>" name="egre_<?php echo $med["id_medio"] ?>" value="0.00">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    </div>
        <!-- content -->
</div>
</div>  

<?php footerAdmin($data); ?>


<script>
    
  
    document.addEventListener('DOMContentLoaded',function(e){
        Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
        })
        Swal.showLoading()
        carga_cortes();
        // cajas();
        // Turnos();
    
    })

    function carga_cortes(){
        var caja = $("#cajas option:selected").val();
        if(caja === "")
        {
            swal("Seleccione una caja","","error")
        }else{
            var param = {
                    'fecha': $('#fecha').val(),
                    'caja': caja
                };
                $.ajax({
                    url: base_url+'/OpenBox/getCortesDay',
                    type: 'POST',
                    data: param,
                    cache: true,
                    dataType: 'json',
                    success: function(data) {
                        if (data != "") {
                            var txt = "";
                            $.each(data, function(key, value) {
                                txt += "<option value='" + value + "'>" + value + "</option>";
                            });
                            //txt += "<option value='TODO'>Todo el Día</option>";
                            $("#cortes").html(txt);
                            carga_data_cortes();
                        } else {
                            // alert("No Hubo actividad ese día");
                            swal("No hubo actividad ese día","","error");
                            var corte_actual = $("#cortes option:selected").val();
                            var dia = corte_actual.split(" ");
                            $('#fecha').val(dia[0]);
                        }
                    }
                });
            }
    
    }



    function corte(){
        if (confirm("Se hara un corte. ¿Deseas Continuar?")) {
            //Imprimimos corte actual
            var caja = $("#cajas option:selected").val();
            var corte = $("#cortes option:selected").val();
            var inicial = 1;

            if (caja === "") {
                corte = "";
                inicial = 0;
            }

            var param = {
                'fecha': $('#fecha').val(),
                'cajero': 'Cajero',
                'corte': corte,
                'inicial': inicial,
                'caja': caja,
                'tipo': 2
            };

            var param2 = {
                'fecha': $('#fecha').val(),
                'corte': corte,
                'caja': caja
            };

            setTimeout(function(){
            Swal.fire({
                title : 'Por favor espere',
                text : 'Procesando...',
                timer: 20000,
                icon : 'info',
                allowOutsideClick : false,
                allowEscapeKey : false
                })
            }, 15000)
            Swal.showLoading()

            $.ajax({
                url: base_url+'/OpenBox/enviarCorteCorreo',
                type: 'POST',
                data: param2,
                cache: true,
                dataType: 'json',
                success: function(data) {
                    console.log('GOOD!');
                }
            })
        
            //Hacemos corte de mrd puto gonzalo de mrd ctm
            $.ajax({
                url: base_url+'/OpenBox/HacerCorte?caja=' + caja,
                type: 'POST',
                cache: true,
                dataType: 'json',
                success: function(data) {
                    location.href = base_url+'/TurnOpening';
                }
            });
            

        
        }
    }

    function carga_data_cortes(){
        var corte = $("#cortes option:selected").val();
        var caja = $("#cajas option:selected").val();

        var param = {
            'fecha': $('#fecha').val(),
            'corte': corte,
            'caja': caja
        };
        $.ajax({
            url: base_url+'/OpenBox/totalVendidoCorte',
            type: 'POST',
            data: param,
            cache: true,
            dataType: 'json',
            success: function(data) {
                
                $("#vendido").val(parseFloat(data.vendido).toFixed(2));
                $("#reservas").val(parseFloat(data.reservas).toFixed(2));
                $("#inicial").val(parseFloat(data.montoinicial).toFixed(2));
                $("#total_caja").val(parseFloat(data.totalcaja).toFixed(2));
                $("#ingresos_totales").val(parseFloat(data.ingresos_total_monto).toFixed(2));
                $("#egresos_totales").val(parseFloat(data.egresos_total_monto).toFixed(2));
                $("#utilidad_caja").val(parseFloat(data.utilidadcaja).toFixed(2));
                <?php foreach ($medios as $med) : ?>
                            $("#ven_<?php echo $med["id_medio"] ?>").val(parseFloat(data.ven_<?php echo $med["id_medio"]?>).toFixed(2));
                <?php endforeach; ?>          
                <?php foreach ($medios as $med) : ?>
                            $("#egre_<?php echo $med["id_medio"] ?>").val(parseFloat(data.egre_<?php echo $med["id_medio"]?>).toFixed(2));
                <?php endforeach; ?>  
            }
        });
    }
    // Obetengo la fecha actual
    var now = new Date();
    var day =("0"+now.getDate()).slice(-2);
    var month=("0"+(now.getMonth()+1)).slice(-2);
    var today=now.getFullYear()+"-"+(month)+"-"+(day);
    $("#fecha").val(today);

    function imprimir(){
        var url  = base_url+'/Prints/closeBox';
        var win = window.open(url,'_blank');
        win.focus();
    }


function email(){
    let ajaxUrl = base_url+'/Reports/email';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("POST",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            swal("Cierre de caja","Reporte enviado correctamente","success");
        }
    }
}

function buscar() {
    window.location.href = base_url+'/Reports/dayli?fecha=' + $('#fecha').val();
}

function generarPDF(){
    var HTML_Width = $("#panel_data").width();
    var HTML_Height = $("#panel_data").height();
    var top_left_margin = 5;
    var PDF_Width = HTML_Width+(top_left_margin*2);
    var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


    html2canvas($("#panel_data")[0],{allowTaint:true}).then(function(canvas) {
        canvas.getContext('2d');
        
        console.log(canvas.height+"  "+canvas.width);
        
        
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
        
        
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        
        pdf.save("cierre_de_caja.pdf");
    });
};
  
</script>