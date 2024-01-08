<?php

 class SalesModel extends Mysql{

    public $idVenta;
    public $idProducto;
    public $idCliente;
    public $identifacion;
    public $Usuario;
    public $TipoComprobante;
    public $medioPago;
    public $subtTotal;
    public $totalImpuestos;
    public $TotalVenta;
    public $Cantidad;
    public $PrecioVenta;
    public $Consumo;
    public $Habitaciones;
    public $identificacion;
 
    public function __construct(){
        parent::__construct();
    }
    
    public function productsList(){
        $sql = "SELECT * FROM producto WHERE estado !=0";
        $request = $this->listar($sql);
        return $request;
    }

    public function insertSale($nombre, string $identificacion, string $correo, string $direccion, $idproducto, $cantidad,$precio_venta, int $idcomprobante,$medio_pago,$total_impuesto,$subtotal_venta,$total_venta,$pagos_medio, $usuario, $idUsuarioLogeado){
    
        $this->nombre = $nombre;
        $this->identificacion = $identificacion;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->idproducto = $idproducto;
        $this->cantidad = $cantidad;
        $this->precio_venta = $precio_venta;
        $this->idcomprobante = $idcomprobante;
        $this->medio_pago = $medio_pago;
        $this->total_impuesto = $total_impuesto;
        $this->subtotal_venta = $subtotal_venta;
        $this->total_venta = $total_venta;
        $this->pagos_medio = $pagos_medio;
        $this->usuario = $usuario;
        $this->idUsuarioLogeado = $idUsuarioLogeado;

        $sql_insert_cliente = "INSERT INTO usuario(identificacion,nombres,apellidos,telefono,email_user,direccion,password,rolid,estado) VALUES(?,?,?,?,?,?,?,?,?)";
        $arrData = array($this->identificacion,$this->nombre,'','99999999',$this->correo,$this->direccion,123456789,7,1);
        $request_inset_cliente = $this->insertar($sql_insert_cliente,$arrData);
        $user_request = "SELECT * FROM usuario order by idusuario desc limit 1";
        $request_user_cliente = $this->buscar($user_request);
        $user_num = $request_user_cliente['idusuario'];
           

        $sql = "INSERT INTO venta(clienteid,usuario,tipo_comprobante,subtotal,total_impuestos,total_venta,venta_estado_id) VALUES (?,?,?,?,?,?,?)";
        $arrData = array($user_num,$this->usuario,$this->idcomprobante,$this->subtotal_venta,$this->total_impuesto,$this->total_venta,2);
       
        $request_insert = $this->insertar($sql,$arrData);
      

        $idventa = $request_insert;
        $num_product = 0;
        $sw = true;

        $sql_config = "SELECT * FROM configuracion WHERE id = 1";
        $request_sql_config = $this->buscar($sql_config);
        $serie = $request_sql_config['serie_boleta'];
        $factura = $request_sql_config['serie_factura'];
        $cliente = 0;
        $idCliente = 0;
        $venta = "SELECT * FROM venta order by idventa desc limit 1";
        $request_venta = $this->buscar($venta);
                   
        $sql_list = "SELECT idarticulo, cantidad FROM detalle_venta";
        $product = $this->listar($sql_list);

        $sql = "SELECT tipo_movimiento FROM movimiento_almacenes WHERE idmovimiento_almacen != 0";
        $tipo = $this->listar($sql);

        while($num_product < count($idproducto)){
            $sql_detalle = "INSERT INTO detalle_venta(ventaid,idarticulo,cantidad,precio_venta) VALUES (?,?,?,?)";
            $arrData = array($idventa, $idproducto[$num_product],$cantidad[$num_product], $precio_venta[$num_product]);
           
            if($tipo[0]['tipo_movimiento'] == 3){
                $product[0]['cantidad'] = $cantidad[$num_product]*-1; 
            }
            $product[0]['idarticulo'] = $idproducto[$num_product];

            $idProdServ = $idproducto[$num_product];

            $this->insertar($sql_detalle,$arrData) or $sw = false;

            $num_product = $num_product + 1;

            $sql_prod="SELECT * FROM producto WHERE idProducto = $idProdServ";
            $tipo_prod = $this->buscar($sql_prod);

            $unidad = $tipo_prod['unidadMedida'];

            if($unidad == 'NIU'){

                $insert = "INSERT INTO movimiento_producto(productoid,cantidad,tipo_movimiento,almacenid,movimientoid) 
                VALUES (?,?,?,?,?)";
                $arrData1 = array($product[0]['idarticulo'],$product[0]['cantidad'],3,1, 1);
                $request_insert = $this->insertar($insert,$arrData1);

            }
            
        }

        $num_medio = 0;
        $mp = true;

        while($num_medio < count($medio_pago)){
            $sql_caja = "INSERT INTO movimiento_caja(monedaid,tipomovimientocaja_id,cajaid,turnoid,mediopagoid,usuarioid,monto,descripcion) VALUES (?,?,?,?,?,?,?,?)";
            $arrData = array(1,3,1,1,$medio_pago[$num_medio],$this->idUsuarioLogeado,$pagos_medio[$num_medio],'Pago de venta');
            $request_caja = $this->insertar($sql_caja,$arrData);

            $sql_detalle = "INSERT INTO venta_medio_pago(id_venta,mediopago,monto) VALUES (?,?,?)";
            $arrData = array($idventa, $medio_pago[$num_medio], $pagos_medio[$num_medio]);
            $this->insertar($sql_detalle,$arrData) or $mp = false;
            $num_medio = $num_medio + 1;
        }

        $sql_turno = "SELECT idturno FROM turnos WHERE inicio_turno <= '".date("H:i:s")."' AND fin_turno >= '".date("H:i:s")."'";
        $request_turno = $this->listar($sql_turno);

        $sql_venta_medio_pago = "SELECT mp.nombre FROM venta_medio_pago vp INNER JOIN medio_pago mp ON vp.mediopago=mp.idmediopago WHERE vp.id_venta = $idventa";
        $request_venta_medio_pago = $this->listar($sql_venta_medio_pago);

       
        $medios = array();
        for ($i=0; $i <count($request_venta_medio_pago) ; $i++) { 
            $medios[] = $request_venta_medio_pago[$i]['nombre'];
        }
       
        if($this->idcomprobante == 2){
            $tipoDoc = 2;
            $cont = 0;
            
            $cabecera = array();
            $cabecera["operacion"] = "generar_comprobante";
            $cabecera["tipo_de_comprobante"] = "2";
            $cabecera["serie"] = $serie;

            $cabecera["numero"] = str_pad($cont++, 8, "0", STR_PAD_LEFT);
            $cabecera["sunat_transaction"] = 1;
            $cabecera["cliente_tipo_de_documento"] = '1';
            $cabecera["cliente_numero_de_documento"] = $identificacion;
            $cabecera["cliente_denominacion"] = $nombre;
            $cabecera["cliente_email"] = $correo;
            $cabecera["cliente_email_1"] = "";
            $cabecera["cliente_email_2"] = "";
            $cabecera["fecha_de_emision"] = date("d-m-Y");
            $cabecera["fecha_de_vencimiento"] = "";
            $cabecera["moneda"] = 1;
            $cabecera["tipo_de_cambio"] = "";
            $cabecera["porcentaje_de_igv"] = "10.00";
            $cabecera["descuento_global"] =  floatval(0.00);
            $cabecera["total_descuento"] =  floatval(0.00);
            $cabecera["total_anticipo"] = "";
            $cabecera["total_anticipo"] = "";

            $cabecera["total_gravada"] = number_format(floatval($request_venta['subtotal']), 3, ".", "");
            $cabecera["total_inafecta"] = "";
            $cabecera["total_exonerada"] = "";
            $cabecera["total_igv"] = number_format(floatval($request_venta['total_impuestos']), 3, ".", "");
            $cabecera["total_gratuita"] = "";
            $cabecera["total_otros_cargos"] = "";
            $cabecera["total"] = number_format(floatval($request_venta['total_venta']), 3, ".", "");
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
            // var_dump($request_sql_boletas['id']);
            // exit;
            if(empty($request_sql_boletas['id'])){
                $numero = 1;
            }else{
                $numero = $request_sql_boletas['id'] + 1;
            }
            // var_dump($numero);
            // exit;

            $items = array();
            $venta_detalle = "SELECT *  FROM detalle_venta WHERE ventaid='".$request_venta['idventa']."'";
            $request_venta_detalle = $this->listar($venta_detalle);
            foreach($request_venta_detalle as $value){
                $item = array();
                $product = "SELECT * FROM producto WHERE idProducto = '".$value['idarticulo']."'";
                $request_product = $this->buscar($product);
                $valor_sunat = $request_product['sunatid'];
                $separar = explode("_",$valor_sunat);
                $codigo = $separar[0];
    
                // TODO: CAMBIAR IGV 1.10
                $neto = $value['precio_venta'] / 1.10;
                // $igv = ($value['precio_venta'] - $neto) * $value['cantidad'];

                $igv = $_POST['impuestos_venta'];

                // var_dump($igv);
    
                $item["unidad_de_medida"] = $request_product['unidadMedida'];
                $item["codigo"] = $value['idarticulo'];
                $item["descripcion"] = $request_product['nombre'];
                $item["cantidad"] = $value['cantidad'];
                $item["codigo_producto_sunat"] = "10000000";
                $item["valor_unitario"] = number_format(floatval($neto), 3, ".", "");
                $item["precio_unitario"] = number_format(floatval($value['precio_venta']), 3, ".", "");
                $item["descuento"] = '';
                $item["subtotal"] =  number_format(floatval(($value['precio_venta'] / 1.10) * $value['cantidad']), 3, ".", "");
                $item["tipo_de_igv"] = 1;
                $item["igv"] = number_format($igv, 3, ".", "");
                $item["total"] = number_format(floatval($value['precio_venta'] * $value['cantidad']), 3, ".", "");
                $item["anticipo_regularizacion"] = false;
                $item["anticipo_documento_serie"] = '';
                // var_dump($_POST['impuestos_venta']);
                $items[] = $item;

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
                            $arrVentaBoleta = array($numero,$request_venta['idventa'],'',$serie,1);
                            $insert_boleta = $this->insertar($venta_boleta,$arrVentaBoleta);
    
                            $array_respuesta["exito"] = 1;
                            $array_respuesta["mensaje"] = "Se realizo el pago correctamente.";                        
                            return $array_respuesta;
                        }else{
                            if (!is_null($leer_respuesta)){
                                // var_dump($leer_respuesta);
                                $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                                $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                                $insert_comprobante_hash = $this->insertar($qr,$arrData);
    
                                $venta_boleta = "INSERT INTO boleta(id,id_venta,token,serie,estado_fila) VALUES (?,?,?,?,?)";
                                $arrVentaBoleta = array($numero,$request_venta['idventa'],'',$serie,1);
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
        
            }
            return $respuesta and $insert_comprobante_hash and $insert_boleta;
        }else if($this->idcomprobante == 1){
            $cont = 0;
            
            $cabecera = array();
            $cabecera["operacion"] = "generar_comprobante";
            $cabecera["tipo_de_comprobante"] = "1";
            $cabecera["serie"] = $factura;

            $cabecera["numero"] = str_pad($cont++, 8, "0", STR_PAD_LEFT);
            $cabecera["sunat_transaction"] = 1;
            $cabecera["cliente_tipo_de_documento"] = '6';
            $cabecera["cliente_numero_de_documento"] = $request_user_cliente['identificacion'];
            $cabecera["cliente_denominacion"] = $request_user_cliente['nombres'];
            $cabecera["cliente_email"] = $request_user_cliente['email_user'];
            $cabecera["cliente_email_1"] = "";
            $cabecera["cliente_email_2"] = "";
            $cabecera["fecha_de_emision"] = date("d-m-Y");
            $cabecera["fecha_de_vencimiento"] = "";
            $cabecera["moneda"] = 1;
            $cabecera["tipo_de_cambio"] = "";
            $cabecera["porcentaje_de_igv"] = "10.00";
            $cabecera["descuento_global"] =  floatval(0.00);
            $cabecera["total_descuento"] =  floatval(0.00);
            $cabecera["total_anticipo"] = "";
            $cabecera["total_anticipo"] = "";

            $cabecera["total_gravada"] = number_format(floatval($request_venta['subtotal']), 3, ".", "");
            $cabecera["total_inafecta"] = "";
            $cabecera["total_exonerada"] = "";
            $cabecera["total_igv"] = number_format(floatval($request_venta['total_impuestos']), 3, ".", "");
            $cabecera["total_gratuita"] = "";
            $cabecera["total_otros_cargos"] = "";
            $cabecera["total"] = number_format(floatval($request_venta['total_venta']), 3, ".", "");
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
            if(empty($qrequest_sql_factural_boletas['id'])){
                $numero = 1;
            }else{
                $numero = $request_sql_factura['id'] + 1;
            }
        
            $items = array();
            $venta_detalle = "SELECT *  FROM detalle_venta WHERE ventaid='".$request_venta['idventa']."'";
            $request_venta_detalle = $this->listar($venta_detalle);
            foreach($request_venta_detalle as $value){
                $item = array();
                $product = "SELECT * FROM producto WHERE idProducto = '".$value['idarticulo']."'";
                $request_product = $this->buscar($product);
                $valor_sunat = $request_product['sunatid'];
                $separar = explode("_",$valor_sunat);
                $codigo = $separar[0];
    
                $neto = $value['precio_venta'] / 1.10;
                $igv = ($value['precio_venta'] - $neto) * $value['cantidad'];
    
                $item["unidad_de_medida"] = $request_product['unidadMedida'];
                $item["codigo"] = $value['idarticulo'];
                $item["descripcion"] = $request_product['nombre'];
                $item["cantidad"] = $value['cantidad'];
                $item["codigo_producto_sunat"] = "10000000";
                $item["valor_unitario"] = number_format(floatval($neto), 3, ".", "");
                $item["precio_unitario"] = number_format(floatval($value['precio_venta']), 3, ".", "");
                $item["descuento"] = '';
                $item["subtotal"] =  number_format(floatval(($value['precio_venta'] / 1.10) * $value['cantidad']), 3, ".", "");
                $item["tipo_de_igv"] = 1;
                $item["igv"] = number_format($igv, 3, ".", "");
                $item["total"] = number_format(floatval($value['precio_venta'] * $value['cantidad']), 3, ".", "");
                $item["anticipo_regularizacion"] = false;
                $item["anticipo_documento_serie"] = '';
    
                $items[] = $item;

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
                            $arrFactura = array($numero,$request_venta['idventa'],'',$factura,1);
                            $insert_factura = $this->insertar($venta_factura,$arrFactura);
    
                            $array_respuesta["exito"] = 1;
                            $array_respuesta["mensaje"] = "Se realizo el pago correctamente.";                        
                            return $array_respuesta;
                        }else{
                            if (!is_null($leer_respuesta)){
                                
                                $qr = "Insert into comprobante_hash values(?,?,?,?,?)";
                                $arrData = array(str_pad($cont++, 8, "0", STR_PAD_LEFT),$aceptada,$leer_respuesta["codigo_hash"],$leer_respuesta["cadena_para_codigo_qr"],$leer_respuesta['sunat_description']);
                                $insert_comprobante_hash = $this->insertar($qr,$arrData);
    
                                $venta_factura = "INSERT INTO factura(id,id_venta,token,serie,estado_fila) VALUES (?,?,?,?,?)";
                                $arrFactura = array($numero,$request_venta['idventa'],'',$factura,1);
                                $insert_factura = $this->insertar($venta_factura,$arrFactura);
    
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
        
            }
            // var_dump($respuesta);
            // exit;
            return $respuesta and $insert_comprobante_hash and $insert_factura; 
        }

        return $sw and $mp and $request_caja and $request_insert and $request_inset_cliente;

    }

    public function idDescSale(){
        $venta_print = "SELECT * FROM venta order by idventa desc limit 1";
        $request_venta_print = $this->buscar($venta_print);
        $num_print = $request_venta_print['idventa'];
        return $num_print;
    }

    public function isDesConsumo(){
        $consumo_print = "SELECT * FROM consumos order by idconsumo desc limit 1";
        $request_consumo_print = $this->buscar($consumo_print);
        $num_print = $request_consumo_print['idconsumo'];
        return $num_print;
    }


    public function selectVentaId(int $idventa){
        $this->idVenta = $idventa;
        $sql = "SELECT v.idventa, v.clienteid, v.usuario, v.tipo_comprobante, v.total_venta, d.idarticulo, d.cantidad, d.precio_venta, v.medio_pago_id, v.total_impuestos, v.subtotal FROM detalle_venta d INNER JOIN venta v ON d.ventaid = v.idventa WHERE v.idventa = $this->idVenta";
        $request_sql = $this->buscar($sql);
        return $request_sql;
    }

    public function roomsReservation(){
        $sql = "SELECT r.id_reservacion, u.nombres, r.reservacion_estado_id, h.nombre_habitacion FROM reservaciones r LEFT JOIN usuario u ON r.cliente=u.idusuario LEFT JOIN habitacion h ON r.habitacion_id=h.nombre_habitacion WHERE r.reservacion_estado_id = 2";
        $request = $this->listar($sql);
        return $request;
    }


    public function deleteVenta(int $idventa)
    {
        $this->idVenta = $idventa;
        $sql = "SELECT * FROM venta WHERE idventa = $this->idVenta";
        $request_sql = $this->listar($sql);

        $cantidad_medio = "SELECT id FROM venta_medio_pago WHERE id_venta = $this->idVenta";
        $req_cant = $this->listar($cantidad_medio);

        $medio_pago = "SELECT * FROM venta_medio_pago WHERE id_venta = $this->idVenta";
        $request_medio_pago = $this->listar($medio_pago);

        $sql_anulacion = "UPDATE venta SET venta_estado_id = ? WHERE idventa = $this->idVenta";
        $arrData = array(3);
        $request = $this->actualizar($sql_anulacion,$arrData);

        $sqlmovimiento = "SELECT id_tipomovimientocaja FROM tipo_movimiento_caja WHERE id_tipomovimientocaja = 9";
        $tipo = $this->listar($sqlmovimiento);

        $num_medio = 0;

        while ($num_medio < count($req_cant)) {

            $sql_turno = "SELECT idturno FROM turnos WHERE inicio_turno <= '".date("H:i:s")."' AND fin_turno >= '".date("H:i:s")."'";
            $request_turno = $this->buscar($sql_turno);

            $sql_detalle = "SELECT * FROM detalle_venta d WHERE d.ventaid = $idventa";
            $detalle_venta = $this->listar($sql_detalle);
            
            if($tipo[0]['id_tipomovimientocaja'] === "9"){
                $request_sql[0]['total_venta'] = $request_sql[0]['total_venta']*-1;
            }

            // var_dump($request_medio_pago[$num_medio]['mediopago']);
            $insert = "INSERT INTO movimiento_caja(monedaid,tipomovimientocaja_id,cajaid,turnoid,mediopagoid,usuarioid,monto,descripcion,estado) VALUES (?,?,?,?,?,?,?,?,?)";
            $arrData = array(1,$tipo[0]['id_tipomovimientocaja'],1,1,$request_medio_pago[$num_medio]['mediopago'],$_SESSION['userData']['idusuario'],$request_medio_pago[$num_medio]['monto'],'Anulacion de venta',2);
            $request_insert = $this->insertar($insert,$arrData);
    
            $insert_kardex_producto = "INSERT INTO movimiento_producto(productoid,cantidad,tipo_movimiento,almacenid,movimientoid) 
            VALUES (?,?,?,?,?) ";
            $arrData_kardex = array($detalle_venta[$num_medio]['idarticulo'],$detalle_venta[$num_medio]['cantidad'],1,1,1);
    
            $request_kardex_prod = $this->insertar($insert_kardex_producto,$arrData_kardex);

            $num_medio = $num_medio + 1;

            // var_dump($num_medio);

        }
        return $request AND  $request_insert AND $request_kardex_prod;
       
    }

    public function updateSale(int $idventa,int $medio_pago){
        $this->idVenta = $idventa;

        $this->medioPago = $medio_pago;
       

        $sql = "UPDATE venta SET medio_pago_id = ? WHERE idventa = $this->idVenta";
        $arrData = array($this->medioPago);
        $request = $this->actualizar($sql, $arrData);
        return $request;
    }


    public function selectVentas(){
        $sql = "SELECT v.idventa, u.nombres,  date_format(v.created_at,'%d %M %Y') as fecha, v.tipo_comprobante,  t.descripcion, v.total_venta, e.nombre FROM `venta` v INNER JOIN ventas_estado e ON v.venta_estado_id = e.id_venta_estado INNER JOIN tipo_comprobante_sunat t ON v.tipo_comprobante = t.id_tipo_comprobante INNER JOIN usuario u ON v.clienteid=u.idusuario WHERE v.venta_estado_id != 3";
        $request_sql = $this->listar($sql);
        return $request_sql;
    }

    // public function selectVentas(){
    //     $sql = "SELECT v.idventa, u.nombres, date_format(v.created_at,'%d %M %Y') as fecha, t.descripcion, m.nombre as mediopago, v.total_venta, e.nombre FROM `venta` v INNER JOIN ventas_estado e ON v.`venta_estado_id` = e.id_venta_estado
    //     INNER JOIN tipo_comprobante_sunat t ON v.tipo_comprobante = t.id_tipo_comprobante
    //     INNER JOIN medio_pago m ON v.medio_pago_id=m.idmediopago 
    //     INNER JOIN usuario u ON v.clienteid=u.idusuario
    //     WHERE v.venta_estado_id != 3";
    //     $request_sql = $this->listar($sql);
    //     return $request_sql;
    // }
    
    public function servicesList(){
        $sql = "SELECT * FROM servicio WHERE estado !=0";
        $request = $this->listar($sql);
        return $request;
    }


    public function selectTipoComprobante(){
        $sql = "SELECT * FROM tipo_comprobante_sunat ";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectClientes(){
        $sql = "SELECT * FROM usuario WHERE estado != 0  and rolid = 7";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectProductosVenta(){
        $sql =  "SELECT d.idmovimiento_producto,d.productoid, p.nombre, c.descripcion, p.precio_venta, a.nombre_almacen,sum(d.cantidad) as stock, (d.cantidad*p.precio_venta) as subtotal FROM movimiento_producto d INNER JOIN producto p on d.productoid = p.idProducto INNER JOIN almacen a ON d.almacenid = a.idalmacen INNER JOIN categoria_producto c ON p.categoriaid = c.idcategoria GROUP BY p.nombre";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectProductoVentaID(int $productoid){
         $this->idProducto = $productoid;
         $sql =  "SELECT d.idmovimiento_producto,d.productoid, p.nombre, c.descripcion, p.precio_venta, a.nombre_almacen,sum(d.cantidad) as stock FROM movimiento_producto d INNER JOIN producto p on d.productoid = p.idProducto INNER JOIN almacen a ON d.almacenid = a.idalmacen INNER JOIN categoria_producto c ON p.categoriaid = c.idcategoria WHERE d.productoid = $this->idProducto GROUP BY p.nombre";
         $request = $this->listar($sql);
         return $request;
    }

    public function restablecerBoletaFactura(){

        $consultarUsuario = "SELECT * FROM usuario order by idusuario desc limit 1";
        $requestConsultarUsuario = $this->buscar($consultarUsuario);

        $idUsuario = $requestConsultarUsuario['idusuario'];

        $consultarVenta = "SELECT * FROM venta order by idventa desc limit 1";
        $requestConsultarVenta = $this->buscar($consultarVenta);

        $idVenta = $requestConsultarVenta['idventa'];

        $consultarDetalleVenta = "SELECT * FROM detalle_venta WHERE ventaid = $idVenta";
        $requestConsultarDetalleVenta = $this->buscar($consultarDetalleVenta);

        $fecha_hora = $requestConsultarDetalleVenta['created_at'];

        $eliminarUsuario = "DELETE FROM usuario WHERE idusuario = $idUsuario";
        $requestEliminarUsuario = $this->eliminar($eliminarUsuario);

        $eliminarVenta = "DELETE FROM venta WHERE idventa = $idVenta";
        $requestEliminarVenta = $this->eliminar($eliminarVenta);

        $eliminarDetalleVenta = "DELETE FROM detalle_venta WHERE created_at = '".$fecha_hora."'";
        $requestEliminarDetalleVenta = $this->eliminar($eliminarDetalleVenta);

        $eliminarMovimientoProducto = "DELETE FROM movimiento_producto WHERE fecha = '".$fecha_hora."'";
        $requestEliminarMovimientoProducto = $this->eliminar($eliminarMovimientoProducto);

        $eliminarMovimientoCaja = "DELETE FROM movimiento_caja WHERE created_at = '".$fecha_hora."'";
        $requestEliminarMovimientoCaja = $this->eliminar($eliminarMovimientoCaja);
        
        $eliminarVentaMedioPago = "DELETE FROM venta_medio_pago WHERE created_at = '".$fecha_hora."'";
        $requestEliminarVentaMedioPago = $this->eliminar($eliminarVentaMedioPago);

        return $requestEliminarUsuario AND $requestEliminarVenta AND $requestEliminarDetalleVenta AND $requestEliminarMovimientoProducto AND $requestEliminarMovimientoCaja AND $requestEliminarVentaMedioPago;

    }


 }
