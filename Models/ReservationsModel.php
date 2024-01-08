<?php
 
 class ReservationsModel extends Mysql{
     
     public $idReservation;
     public $startDate;
     public $statusReservation;
     public $endDate;
     public $originReservation;
     public $Customer;
     public $Descripcion;
     public $PriceRoom;
     public $idCategoriaRoom;
     public $idRoom;
     public $Voucher;
     public $MovimientoCash;
     public $MedioPago;
     public $UsuarioId;
     public $Total;
     public $total;
     public $Pagos;
     public $Identificacion;
     public $idHabitacion;
     public $priceRoom;
     public $tipoServicio;
     public $today;
     public $idUsuario;
     public $identificacion;
     public $nombre;
     public $correo;
     public $direccion;
     public $Usuario;
     public $TipoComprobante;
     public $Habitaciones;
     public $subtTotal;
     public $totalImpuestos;
     public $TotalVenta;
     public $idProducto;
     public $Cantidad;
     public $PrecioVenta;
     public $detalleConsumo;
     public $idConsumo;
     public $nombreUser;
     public $idDetalleConsumo;
     public $cantidadDesechada;
     public $descripcionDesechable;
     public $id;
     public $descuento;
     public $idreservacion;
     public $precio;
     public $fecha;
     public $tiempoDias;
     public $tiempoHoras;
     public $tiempoMinutos;

     public function __construct(){
         parent::__construct();
     }

     public function insertPaymentReservation(int $idreservacion,string $descripcion, $medio_pago, int $tipo_comprobante, int $user, $pagosmedio, $total)
     {
       
        // foreach($tipo_comprobante as $comp){
            $this->idReservation = $idreservacion;
            $this->Descripcion = $descripcion;
            $this->Voucher = $tipo_comprobante;
            // $this->MedioPago = $medio_pago;
            $this->UsuarioId = $user;
            // $this->Pagos = $pagosmedio;
            $this->Total = $total;

            if(empty($this->Descripcion)){
                $descripcion = "SERVICIO DE HOSPEDAJE";
            }else{
                    $descripcion = $this->Descripcion;
            }
            
            $sql_update = "UPDATE reservaciones SET reservacion_estado_id = ? WHERE id_reservacion = $this->idReservation";
            $arrData = array(2);
            $request_update = $this->actualizar($sql_update,$arrData);

        $num_medio = 0;
        $sw = true;
        while($num_medio < count($medio_pago)){
            $sql_caja = "INSERT INTO movimiento_caja(monedaid,tipomovimientocaja_id,cajaid,turnoid,mediopagoid,usuarioid,monto,descripcion) VALUES (?,?,?,?,?,?,?,?)";
            $arrData = array(1,2,1,1,$medio_pago[$num_medio],$this->UsuarioId,$pagosmedio[$num_medio],'Pago de reservacion');
            $request_caja = $this->insertar($sql_caja,$arrData);

            $sql = "INSERT INTO reservaciones_payments(descripcion,reservacionid,movimientocashid,voucher_electronico_id,metodo_pago_id,usuarioid,total) VALUES(?,?,?,?,?,?,?)";
            $arrData = array($this->Descripcion,$this->idReservation,2,$tipo_comprobante,$medio_pago[$num_medio],$this->UsuarioId,$pagosmedio[$num_medio]);
            $request_insert = $this->insertar($sql,$arrData);

            $sql_detalle = "INSERT INTO reserva_medio_pago(id_venta,mediopago,monto) VALUES (?,?,?)";
            $arrData = array($this->idReservation, $medio_pago[$num_medio], $pagosmedio[$num_medio]);
            $this->insertar($sql_detalle,$arrData) or $sw = false;
            $num_medio = $num_medio + 1;
        }
       
        $idreservationpayment = $request_insert;
        $pagoreserva = "SELECT * FROM reservaciones_payments order by id desc limit 1";
        $request_pago = $this->buscar($pagoreserva);
        
        $sql_turno = "SELECT idturno FROM turnos WHERE inicio_turno <= '".date("H:i:s")."' AND fin_turno >= '".date("H:i:s")."'";
        $request_turno = $this->buscar($sql_turno);

        $sw = true;

        $sql_config = "SELECT * FROM configuracion WHERE id = 1";
        $request_sql_config = $this->buscar($sql_config);
        $serie = $request_sql_config['serie_boleta'];
        $factura = $request_sql_config['serie_factura'];

        $reservaciones = "SELECT * FROM reservaciones r INNER JOIN usuario u ON r.cliente=u.idusuario INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion WHERE r.id_reservacion = $this->idReservation";
        $request_reservaciones = $this->buscar($reservaciones);
        // var_dump($total);exit;

        $sql_medios_pago_reserva = "SELECT mp.nombre FROM reserva_medio_pago vp INNER JOIN medio_pago mp ON vp.mediopago=mp.idmediopago WHERE vp.id_venta = $this->idReservation";
        $request_medios_pago_reserva = $this->listar($sql_medios_pago_reserva);

       
        $medios = array();
        for ($i=0; $i <count($request_medios_pago_reserva) ; $i++) { 
            $medios[] = $request_medios_pago_reserva[$i]['nombre'];
        }
        // var_dump($medios);exit;
    
        if($tipo_comprobante == "2"){
            $cont = 0;

            $identificacion = $request_reservaciones['identificacion'];
            $conteo = strlen($identificacion);

            if($conteo == 11){
                $tipoDoc = 6;
            }else if($conteo == 8){
                $tipoDoc = 1;
            }
            // var_dump($request_reservaciones['identificacion']);exit;
           
            $cabecera = array();
            $cabecera["operacion"] = "generar_comprobante";
            $cabecera["tipo_de_comprobante"] = "2";
            $cabecera["serie"] = $serie;

            $cabecera["numero"] = str_pad($cont++, 8, "0", STR_PAD_LEFT);
            $cabecera["sunat_transaction"] = 1;
            $cabecera["cliente_tipo_de_documento"] = $tipoDoc;
            $cabecera["cliente_numero_de_documento"] = $request_reservaciones['identificacion'];
            $cabecera["cliente_denominacion"] = $request_reservaciones['nombres'];
            $cabecera["cliente_email"] = $request_reservaciones['email_user'];
            $cabecera["cliente_email_1"] = "";
            $cabecera["cliente_email_2"] = "";
            $cabecera["fecha_de_emision"] = date("d-m-Y");
            $cabecera["fecha_de_vencimiento"] = "";
            $cabecera["moneda"] = 1;
            $cabecera["tipo_de_cambio"] = "";
            $cabecera["porcentaje_de_igv"] = "10.00";
            $cabecera["descuento_global"] =  number_format(floatval($request_reservaciones['descuento']), 3, ".", "");
            $cabecera["total_descuento"] =  number_format(floatval($request_reservaciones['descuento']), 3, ".", "");
            $cabecera["total_anticipo"] = "";
            
            $cabecera["total_gravada"] = number_format(floatval(($request_reservaciones['total']/110)*100), 3, ".", "");
            $cabecera["total_inafecta"] = "";
            $cabecera["total_exonerada"] = "";
            $cabecera["total_igv"] = number_format(floatval(($request_reservaciones['total']/110)*10), 3, ".", "");
            $cabecera["total_gratuita"] = "";
            $cabecera["total_otros_cargos"] = "";
            $cabecera["total"] = number_format(floatval($request_reservaciones['total']), 3, ".", "");
            $cabecera["percepcion_tipo"] = "";
            $cabecera["percepcion_base_imponible"] = "";
            $cabecera["total_percepcion"] = "";
            $cabecera["total_incluido_percepcion"] = "";
            $cabecera["detraccion"] = "false";
            $cabecera["observaciones"] = "";
            $cabecera["documento_que_se_modifica_tipo"] = "";
            $cabecera["documento_que_se_modifica_serie"] = "";
            $cabecera["documento_que_se_modifica_numero"] = "";
            $cabecera["tipo_de_nota_de_credito"] = "";
            $cabecera["tipo_de_nota_de_debito"] = "";
            $cabecera["enviar_automaticamente_a_la_sunat"] = "true";
            $cabecera["enviar_automaticamente_al_cliente"] = "true";
            $cabecera["codigo_unico"] = "";
            $cabecera["condiciones_de_pago"] = "";
            $cabecera["medio_de_pago"] = $medios;
            $cabecera["placa_vehiculo"] = "";
            $cabecera["orden_compra_servicio"] = "";
            $cabecera["tabla_personalizada_codigo"] = "";
            $cabecera["formato_de_pdf"] = "TICKET";

            $sql_boleta = "SELECT * from boleta order by id desc limit 1";
            $request_sql_boletas = $this->buscar($sql_boleta);
            if(empty($request_sql_boletas['id'])){
                $numero = 1;
            }else{
                $numero = $request_sql_boletas['id'] + 1;
            }
            

            $detalles_consumos = "SELECT dc.id_detalle_consumo, sc.code, p.nombre, dc.cantidadActual, dc.precio_venta, p.unidadMedida FROM detalle_consumo dc inner join producto p on p.idProducto = dc.idarticulo left join sunat_codes sc ON p.sunatid = sc.id where dc.reservaid = $idreservacion AND dc.estado != 0 order by p.precio_venta asc";
            $query_detalles = $this->listar($detalles_consumos);

            foreach($query_detalles as $value){

            $totalProducto = intval($value['cantidadActual'])*floatval($value['precio_venta']);

            $item = array();
            $neto = $totalProducto / 1.10;
            $igv = ($totalProducto / 110) * 10;

            $item["unidad_de_medida"] = $value['unidadMedida'];
            $item["codigo"] = $value['id_detalle_consumo'];

            $item["codigo_producto_sunat"] = $value['code'];
            $item["descripcion"] = $value['nombre'];
            $item["cantidad"] = intval($value['cantidadActual']);
            $item["valor_unitario"] = number_format(($value['precio_venta']/1.10), 3, '.', '');
            $item["precio_unitario"] = number_format(($value['precio_venta']), 3, '.', '');
            $item["descuento"] = '';
            $item["subtotal"] =  number_format(($neto), 3, '.', '');
            $item["tipo_de_igv"] = 1;
            $item["igv"] = number_format(($igv), 3, '.', '');
            $item["total"] = number_format(($totalProducto), 3, '.', '');
            $item["anticipo_regularizacion"] = false;
            $item["anticipo_documento_serie"] = '';
            $item["anticipo_documento_numero"] = '';

            $items[] = $item;

            }
            // var_dump($items);exit;

            $cabecera["items"] = $items;
            $data_json = json_encode($cabecera);
    
            $ruta = $request_sql_config["ruta"];
            $token = $request_sql_config["token"];
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Authorization: Token token="' . $token . '"',
                    'Content-Type: application/json',
                )
            );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuesta  = curl_exec($ch);

            $idboleta = $numero;
            $array_respuesta = array();
            $array_respuesta["exito"] = 1;
            $array_respuesta["mensaje"] = "";
            $array_respuesta["id_boleta"] = $idboleta;

            if(intval(curl_errno($ch)) === 0){
                curl_close($ch);
                $leer_respuesta = json_decode($respuesta, true);
                if (isset($leer_respuesta['error']) && isset($leer_respuesta['error']['error']) && $leer_respuesta['error']['error']) {
                    $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                    $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),'NO',' ',' ',$leer_respuesta['errors']);
                    $insert_comprobante_hash = $this->insertar($qr,$arrData);    
                    
                    $this->restablecerBoletaFactura();

                    if(strpos($leer_respuesta['error']['mensaje'],  "ERROR SECUENCIAL REGISTRADO") === false){
                        $array_respuesta["exito"] = 0;
                        $array_respuesta["mensaje"] = $leer_respuesta['error']['mensaje'];
                        return $array_respuesta;
                    }else{
                        $array_respuesta["exito"] = 0;
                        $array_respuesta["mensaje"] = "Por favor intente nuevamente";
                         return $array_respuesta;      
                    }
                }else{
                    $aceptada = "NO";
                    if(isset($leer_respuesta["data"]) && isset($leer_respuesta['data']['error']) && !$leer_respuesta['data']['error'] && isset($leer_respuesta['data']['data'])){
                        $aceptada = "SI";

                        $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                        $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                        $insert_comprobante_hash = $this->insertar($qr,$arrData);

                        $venta_boleta = "INSERT INTO boleta(id,id_venta,token,serie,estado_fila) VALUES (?,?,?,?,?)";
                        $arrVentaBoleta = array($numero,$request_reservaciones['id_reservacion'],'',$serie,1);
                        $insert_boleta = $this->insertar($venta_boleta,$arrVentaBoleta);

                        $array_respuesta["exito"] = 1;
                        $array_respuesta["mensaje"] = "Se realizo el pago correctamente.";                        
                        return $array_respuesta;
                    }else{
                        if (!is_null($leer_respuesta)){
                            
                            $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                            $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                            $insert_comprobante_hash = $this->insertar($qr,$arrData);

                            $venta_boleta = "INSERT INTO boleta(id,id_venta,token,serie,estado_fila) VALUES (?,?,?,?,?)";
                            $arrVentaBoleta = array($numero,$request_reservaciones['id_reservacion'],'',$serie,1);
                            $insert_boleta = $this->insertar($venta_boleta,$arrVentaBoleta);

                            $mensaje = json_encode($leer_respuesta);
                            $array_respuesta["exito"] = 1;
                            $array_respuesta["mensaje"] = "Se realizo el pago correctamente.";                            
                            return $array_respuesta;
                        }else{
                            $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                            $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                            $insert_comprobante_hash = $this->insertar($qr,$arrData);

                            $this->restablecerBoletaFactura();

                            $mensaje = "No se pudo establecer conexion con el Facturador. Si el problema persiste por favor comunicarse a soporte.";
                            $array_respuesta["exito"] = 0;
                            $array_respuesta["mensaje"] = $mensaje;
                            $contador_repeticion = 0;
                            return $array_respuesta;
                        }
                    }
                }       
            }else{
                curl_close($ch);
                $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),'NE',' ',' ','');
                $request_compr = $this->insertar($qr,$arrData);

                $this->restablecerBoletaFactura();

                $array_respuesta["exito"] = 0;
                $array_respuesta["mensaje"] = "No se pudo establecer conexion con SUNAT, tiene problemas de conexion a internet, puede emitir un TICKET";
                return $array_respuesta;
            }  
            return $respuesta and $insert_comprobante_hash and $insert_boleta;
        }else if($tipo_comprobante == 1){
            $cont = 0;
            $cabecera = array();
            $cabecera["operacion"] = "generar_comprobante";
            $cabecera["tipo_de_comprobante"] = "1";
            $cabecera["serie"] = $factura;

            $cabecera["numero"] = str_pad($cont++, 8, "0", STR_PAD_LEFT);
            $cabecera["sunat_transaction"] = 1;
            $cabecera["cliente_tipo_de_documento"] = '6';
            $cabecera["cliente_numero_de_documento"] = $request_reservaciones['identificacion'];
            $cabecera["cliente_denominacion"] = $request_reservaciones['nombres'];
            $cabecera["cliente_email"] = $request_reservaciones['email_user'];
            $cabecera["cliente_email_1"] = "";
            $cabecera["cliente_email_2"] = "";
            $cabecera["fecha_de_emision"] = date("d-m-Y");
            $cabecera["fecha_de_vencimiento"] = "";
            $cabecera["moneda"] = 1;
            $cabecera["tipo_de_cambio"] = "";
            $cabecera["porcentaje_de_igv"] = "10.00";
            $cabecera["descuento_global"] =  number_format(floatval($request_reservaciones['descuento']), 3, ".", "");
            $cabecera["total_descuento"] =  number_format(floatval($request_reservaciones['descuento']), 3, ".", "");
            $cabecera["total_anticipo"] = "";
            
            $cabecera["total_gravada"] = number_format(floatval(($request_reservaciones['total']/110)*100), 3, ".", "");
            $cabecera["total_inafecta"] = "";
            $cabecera["total_exonerada"] = "";
            $cabecera["total_igv"] = number_format(floatval(($request_reservaciones['total']/110)*10), 3, ".", "");
            $cabecera["total_gratuita"] = "";
            $cabecera["total_otros_cargos"] = "";
            $cabecera["total"] = number_format(floatval($request_reservaciones['total']), 3, ".", "");
            $cabecera["percepcion_tipo"] = "";
            $cabecera["percepcion_base_imponible"] = "";
            $cabecera["total_percepcion"] = "";
            $cabecera["total_incluido_percepcion"] = "";
            $cabecera["detraccion"] = "false";
            $cabecera["observaciones"] = "";
            $cabecera["documento_que_se_modifica_tipo"] = "";
            $cabecera["documento_que_se_modifica_serie"] = "";
            $cabecera["documento_que_se_modifica_numero"] = "";
            $cabecera["tipo_de_nota_de_credito"] = "";
            $cabecera["tipo_de_nota_de_debito"] = "";
            $cabecera["enviar_automaticamente_a_la_sunat"] = "true";
            $cabecera["enviar_automaticamente_al_cliente"] = "true";
            $cabecera["codigo_unico"] = "";
            $cabecera["condiciones_de_pago"] = "";
            $cabecera["medio_de_pago"] = $medios;
            $cabecera["placa_vehiculo"] = "";
            $cabecera["orden_compra_servicio"] = "";
            $cabecera["tabla_personalizada_codigo"] = "";
            $cabecera["formato_de_pdf"] = "TICKET";

            $sql_factura = "SELECT * from factura order by id desc limit 1";
            $request_sql_factura = $this->buscar($sql_factura);
            
            if(empty($request_sql_factura['id'])){
                $numero = 1;
            }else{
                $numero = $request_sql_factura['id'] + 1;
            }

            $detalles_consumos = "SELECT dc.id_detalle_consumo, sc.code, p.nombre, dc.cantidadActual, dc.precio_venta, p.unidadMedida FROM detalle_consumo dc inner join producto p on p.idProducto = dc.idarticulo left join sunat_codes sc ON p.sunatid = sc.id where dc.reservaid = $idreservacion AND dc.estado != 0 order by p.precio_venta asc";
            $query_detalles = $this->listar($detalles_consumos);

            foreach($query_detalles as $value){

            $totalProducto = intval($value['cantidadActual'])*floatval($value['precio_venta']);

            $item = array();
            $neto = $totalProducto / 1.10;
            $igv = ($totalProducto / 110) * 10;

            $item["unidad_de_medida"] = $value['unidadMedida'];
            $item["codigo"] = $value['id_detalle_consumo'];

            $item["codigo_producto_sunat"] = $value['code'];
            $item["descripcion"] = $value['nombre'];
            $item["cantidad"] = intval($value['cantidadActual']);
            $item["valor_unitario"] = number_format(($value['precio_venta']/1.10), 3, '.', '');
            $item["precio_unitario"] = number_format(($value['precio_venta']), 3, '.', '');
            $item["descuento"] = '';
            $item["subtotal"] =  number_format(($neto), 3, '.', '');
            $item["tipo_de_igv"] = 1;
            $item["igv"] = number_format(($igv), 3, '.', '');
            $item["total"] = number_format(($totalProducto), 3, '.', '');
            $item["anticipo_regularizacion"] = false;
            $item["anticipo_documento_serie"] = '';
            $item["anticipo_documento_numero"] = '';

            $items[] = $item;

            }

            $cabecera["items"] = $items;
            $data_json = json_encode($cabecera);
    
            $ruta = $request_sql_config["ruta"];
            $token = $request_sql_config["token"];
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Authorization: Token token="' . $token . '"',
                    'Content-Type: application/json',
                )
            );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuesta  = curl_exec($ch);
            // var_dump($respuesta);exit;
            $idfactura = $numero;
            $array_respuesta = array();
            $array_respuesta["exito"] = 1;
            $array_respuesta["mensaje"] = "";
            $array_respuesta["id_factura"] = $idfactura;
            if(intval(curl_errno($ch)) === 0){
                curl_close($ch);
                $leer_respuesta = json_decode($respuesta, true);
                if (isset($leer_respuesta['error']) && isset($leer_respuesta['error']['error']) && $leer_respuesta['error']['error']) {
                    $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                    $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),'NO',' ',' ',$leer_respuesta['errors']);
                    $insert_comprobante_hash = $this->insertar($qr,$arrData);      

                    $this->restablecerBoletaFactura();

                    if(strpos($leer_respuesta['error']['mensaje'],  "ERROR SECUENCIAL REGISTRADO") === false){
                        $array_respuesta["exito"] = 0;
                        $array_respuesta["mensaje"] = $leer_respuesta['error']['mensaje'];
                        return $array_respuesta;
                    }else{
                        $array_respuesta["exito"] = 0;
                        $array_respuesta["mensaje"] = "Por favor intente nuevamente";
                         return $array_respuesta;      
                    }
                }else{
                    $aceptada = "NO";
                    if(isset($leer_respuesta["data"]) && isset($leer_respuesta['data']['error']) && !$leer_respuesta['data']['error'] && isset($leer_respuesta['data']['data'])){
                        $aceptada = "SI";

                        $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                        $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                        $insert_comprobante_hash = $this->insertar($qr,$arrData);

                        $venta_factura = "INSERT INTO factura(id,id_venta,token,serie,estado_fila) VALUES (?,?,?,?,?)";
                        $arrVentaFactura = array($numero,$request_reservaciones['id_reservacion'],'',$factura,1);
                        $insert_factura = $this->insertar($venta_factura,$arrVentaFactura);

                        // var_dump($insert_factura);exit;

                        $array_respuesta["exito"] = 1;
                        $array_respuesta["mensaje"] = "Se realizo el pago correctamente.";                        
                        return $array_respuesta;
                    }else{
                        if (!is_null($leer_respuesta)){
                            
                            $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                            $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                            $insert_comprobante_hash = $this->insertar($qr,$arrData);

                            $venta_factura = "INSERT INTO factura(id,id_venta,token,serie,estado_fila) VALUES (?,?,?,?,?)";
                            $arrVentaFactura = array($numero,$request_reservaciones['id_reservacion'],'',$factura,1);
                            $insert_factura = $this->insertar($venta_factura,$arrVentaFactura);

                            $mensaje = json_encode($leer_respuesta);
                            $array_respuesta["exito"] = 1;
                            $array_respuesta["mensaje"] = "Se realizo el pago correctamente.";                            
                            return $array_respuesta;
                        }else{
                            $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                            $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                            $insert_comprobante_hash = $this->insertar($qr,$arrData);

                            $this->restablecerBoletaFactura();

                            $mensaje = "No se pudo establecer conexion con el Facturador. Si el problema persiste por favor comunicarse a soporte.";
                            $array_respuesta["exito"] = 0;
                            $array_respuesta["mensaje"] = $mensaje;
                            $contador_repeticion = 0;
                            return $array_respuesta;
                        }
                    }
                }       
            }else{
                curl_close($ch);
                $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),'NE',' ',' ','');
                $request_compr = $this->insertar($qr,$arrData);

                $this->restablecerBoletaFactura();

                $array_respuesta["exito"] = 0;
                $array_respuesta["mensaje"] = "No se pudo establecer conexion con SUNAT, tiene problemas de conexion a internet, puede emitir un TICKET";
                return $array_respuesta;
            } 
           return $respuesta and $insert_comprobante_hash and $insert_factura; 
        }
        return $sw and $request_insert and $request_caja and $request_update;
     }

    

     public function selectTipoComprobante(){
        $sql = "SELECT * FROM tipo_comprobante_sunat WHERE id_tipo_comprobante != 4 ";
        $request = $this->listar($sql);
        return $request;
    }

     public function deleteReservation(int $id_reservacion)
     {
         $this->idReservation = $id_reservacion;
         $sql = "SELECT * FROM reservaciones WHERE id_reservacion = $this->idReservation";
         $request_sql = $this->listar($sql);
         $idhabitacion =  $request_sql[0]['habitacion_id'];
         
        if($request_sql[0]['reservacion_estado_id'] != 2){
             $sql_anulacion = "UPDATE reservaciones SET reservacion_estado_id = ? WHERE id_reservacion = $this->idReservation";
             $arrData = array(4);
             $request_update = $this->actualizar($sql_anulacion,$arrData);
            
             $sql_update_status_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $idhabitacion";
             $arrData = array('Disponible');
             $request_habitacion = $this->actualizar($sql_update_status_room,$arrData);
             return $request_sql and $request_update and $request_habitacion;
        }

     }

     public function verReserva(int $habitacion){
 
        $this->idHabitacion = $habitacion;
        $sql = "SELECT id_reservacion FROM reservaciones where habitacion_id = $this->idHabitacion ORDER BY id_reservacion desc limit 1";
        $request_sql = $this->buscar($sql);
        // echo json_encode($request_sql['id_reservacion']);
        return $request_sql['id_reservacion'];
    }

     public function roomsReservation(){
        //  $sql = "SELECT * FROM habitacion order by estado_habitacion = 'Disponible' desc ";
        $sql ="select h.* from habitacion h inner JOIN preciohabitacion ph on ph.idHabitacion = h.idhabitacion WHERE ph.idTarifa= 2";
         $request = $this->listar($sql);
         return $request;
     }

     public function selectHabitacionHoras(){
        // $sql = "SELECT * FROM habitacion WHERE estado_habitacion = 'Disponible'";
        $sql = "select h.* from habitacion h inner JOIN preciohabitacion ph on ph.idHabitacion = h.idhabitacion WHERE ph.idTarifa= 1";
        $request = $this->listar($sql);
        return $request;
    }

    public function updateReservation(int $idReservation, string $start_date, string $end_date, int $status, int $origin, string $customer){
        $this->idReservation = $idReservation;
        $this->startDate = $start_date;
        $this->endDate = $end_date;
        $this->originReservation = $origin;
        $this->Customer = $customer;
        $this->statusReservation = $status;


        $sql_reservation = "SELECT * FROM reservaciones WHERE id_reservacion = $this->idReservation";
        $request_sql_reservation = $this->buscar($sql_reservation);
        $idroom = $request_sql_reservation['habitacion_id'];
        // var_dump($request_sql_reservation);exit;

        if($request_sql_reservation['reservacion_estado_id'] == 2){
            $sql_update_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $idroom ";
            $arrData = array('Mantenimiento');
            $request_update_room_checkout = $this->actualizar($sql_update_room,$arrData);
            // var_dump($request_update_room_checkout);exit;
            $sql = "UPDATE reservaciones SET fecha_inicio = ?, fecha_fin = ?,  reservacion_estado_id = ?, reservacion_origen_id = ?, cliente = ? WHERE id_reservacion = $this->idReservation";
            $arrData = array($this->startDate,$this->endDate,$this->statusReservation, $this->originReservation,$this->Customer);
            $request = $this->actualizar($sql,$arrData);
            
            return $request_update_room_checkout and $request;
        }else{
            
            $sql = "UPDATE reservaciones SET fecha_inicio = ?, fecha_fin = ?,  reservacion_estado_id = ?, reservacion_origen_id = ?, cliente = ? WHERE id_reservacion = $this->idReservation";
            $arrData = array($this->startDate,$this->endDate,$this->statusReservation, $this->originReservation,$this->Customer);
            $request_sql = $this->actualizar($sql,$arrData);
            return $request_sql;
        }
       
  
     }

     public function selectReservationId(int $idReservation){
          $this->idReservation = $idReservation;
        //   $sql = "SELECT r.id_reservacion, r.fecha_inicio,r.fecha_fin,r.cliente, r.reservacion_origen_id, r.reservacion_estado_id,r.habitacion_id,r.total, r.tipoServicio FROM reservaciones r INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion WHERE r.id_reservacion = $this->idReservation";
          $sql = "SELECT r.* FROM reservaciones r INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion WHERE r.id_reservacion = $this->idReservation";
          $request_sql = $this->buscar($sql);
          return $request_sql;
     }

     public function selectOriginReservation(){
         $sql = "SELECT * FROM origen_reservacion";
         $request = $this->listar($sql);
         return $request;
     }

     public function selectStatusReservation(){
        $sql = "SELECT * FROM reservaciones_estados WHERE id_reservacionestado != 4";
        $request = $this->listar($sql);
        return $request;
     }

     public function selectReservations(){
        $sql = "SELECT r.id_reservacion, h.nombre_habitacion, rp.voucher_electronico_id, r.fecha_inicio as fecha_inicio, r.fecha_fin as fecha_fin, u.nombres as cliente, o.nombre as origen, e.nombre as estado FROM reservaciones r INNER JOIN habitacion h ON r.habitacion_id=h.idhabitacion INNER JOIN origen_reservacion o ON r.reservacion_origen_id=o.idorigen_reservacion INNER JOIN reservaciones_estados e ON r.reservacion_estado_id=e.id_reservacionestado 
        INNER JOIN usuario u ON r.cliente=u.idusuario LEFT JOIN reservaciones_payments rp ON r.id_reservacion=rp.reservacionid
        WHERE r.reservacion_estado_id != 4";
        $request = $this->listar($sql);
        return $request;
     }
     

    public function selecthabitacion()
    {  
        $sql = "SELECT h.idhabitacion, h.nombre_habitacion, c.nombre_categoria_habitacion, h.estado_habitacion, h.capacidad  FROM habitacion h INNER JOIN categoria_habitacion c ON h.categoriahabitacionid = c.id_categoria_habitacion where estado_habitacion = 'Disponible'";
        $request = $this->listar($sql);
        return $request;
    }

     public function selectCategoryRoom(){
         $sql = "SELECT *  FROM categoria_habitacion";
         $request = $this->listar($sql);
         return $request;
     }
     
     public function insertReservation(string $start_date, string $end_date, int $status, int $origin_reservation,string $identificacion, string $customer, string $correo, string $direccion, int $idroom, float $total, float $priceRoom, int $tipoServicio){
        $this->startDate = $start_date;
        $this->endDate = $end_date;
        $this->originReservation = $origin_reservation;
        $this->Customer = $customer;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->Identificacion = $identificacion;
        $this->idRoom = $idroom;
        $this->total = $total;
        $this->statusReservation = $status;
        $this->priceRoom = $priceRoom;
        $this->tipoServicio = $tipoServicio;

        $sql_insert_huesped = "INSERT INTO usuario(identificacion,nombres,apellidos,telefono,email_user,direccion,password,rolid,estado) VALUES(?,?,?,?,?,?,?,?,?)";
        $arrData = array($this->Identificacion,$this->Customer,'','99999999',$this->correo, $this->direccion,123456789,7,1);
        $request_inset_cliente = $this->insertar($sql_insert_huesped,$arrData);
        // var_dump($arrData);
        // exit;
        $user_request = "SELECT * FROM usuario order by idusuario desc limit 1";
        $request_user_cliente = $this->buscar($user_request);
        $user_num = $request_user_cliente['idusuario'];

        $sql = "INSERT INTO reservaciones(fecha_inicio,fecha_fin,cliente,reservacion_origen_id,reservacion_estado_id,turno_id,habitacion_id,total, costoHabitacion, tipoServicio) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($this->startDate,
                         $this->endDate,
                         $user_num,
                         $this->originReservation,
                         $this->statusReservation, // RESERVACION PENDIENTE
                         1,
                         $this->idRoom,
                         $this->total,
                         $this->priceRoom,
                         $this->tipoServicio,
                        );
        $request_insert = $this->insertar($sql,$arrData);

        

        $startDateYMD = date("Y-m-d", strtotime($this->startDate));

        // Obtener la fecha actual en el formato "Y-m-d"
        $fecha_actual = date("Y-m-d");
    
        // Comparar la fecha actual con $startDateYMD

        if ($fecha_actual == $startDateYMD) {
            // Si son iguales, ejecuta la actualización de la habitación
            $update_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $this->idRoom";
            $arrData = array('Ocupada');
            $request_update_room = $this->actualizar($update_room, $arrData);
        }
  


        // $update_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $this->idRoom";
        // $arrData = array('Ocupada');
        // $request_update_room = $this->actualizar($update_room,$arrData);

        // var_dump($request_update_room);exit;





        $inser_reser_product = "INSERT INTO producto(categoriaid, sunatid, nombre, precio_venta, estado, unidadMedida) values(?,?,?,?,?,?)";
        $arrData = array(1,26700,'SERVICIO DE HOSPEDAJE',$this->priceRoom, 1,"ZZ");
        $request_prod = $this->insertar($inser_reser_product,$arrData);

        $insert_servicio_reserva = "INSERT INTO consumos(usuario,tipo_comprobante,reservaid,subtotal,total_impuestos,total_consumo,consumo_estado) VALUES(?,?,?,?,?,?,?)";
        $arrData = array($user_num, 10, $request_insert,1,2,$this->priceRoom,1);
        $request_insert_serv = $this->insertar($insert_servicio_reserva, $arrData);

        $insert_detalle_serv_reserva = "INSERT INTO detalle_consumo(consumoid,idarticulo,reservaid, cantidad,precio_venta, cantidadActual) VALUES(?,?,?,?,?,?)";
        $arrData = array($request_insert_serv,$request_prod, $request_insert,1, $this->priceRoom, 1);
        $request_insert_detalle_serv_reserva = $this->insertar($insert_detalle_serv_reserva, $arrData);

         
        // var_dump($request_update_room);exit;
         // Retornar sin $request_update_room si las fechas son diferentes
        if ($fecha_actual != $startDateYMD) {
            return $request_insert and $request_prod and $request_insert_serv and $request_insert_detalle_serv_reserva and $request_inset_cliente;
        }

        // Si las fechas son iguales, incluir $request_update_room en el retorno
        return $request_insert and $request_prod and $request_insert_serv and $request_insert_detalle_serv_reserva and $request_update_room and $request_inset_cliente;
     }

     public function updateReservationHoy(int $idReservation, string $start_date, string $end_date, int $status, int $origin, string $customer, string $today){
        $this->idReservation = $idReservation;
        $this->startDate = $start_date;
        $this->endDate = $end_date;
        $this->originReservation = $origin;
        $this->Customer = $customer;
        $this->statusReservation = $status;
        $this->today = $today;


        $sql_reservation = "SELECT * FROM reservaciones WHERE id_reservacion = $this->idReservation";
        $request_sql_reservation = $this->buscar($sql_reservation);
        $idroom = $request_sql_reservation['habitacion_id'];
    //  TODO: aqui vamos viendo
        // var_dump($request_sql_reservation);exit;
        
        if($request_sql_reservation['reservacion_estado_id'] == 2){
            $sql_update_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $idroom ";
            $arrData = array('Mantenimiento');
            $request_update_room_checkout = $this->actualizar($sql_update_room,$arrData);
            // var_dump($request_update_room_checkout);exit;
            $sql = "UPDATE reservaciones SET fecha_inicio = ?, fecha_fin = ?,  reservacion_estado_id = ?, reservacion_origen_id = ?, cliente = ?, fecha_hora_checkIn = ? WHERE id_reservacion = $this->idReservation";
            $arrData = array($this->startDate,$this->endDate,$this->statusReservation, $this->originReservation,$this->Customer, $this->today);
            $request = $this->actualizar($sql,$arrData);
            
            return $request_update_room_checkout and $request;
        }else{
            
            $sql = "UPDATE reservaciones SET fecha_inicio = ?, fecha_fin = ?,  reservacion_estado_id = ?, reservacion_origen_id = ?, cliente = ?, fecha_hora_checkIn = ? WHERE id_reservacion = $this->idReservation";
            $arrData = array($this->startDate,$this->endDate,$this->statusReservation, $this->originReservation,$this->Customer, $this->today);
            $request_sql = $this->actualizar($sql,$arrData);
            return $request_sql;
        }
     }

     public function updateStatus($idreserva) {
        $this->idReservation = $idreserva;
        // $this->statusReservation = $estado;
        // var_dump($idreserva);exit;

        // if($this->statusReservation == 2) {
            $sql_res = "SELECT * FROM reservaciones WHERE id_reservacion = $this->idReservation";
            $req_res = $this->buscar($sql_res);
            $idroom = $req_res['habitacion_id'];
            // var_dump($req_res);exit;
            $sql = "UPDATE reservaciones SET reservacion_estado_id = ? WHERE id_reservacion = $this->idReservation";
            $arrData = array(3);
            $request_res = $this->actualizar($sql, $arrData);
            // var_dump($request_res);
            $sql_update_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $idroom ";
            $arrData = array('Mantenimiento');
            $request_update_room_checkout = $this->actualizar($sql_update_room,$arrData);
           
            $request = $this->actualizar($sql, $arrData);
        // }
        return $request;
     }
     public function updateStatusOcupada($idreserva) {
        $this->idReservation = $idreserva;
       
            $sql_res = "SELECT * FROM reservaciones WHERE id_reservacion = $this->idReservation";
            $req_res = $this->buscar($sql_res);
            $idroom = $req_res['habitacion_id'];
            $start_date = $req_res['fecha_inicio'];

             // Fecha actual en formato "Y-m-d"
            $current_date = date("Y-m-d");

            // Convertir $start_date a formato "Y-m-d"
            $start_date_formatted = date("Y-m-d", strtotime($start_date));
        
            // Comparar las fechas
            if ($current_date === $start_date_formatted) {
                // Ejecuta el código que deseas si las fechas son iguales
                $sql = "UPDATE reservaciones SET reservacion_estado_id = ? WHERE id_reservacion = $this->idReservation";
                $arrData = array(2);
                $request_res = $this->actualizar($sql, $arrData);
        
                $sql_update_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $idroom ";
                $arrData = array('Ocupada');
                $request_update_room_checkout = $this->actualizar($sql_update_room, $arrData);
        
                $request = $this->actualizar($sql, $arrData);
                
                // Si es necesario, puedes agregar más acciones aquí si las fechas son iguales.
            } else {
                var_dump('no se puede actualizar'); exit;
            }
        
            //     var_dump($start_date);exit;

        //     $sql = "UPDATE reservaciones SET reservacion_estado_id = ? WHERE id_reservacion = $this->idReservation";
        //     $arrData = array(2);
        //     $request_res = $this->actualizar($sql, $arrData);
        //     // var_dump($request_res);
        //     $sql_update_room = "UPDATE habitacion SET estado_habitacion = ? WHERE idhabitacion = $idroom ";
        //     $arrData = array('Ocupada');
        //     $request_update_room_checkout = $this->actualizar($sql_update_room,$arrData);
           
        //     $request = $this->actualizar($sql, $arrData);
        // // }
        return $request;
     }


     public function selectRooms()
     {
        $sql = "SELECT *  FROM habitacion";
        $request = $this->listar($sql);
        return $request;
     }

     public function selectCategoryRoomId(int $idcategoria) 
    {
        $this->idCategoriaRoom = $idcategoria;
        $sql = "SELECT * FROM habitacion WHERE categoriahabitacionid = $this->idCategoriaRoom";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectRoomsPrices(int $idroom){
       $this->idRoom = $idroom;
       $sql = "SELECT * FROM habitacion WHERE idhabitacion = $this->idRoom";
       $request = $this->buscar($sql);
       return $request;
    }


    public function printReservationPayment(){
        $reservation_print = "SELECT * FROM reservaciones order by id_reservacion desc limit 1";
        $request_reservation_print = $this->buscar($reservation_print);
        $num_print = $request_reservation_print['id_reservacion'];
        return $num_print;
    }
    public function updateClienteReservacion(int $idUsuario, string $identificacion, string $nombre, string $correo, string $direccion){
        $this->idUsuario = $idUsuario;
        $this->identificacion = $identificacion;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->direccion = $direccion;

        $sql = "UPDATE usuario SET identificacion = ?, nombres = ?, email_user = ?, direccion = ? WHERE idusuario = $this->idUsuario";
        $arrData = array($this->identificacion, $this->nombre, $this->correo, $this->direccion);
        $request = $this->actualizar($sql, $arrData);
        return $request;
    }
    public function insertConsumo( string $usuario, int $consumo, int $habitaciones, float $subtotal, float $total_impuestos, float $total_venta, $idarticulo, $cantidad, $precio_venta){
        $this->Usuario = $usuario;
        $this->TipoComprobante = $consumo;
        $this->Habitaciones = $habitaciones;
        $this->subtTotal = $subtotal;
        $this->totalImpuestos = $total_impuestos;
        $this->TotalVenta = $total_venta;
        $this->idProducto = $idarticulo;
        $this->Cantidad = $cantidad;
        $this->PrecioVenta = $precio_venta;
        $sql = "INSERT INTO consumos(usuario,tipo_comprobante,reservaid,subtotal,total_impuestos,total_consumo) VALUES (?,?,?,?,?,?)";
        $arrData = array($this->Usuario,$this->TipoComprobante,$this->Habitaciones,$this->subtTotal,$this->totalImpuestos,$this->TotalVenta);
    $request_insert = $this->insertar($sql,$arrData);

    $idconsumo = $request_insert;
    $num_product = 0;
    $sw = true;
               
    $sql_list = "SELECT idarticulo, cantidadActual FROM detalle_consumo";
    $product = $this->listar($sql_list);

    $sql = "SELECT tipo_movimiento FROM movimiento_almacenes WHERE idmovimiento_almacen != 0";
    $tipo = $this->listar($sql);

    while($num_product < count($idarticulo)){
        $sql_detalle = "INSERT INTO detalle_consumo(consumoid,idarticulo,reservaid,cantidad,precio_venta,cantidadActual) VALUES (?,?,?,?,?,?)";
        $arrData = array($idconsumo, $idarticulo[$num_product],$this->Habitaciones,$cantidad[$num_product], $precio_venta[$num_product], $cantidad[$num_product]);
       
        if($tipo[0]['tipo_movimiento'] == 3){
            $product[0]['cantidadActual'] = $cantidad[$num_product]*-1; 
        }
        $product[0]['idarticulo'] = $idarticulo[$num_product];

        $idProdServ = $idarticulo[$num_product];

        $this->insertar($sql_detalle,$arrData) or $sw = false;

        $num_product = $num_product + 1;

        $sql_prod="SELECT * FROM producto WHERE idProducto = $idProdServ";
        $tipo_prod = $this->buscar($sql_prod);
        $unidad = $tipo_prod['unidadMedida'];

        if($unidad == 'NIU'){
            $insert = "INSERT INTO movimiento_producto(productoid,cantidad,tipo_movimiento,almacenid,movimientoid) 
            VALUES (?,?,?,?,?)";
            $arrData1 = array($product[0]['idarticulo'],$product[0]['cantidadActual'],3,1, 1);
            $request_insert = $this->insertar($insert,$arrData1);
        }
    }
    
    $consultar_total = "SELECT total FROM reservaciones WHERE id_reservacion = $this->Habitaciones";
    $request_consultar_total = $this->buscar($consultar_total);
    $total = $request_consultar_total['total'];

    $consultar_consumo = "SELECT total_consumo FROM consumos WHERE idconsumo = $idconsumo";
    $requestTotalConsumo = $this->buscar($consultar_consumo);
    $totalConsumo = $requestTotalConsumo['total_consumo'];

    $actualizarTotal = $total + $totalConsumo;

    $sql_update_reserva ="UPDATE reservaciones SET total = ? WHERE id_reservacion = $this->Habitaciones";
    $arrData = array($actualizarTotal);
    $requestUpdateReserva = $this->actualizar($sql_update_reserva, $arrData);

    return $sw and $request_insert and $requestUpdateReserva;

}
public function isDesConsumo(){
    $consumo_print = "SELECT * FROM consumos order by idconsumo desc limit 1";
    $request_consumo_print = $this->buscar($consumo_print);
    $num_print = $request_consumo_print['idconsumo'];
    return $num_print;
}
public function postRetonarConsumo(int $detalleConsumo, int $idConsumo, string $nombreUser){
    $this->detalleConsumo = $detalleConsumo;
    $this->idConsumo = $idConsumo;
    $this->nombreUser = $nombreUser;

    $consultarCantidadItems = "SELECT COUNT(consumoid) as cantidadItems FROM `detalle_consumo` WHERE consumoid = $this->idConsumo";
    $requestCantidadItems =  $this->buscar($consultarCantidadItems);
    $cantidadItems = $requestCantidadItems['cantidadItems'];

    if($cantidadItems == 1){

        $consultarIdProducto = "SELECT idarticulo, cantidadActual, reservaid, precio_venta FROM detalle_consumo WHERE id_detalle_consumo = $this->detalleConsumo AND consumoid = $this->idConsumo";
        $requestConsultaId = $this->buscar($consultarIdProducto);

        $idProducto = intval($requestConsultaId['idarticulo']);
        $cantidadProducto = intval($requestConsultaId['cantidadActual']);
        $idReserva = intval($requestConsultaId['reservaid']);
        $precioDetalleConsumo = floatval($requestConsultaId['precio_venta']);

        $precioTotalConsumo = $cantidadProducto * $precioDetalleConsumo;

        $consultarTotalReserva = "SELECT total FROM reservaciones WHERE id_reservacion = $idReserva";
        $requestTotalReserva = $this->buscar($consultarTotalReserva);
        $totalReservacion = floatval($requestTotalReserva['total']);

        $totalActual = $totalReservacion - $precioTotalConsumo;

        $update_total = "UPDATE reservaciones SET total = ? WHERE id_reservacion = $idReserva";
        $arrUpdate = array($totalActual);
        $requestUpdateTotal = $this->actualizar($update_total, $arrUpdate);

        $insertDetalleMovimiento = "INSERT INTO detalle_movimiento_almacen(movimientoid, almacenid, productoid, cantidad_retirada, descripcion, usuario) VALUES (?,?,?,?,?,?)";
        $arrDataInsertDetalleMovimiento = array(8, 1, $idProducto,$cantidadProducto, "Retorno de Producto", $this->nombreUser);
        $requestInsertDetalleMovimiento = $this->insertar($insertDetalleMovimiento,$arrDataInsertDetalleMovimiento);

        $insertMovimientoProducto = "INSERT INTO movimiento_producto(productoid, cantidad, tipo_movimiento, almacenid, movimientoid) VALUES (?,?,?,?,?)";
        $arrDataInsertMovimientoProducto = array($idProducto, $cantidadProducto, 10, 1, 8);
        $resquestInsertMovimientoProducto = $this->insertar($insertMovimientoProducto, $arrDataInsertMovimientoProducto);

        $sql = "DELETE FROM detalle_consumo WHERE id_detalle_consumo = $this->detalleConsumo AND consumoid = $this->idConsumo";
        $request = $this->eliminar($sql);

        $sqlConsumo = "DELETE FROM consumos WHERE idconsumo = $this->idConsumo";
        $requestDelete = $this->eliminar($sqlConsumo);

        return $request and $requestDelete and $requestInsertDetalleMovimiento and $resquestInsertMovimientoProducto and $requestUpdateTotal;
        
    }else if($cantidadItems > 1){

        $listartIdProducto = "SELECT id_detalle_consumo FROM detalle_consumo WHERE id_detalle_consumo AND consumoid = $this->idConsumo";
        $requestListarIdProducto = $this->listar($listartIdProducto);

        foreach($requestListarIdProducto as $buscarIdProducto):

            $idConsumoDetalle = intval($buscarIdProducto['id_detalle_consumo']);

            if($idConsumoDetalle == $detalleConsumo){

            $consultarIdProducto = "SELECT idarticulo, cantidadActual, reservaid, precio_venta FROM detalle_consumo WHERE id_detalle_consumo = $this->detalleConsumo AND consumoid = $this->idConsumo";
            $resquestConsultarConsumo = $this->buscar($consultarIdProducto);

            $idProducto = intval($resquestConsultarConsumo['idarticulo']);
            $cantidadProducto = intval($resquestConsultarConsumo['cantidadActual']);
            $idReserva = intval($resquestConsultarConsumo['reservaid']);
            $precioDetalleConsumo = floatval($resquestConsultarConsumo['precio_venta']);

            $precioTotalConsumo = $cantidadProducto * $precioDetalleConsumo;

            $consultarTotalReserva = "SELECT total FROM reservaciones WHERE id_reservacion = $idReserva";
            $requestTotalReserva = $this->buscar($consultarTotalReserva);
            $totalReservacion = floatval($requestTotalReserva['total']);
    
            $totalActual = $totalReservacion - $precioTotalConsumo;

            $update_total = "UPDATE reservaciones SET total = ? WHERE id_reservacion = $idReserva";
            $arrUpdate = array($totalActual);
            $requestUpdateTotal = $this->actualizar($update_total, $arrUpdate);
    
            $insertDetalleMovimiento = "INSERT INTO detalle_movimiento_almacen(movimientoid, almacenid, productoid, cantidad_retirada, descripcion, usuario) VALUES (?,?,?,?,?,?)";
            $arrDataInsertDetalleMovimiento = array(8, 1,$idProducto,$cantidadProducto, "Retorno de Producto",  $this->nombreUser);
            $requestInsertDetalleMovimiento = $this->insertar($insertDetalleMovimiento,$arrDataInsertDetalleMovimiento);

            $insertMovimientoProducto = "INSERT INTO movimiento_producto(productoid, cantidad, tipo_movimiento, almacenid, movimientoid) VALUES (?,?,?,?,?)";
            $arrDataInsertMovimientoProducto = array($idProducto, $cantidadProducto, 1, 1, 8);
            $resquestInsertMovimientoProducto = $this->insertar($insertMovimientoProducto, $arrDataInsertMovimientoProducto);

            $consultarPrecioProducto = "SELECT precio_venta FROM producto WHERE idProducto = $idProducto";
            $requestConsultaPrecio = $this->buscar($consultarPrecioProducto);

            $precioProducto = $requestConsultaPrecio['precio_venta'];
            $precioTotal = $precioProducto * $cantidadProducto;

            $consultarPrecioConsumo = "SELECT total_consumo FROM consumos WHERE idconsumo = $this->idConsumo";
            $requestPrecioConsumo = $this->buscar($consultarPrecioConsumo);

            $precioTotalConsumo = $requestPrecioConsumo['total_consumo'];

            $precioConsumo = $precioTotalConsumo - $precioTotal;
            $igv = round(($precioConsumo/110)*10, 2);
            $subtotal = $precioConsumo - $igv;

            $this->$precioConsumo = $precioConsumo;
            $this->$igv = $igv;
            $this->$subtotal = $subtotal;
            
            $updatePrecioConsumo = "UPDATE consumos SET subtotal = ?, total_impuestos = ?, total_consumo = ? WHERE idconsumo = $this->idConsumo";
            $arrUpdate = array($this->$subtotal, $this->$igv, $this->$precioConsumo);
            $requestUpdate = $this->actualizar($updatePrecioConsumo, $arrUpdate);

            $sqldelete = "DELETE FROM detalle_consumo WHERE id_detalle_consumo = $this->detalleConsumo AND consumoid = $this->idConsumo";
            $request = $this->eliminar($sqldelete);
            
            return $request and $requestUpdate and $requestInsertDetalleMovimiento and $resquestInsertMovimientoProducto and $requestUpdateTotal;
            }
        endforeach;
    }
}
function postDesecharConsumo(int $idConsumo, int $idDetalleConsumo, int $cantidadDesechada, string $descripcionDesechable){
    $this->idConsumo = $idConsumo;
    $this->idDetalleConsumo = $idDetalleConsumo;
    $this->cantidadDesechada = $cantidadDesechada;
    $this->descripcionDesechable = $descripcionDesechable;

    $consultarCantidadItems = "SELECT COUNT(consumoid) as cantidadItems FROM detalle_consumo WHERE consumoid = $this->idConsumo";
    $requestCantidadItems =  $this->buscar($consultarCantidadItems);
    $cantidadItems = $requestCantidadItems['cantidadItems'];
    

    $consumoDesechadoProducto = "SELECT cantidad, cantidadConsumoDesechado FROM detalle_consumo WHERE id_detalle_consumo = $this->idDetalleConsumo AND consumoid = $this->idConsumo";
    $requestConsumoDesechadoProducto = $this->buscar($consumoDesechadoProducto);
    $cantidadConsumo = $requestConsumoDesechadoProducto['cantidad'];
    $cantidadDesechadaAnterior = $requestConsumoDesechadoProducto['cantidadConsumoDesechado'];

    $cantidadDesechadaActual = $cantidadDesechada + $cantidadDesechadaAnterior;

    $cantidadActual = $cantidadConsumo - $cantidadDesechadaActual;
    // $this->cantidadActual = $cantidadActual;

    $update_descripcion_cantidad = "UPDATE detalle_consumo SET descripcionConsumoDesechado = ?, cantidadConsumoDesechado = ?, cantidadActual = ? WHERE id_detalle_consumo = $this->idDetalleConsumo AND consumoid = $this->idConsumo";
    $arrData_update_descripcion_cantidad = array($this->descripcionDesechable, $cantidadDesechadaActual, $cantidadActual);
    $request_update_descripcion_cantidad = $this->actualizar($update_descripcion_cantidad, $arrData_update_descripcion_cantidad);
        

    if($cantidadItems == 1){

        $consultaPrecioCantidad = "SELECT cantidadActual, precio_venta, reservaid, cantidadConsumoDesechado, cantidad FROM detalle_consumo WHERE id_detalle_consumo = $this->idDetalleConsumo AND consumoid = $this->idConsumo";
        $requestPrecioCantidad = $this->buscar($consultaPrecioCantidad);
        $cantidad = $requestPrecioCantidad['cantidad'];
        $precioProducto = $requestPrecioCantidad['precio_venta'];
        $idReserva = $requestPrecioCantidad['reservaid'];
        $cantidadActualDesechada = $requestPrecioCantidad['cantidadConsumoDesechado'];
                
        if($cantidad == $cantidadActualDesechada){

            $precioDescuento = $cantidadDesechada * $precioProducto;

            $consultarTotalReserva = "SELECT total FROM reservaciones WHERE id_reservacion = $idReserva";
            $requestTotalReserva = $this->buscar($consultarTotalReserva);
            $totalReservacion = floatval($requestTotalReserva['total']);

            $totalActual = $totalReservacion - $precioDescuento;

            $update_total = "UPDATE reservaciones SET total = ? WHERE id_reservacion = $idReserva";
            $arrUpdate = array($totalActual);
            $requestUpdateTotal = $this->actualizar($update_total, $arrUpdate);

            $updateEstadoDetalle = "UPDATE detalle_consumo SET estado = ? WHERE id_detalle_consumo = $this->idDetalleConsumo AND consumoid = $this->idConsumo";
            $arrDataUpdateEstadoDetalle = array(0);
            $requestUpdateEstadoDetalle = $this->actualizar($updateEstadoDetalle, $arrDataUpdateEstadoDetalle);

            $updatePriceConsumo = "UPDATE consumos SET subtotal = ?, total_impuestos = ?, total_consumo = ?, consumo_estado = ? WHERE idconsumo = $this->idConsumo";
            $arrDataUpdatePriceConsumo = array(0.0, 0.0, 0.0, 0);
            $requestUpdatePriceConsumo = $this->actualizar($updatePriceConsumo, $arrDataUpdatePriceConsumo);

            return $request_update_descripcion_cantidad and $requestUpdateEstadoDetalle and $requestUpdatePriceConsumo and $requestUpdateTotal;

        }else{

            $precioDescuento = $cantidadDesechada * $precioProducto;

            $consultarTotalReserva = "SELECT total FROM reservaciones WHERE id_reservacion = $idReserva";
            $requestTotalReserva = $this->buscar($consultarTotalReserva);
            $totalReservacion = floatval($requestTotalReserva['total']);

            $totalActual = $totalReservacion - $precioDescuento;

            $update_total = "UPDATE reservaciones SET total = ? WHERE id_reservacion = $idReserva";
            $arrUpdate = array($totalActual);
            $requestUpdateTotal = $this->actualizar($update_total, $arrUpdate);

            $consultaPrecioTotalConsumo = "SELECT total_consumo FROM consumos WHERE idconsumo =$this->idConsumo";
            $requestConsultarPrecioTotalConsumo = $this->buscar($consultaPrecioTotalConsumo);
            $totalConsumo = $requestConsultarPrecioTotalConsumo['total_consumo'];

            $precioActual = $totalConsumo - $precioDescuento;
            $igv = round(($precioActual/110)*10, 2);
            $subtotal = $precioActual - $igv;

            $this->$precioActual = $precioActual;
            $this->$igv = $igv;
            $this->$subtotal = $subtotal;

            $actualizarPrecioTotalConsumo = "UPDATE consumos SET subtotal = ?, total_impuestos = ?,total_consumo = ? WHERE idconsumo = $this->idConsumo";
            $arrDataActualizarPrecioTotalConsumo = array($this->$subtotal,  $this->$igv,$this->$precioActual);
            $requestActualizarPrecioTotalConsumo = $this->actualizar($actualizarPrecioTotalConsumo,$arrDataActualizarPrecioTotalConsumo);

            return $request_update_descripcion_cantidad and $requestActualizarPrecioTotalConsumo and $requestUpdateTotal;
        }
    }else{

        $listartIdProducto = "SELECT id_detalle_consumo FROM detalle_consumo WHERE consumoid = $this->idConsumo";
        $requestListarIdProducto = $this->listar($listartIdProducto);

        foreach($requestListarIdProducto as $buscarIdProducto):
            
            $idConsumoDetalle = intval($buscarIdProducto['id_detalle_consumo']);

            if($idConsumoDetalle == $idDetalleConsumo){

                $consultaPrecioCantidad = "SELECT cantidadActual, precio_venta, reservaid, cantidadConsumoDesechado, cantidad FROM detalle_consumo WHERE id_detalle_consumo = $idConsumoDetalle AND consumoid = $this->idConsumo";
                $requestPrecioCantidad = $this->buscar($consultaPrecioCantidad);
                $precioProducto = $requestPrecioCantidad['precio_venta'];
                $idReserva = $requestPrecioCantidad['reservaid'];
                $cantidad = $requestPrecioCantidad['cantidad'];
                $cantidadActualDesechada = $requestPrecioCantidad['cantidadConsumoDesechado'];

                if($cantidad == $cantidadActualDesechada){

                    $precioDescuento = $cantidadDesechada * $precioProducto;

                    $consultarTotalReserva = "SELECT total FROM reservaciones WHERE id_reservacion = $idReserva";
                    $requestTotalReserva = $this->buscar($consultarTotalReserva);
                    $totalReservacion = floatval($requestTotalReserva['total']);

                    $totalActual = $totalReservacion - $precioDescuento;

                    $update_total = "UPDATE reservaciones SET total = ? WHERE id_reservacion = $idReserva";
                    $arrUpdate = array($totalActual);
                    $requestUpdateTotal = $this->actualizar($update_total, $arrUpdate);

                    $updateEstadoDetalle = "UPDATE detalle_consumo SET estado = ? WHERE id_detalle_consumo = $this->idDetalleConsumo AND consumoid = $this->idConsumo";
                    $arrDataUpdateEstadoDetalle = array(0);
                    $requestUpdateEstadoDetalle = $this->actualizar($updateEstadoDetalle, $arrDataUpdateEstadoDetalle);

                    $consultaPrecioTotalConsumo = "SELECT total_consumo FROM consumos WHERE idconsumo =$this->idConsumo";
                    $requestConsultarPrecioTotalConsumo = $this->buscar($consultaPrecioTotalConsumo);
                    $totalConsumo = $requestConsultarPrecioTotalConsumo['total_consumo'];
    
                    $precioActual = $totalConsumo - $precioDescuento;
                    $igv = round(($precioActual/110)*10, 2);
                    $subtotal = $precioActual - $igv;
    
                    $this->$precioActual = $precioActual;
                    $this->$igv = $igv;
                    $this->$subtotal = $subtotal;
    
                    $actualizarPrecioTotalConsumo = "UPDATE consumos SET subtotal = ?, total_impuestos = ?,total_consumo = ? WHERE idconsumo = $this->idConsumo";
                    $arrDataActualizarPrecioTotalConsumo = array($this->$subtotal,  $this->$igv,$this->$precioActual);
                    $requestActualizarPrecioTotalConsumo = $this->actualizar($actualizarPrecioTotalConsumo,$arrDataActualizarPrecioTotalConsumo);
    
                    return $request_update_descripcion_cantidad and $requestUpdateEstadoDetalle and $requestActualizarPrecioTotalConsumo and $requestUpdateTotal;

                }else{
                        
                    $precioDescuento = $cantidadDesechada * $precioProducto;

                    $consultarTotalReserva = "SELECT total FROM reservaciones WHERE id_reservacion = $idReserva";
                    $requestTotalReserva = $this->buscar($consultarTotalReserva);
                    $totalReservacion = floatval($requestTotalReserva['total']);

                    $totalActual = $totalReservacion - $precioDescuento;

                    $update_total = "UPDATE reservaciones SET total = ? WHERE id_reservacion = $idReserva";
                    $arrUpdate = array($totalActual);
                    $requestUpdateTotal = $this->actualizar($update_total, $arrUpdate);

                    $consultaPrecioTotalConsumo = "SELECT total_consumo FROM consumos WHERE idconsumo =$this->idConsumo";
                    $requestConsultarPrecioTotalConsumo = $this->buscar($consultaPrecioTotalConsumo);
                    $totalConsumo = $requestConsultarPrecioTotalConsumo['total_consumo'];

                    $precioActual = $totalConsumo - $precioDescuento;
                    $igv = round(($precioActual/110)*10, 2);
                    $subtotal = $precioActual - $igv;

                    $this->$precioActual = $precioActual;
                    $this->$igv = $igv;
                    $this->$subtotal = $subtotal;

                    $actualizarPrecioTotalConsumo = "UPDATE consumos SET subtotal = ?, total_impuestos = ?,total_consumo = ? WHERE idconsumo = $this->idConsumo";
                    $arrDataActualizarPrecioTotalConsumo = array($this->$subtotal,  $this->$igv,$this->$precioActual);
                    $requestActualizarPrecioTotalConsumo = $this->actualizar($actualizarPrecioTotalConsumo,$arrDataActualizarPrecioTotalConsumo);

                    return $request_update_descripcion_cantidad and $requestActualizarPrecioTotalConsumo and $requestUpdateTotal;
                        }
            }
            
        endforeach;
    }
}
public function updateAlmacenarDescuento(int $idReservation, float $descuento){
    $this->idReservation = $idReservation;
    $this->descuento = $descuento;

    $consultar = "SELECT descuento, total FROM reservaciones WHERE id_reservacion = $this->idReservation";
    $requestConsulta = $this->buscar($consultar);
    $total = $requestConsulta['total'];
    $descuentoAntiguo = $requestConsulta['descuento'];

    $descuentoActual = $descuento + $descuentoAntiguo;
    $totalActual = $total - $descuento;

    $sql = "UPDATE reservaciones SET descuento = ?, total = ? WHERE id_reservacion = $this->idReservation";
    $arrData = array($descuentoActual, $totalActual);
    $request = $this->actualizar($sql, $arrData);
    return $request;
}
public function actualizarPrecioReserva(int $id, float $descuento){
    $this->id = $id;
    $this->descuento = $descuento;
    
    $consultar = "SELECT total FROM reservaciones WHERE id_reservacion = $this->id";
    $requestConsulta = $this->buscar($consultar);
    $total = $requestConsulta['total'];

    $totalActual = $total + $descuento;

    $sql = "UPDATE reservaciones SET total = ?, descuento = ? WHERE id_reservacion = $this->id";
    $arrData = array($totalActual, 0);
    $request = $this->actualizar($sql, $arrData);
    
    return $request;

}
public function insertAumentarEstadia(int $idreservacion, float $precio, string $fecha, int $tiempoDias, int $tiempoHoras, $tiempoMinutos, $tipoServicio){
    $this->idreservacion = $idreservacion;
    $this->precio = $precio;
    $this->fecha = $fecha;
    $this->tiempoDias = $tiempoDias;
    $this->tiempoHoras = $tiempoHoras;
    $this->tiempoMinutos = $tiempoMinutos;
    $this->tipoServicio = $tipoServicio;

    $consultar_reservacion = "SELECT * FROM reservaciones WHERE id_reservacion = $idreservacion";
    $request_consultar_reservacion = $this->buscar($consultar_reservacion);
    $totalAntiguo = $request_consultar_reservacion['total'];
    $diasAdicionalAntiguo = $request_consultar_reservacion['diasAdicional'];
    $horasAdicionalAntiguo = $request_consultar_reservacion['horasAdicional'];
    $minutosAdicionalAntiguo = $request_consultar_reservacion['minutosAdicional'];

    $totalActual = $totalAntiguo + $precio;
    $diasAdicionalActual = $diasAdicionalAntiguo + $tiempoDias;
    $horasAdicionalActual = $horasAdicionalAntiguo + $tiempoHoras;
    $minutosAdicionalActual = $minutosAdicionalAntiguo + $tiempoMinutos;

    $actualizarReservacion = "UPDATE reservaciones SET total = ?, fecha_fin = ?, diasAdicional = ?, horasAdicional = ?, minutosAdicional = ? WHERE id_reservacion = $this->idreservacion";
    $arrData = array($totalActual, $this->fecha, $diasAdicionalActual, $horasAdicionalActual, $minutosAdicionalActual);
    $request_actualizarReservacion = $this->actualizar($actualizarReservacion, $arrData);

    $user_request = "SELECT * FROM usuario order by idusuario desc limit 1";
    $request_user_cliente = $this->buscar($user_request);
    $user_num = $request_user_cliente['idusuario'];

    $inser_reser_product = "INSERT INTO producto(categoriaid, sunatid, nombre, precio_venta, estado, unidadMedida) values(?,?,?,?,?,?)";
    $arrData = array(1,26700,'AUMENTO DE ESTADIA',$this->precio, 1, "ZZ");
    $request_prod = $this->insertar($inser_reser_product,$arrData);

    $insert_servicio_reserva = "INSERT INTO consumos(usuario,tipo_comprobante,reservaid,subtotal,total_impuestos,total_consumo,consumo_estado) VALUES(?,?,?,?,?,?,?)";
    $arrData = array($user_num, 5,  $this->idreservacion,1,2,$this->precio,1);
    $request_insert_serv = $this->insertar($insert_servicio_reserva, $arrData);

    $insert_detalle_serv_reserva = "INSERT INTO detalle_consumo(consumoid,idarticulo,reservaid, cantidad,precio_venta, cantidadActual, diasAdicional, horasAdicional, minutosAdicional, tipoServicio) VALUES(?,?,?,?,?,?,?,?,?,?)";
    $arrData = array($request_insert_serv,$request_prod, $this->idreservacion,1, $this->precio, 1, $this->tiempoDias, $this->tiempoHoras, $this->tiempoMinutos, $this->tipoServicio);
    $request_insert_detalle_serv_reserva = $this->insertar($insert_detalle_serv_reserva, $arrData);

    return $request_actualizarReservacion and $request_insert_detalle_serv_reserva;
    }

    public function deleteAumentoEstadia(int $idDetalleConsumo, int $idConsumo){
        $this->idDetalleConsumo = $idDetalleConsumo;
        $this->idConsumo = $idConsumo;

        $consultar_detalle_consumo = "SELECT * FROM detalle_consumo WHERE id_detalle_consumo = $this->idDetalleConsumo AND consumoid = $this->idConsumo";
        $request_consultar_detalle_consumo = $this->buscar($consultar_detalle_consumo);

        $idReservacion = $request_consultar_detalle_consumo['reservaid'];
        $diasDescontar = $request_consultar_detalle_consumo['diasAdicional'];
        $horasDescontar = $request_consultar_detalle_consumo['horasAdicional'];
        $minutosDescontar = $request_consultar_detalle_consumo['minutosAdicional'];
        $costoDeServicio = $request_consultar_detalle_consumo['precio_venta'];

        $consultar_reservacion = "SELECT * FROM reservaciones WHERE id_reservacion = $idReservacion";
        $request_consultar_reservaciones = $this->buscar($consultar_reservacion);
        
        $fecha_fin_antigua = $request_consultar_reservaciones['fecha_fin'];
        $diasAdicionalesAntiguo = $request_consultar_reservaciones['diasAdicional'];
        $horasAdicionalesAntiguo = $request_consultar_reservaciones['horasAdicional'];
        $minutosAdicionalesAntiguo = $request_consultar_reservaciones['minutosAdicional'];
        $totalAntiguo = $request_consultar_reservaciones['total'];

        $end_date_result_dias = strtotime ( '-'.$diasDescontar.'day' , strtotime ($fecha_fin_antigua) ) ; 
        $end_date_dias = date ( 'Y-m-d H:i:s' , $end_date_result_dias); 

        $end_date_result_horas = strtotime ( '-'.$horasDescontar.'hour' , strtotime ($end_date_dias) ) ; 
        $end_date_horas = date ( 'Y-m-d H:i:s' , $end_date_result_horas);

        $end_date_result_minutos = strtotime ( '-'.$minutosDescontar.'minute' , strtotime ($end_date_horas) ) ; 

        $fecha_fin_actual = date ( 'Y-m-d H:i:s' , $end_date_result_minutos); 
        $totalActual = $totalAntiguo - $costoDeServicio;
        $diasAdicionalesActual = $diasAdicionalesAntiguo - $diasDescontar;
        $horasAdicionalesActual = $horasAdicionalesAntiguo - $horasDescontar;
        $minutosAdicionalesActual = $minutosAdicionalesAntiguo - $minutosDescontar;

        $update_reservacion = "UPDATE reservaciones SET fecha_fin = ?, total = ?, diasAdicional = ?, horasAdicional = ?, minutosAdicional = ? WHERE id_reservacion = $idReservacion";
        $arrData = array($fecha_fin_actual, $totalActual, $diasAdicionalesActual, $horasAdicionalesActual, $minutosAdicionalesActual);
        $request_update_reservacion = $this->actualizar($update_reservacion, $arrData);

        $update_consumo = "UPDATE consumos SET subtotal = ?, total_impuestos = ?, total_consumo = ?, consumo_estado = ? WHERE idconsumo = $idConsumo";
        $arrData = array(0,0,0,0);
        $request_update_consumo = $this->actualizar($update_consumo, $arrData);

        $update_detalle_consumo = "UPDATE detalle_consumo SET estado = ?, descripcionConsumoDesechado = ?, cantidadConsumoDesechado = ?,cantidadActual = ? WHERE id_detalle_consumo = $this->idDetalleConsumo AND consumoid = $this->idConsumo";
        $arrData = array(0,'SERVICIO ANULADO', 1, 0);
        $request_update_detalle_consumo = $this->actualizar($update_detalle_consumo, $arrData);

        return $request_update_reservacion AND $request_update_consumo AND $request_update_detalle_consumo;
    }

    public function restablecerBoletaFactura(){

        $consultarReservacionesPayments = "SELECT * FROM reservaciones_payments order by id desc limit 1";
        $requestConsultarReservacionesPayments = $this->buscar($consultarReservacionesPayments);

        $fecha_hora = $requestConsultarReservacionesPayments['created_at'];

        $eliminarReservacionesPayments = "DELETE FROM reservaciones_payments WHERE created_at = '".$fecha_hora."'";
        $requestEliminarReservacionesPayments = $this->eliminar($eliminarReservacionesPayments);

        $eliminarMovimientoCaja = "DELETE FROM movimiento_caja WHERE created_at = '".$fecha_hora."'";
        $requestEliminarMovimientoCaja = $this->eliminar($eliminarMovimientoCaja);

        $eliminarReservaMedioPago = "DELETE FROM reserva_medio_pago WHERE created_at = '".$fecha_hora."'";
        $requestEliminarReservaMedioPago = $this->eliminar($eliminarReservaMedioPago);

        return $requestEliminarMovimientoCaja AND $requestEliminarReservacionesPayments;

    }
}
?>

