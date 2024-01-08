<?php 
 use PHPMailer\PHPMailer\PHPMailer;
 require("PHPMailer/src/PHPMailer.php");
 require("PHPMailer/src/Exception.php");
 require("PHPMailer/src/SMTP.php");

 class OpenBoxModel extends Mysql{
    public $IdAperturaCaja;
    public $CajaId;
    public $TurnoId;
    public $MontoInicial;
    public $fecha_actual;
    public $fecha;
    

    public function __construct(){
        parent::__construct();
    }

    public function enviarCorteCorreoCierre($fecha,$corte_inicio,$caja){
        $se_envia = 1;
        $corte = array();
        $query = "Select * from corte c INNER JOIN accion_caja ac ON c.id=ac.pk_accion where c.inicio = '".$corte_inicio."' AND ac.caja = $caja";
        $res = $this->listar($query);

        // var_dump($query);exit;

        $tiempo_inicio = null;
        $tiempo_fin = null;

        $id_corte = null;

        $consulta_corte = "";
        foreach($res as $r){
           if($row0 = $r){
              $id_corte = $row0['id'];
              if($row0['fin'] == ""){
               $tiempo_inicio = $row0['inicio'];
              }else{
               $tiempo_inicio = $row0['inicio'];
               $tiempo_fin = $row0['fin'];
              }
           }
        }

        $medios = array();
        $medios_pago = "SELECT * FROM medio_pago";
        $resultado_medios_pagos = $this->listar($medios_pago);
        foreach($resultado_medios_pagos as $mp){
           $tmp = array();
           $tmp["nombre"] = $mp["nombre"];
           $tmp["idmediopago"] = $mp["idmediopago"];
           $medios[] = $tmp;
        }

        $consulta_vendido = "";
        $vendido_reservas = "";
        $monto_inicial = "";
        $ingresos = "";
        $egresos = "";
        $ventas_anuladas = "";

        if($tiempo_fin <> null){
           $consulta_vendido = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.estado = 1 AND mc.tipomovimientocaja_id = 3  AND mc.created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."'";

           $ventas_anuladas = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.estado = 2 AND mc.tipomovimientocaja_id = 10  AND mc.created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."'";


           $vendido_reservas = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 2  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 1";

           $monto_inicial = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 1  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 1";

           $ingresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 11  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 1";

           $egresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 12  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 2";

        }else{
           $consulta_vendido = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.tipomovimientocaja_id = 3 AND mc.cajaid = '".$caja."' AND mc.created_at >= '".$tiempo_inicio."'";

           $ventas_anuladas = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.tipomovimientocaja_id = 10 AND mc.cajaid = '".$caja."' AND mc.created_at >= '".$tiempo_inicio."'";


           $vendido_reservas = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 2 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 1";
           $monto_inicial = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 1 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 1";

           $ingresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 11 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 1";

           $egresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 12 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 2";
        }

        $request_ventas_anuladas = $this->buscar($ventas_anuladas);
        $anulaciones_totales_ventas = floatval($request_ventas_anuladas['resultado']);
    
        $request_ingresos = $this->buscar($ingresos);
        $corte['ingresos_total_monto'] = floatval($request_ingresos['resultado']);

        $request_egresos = $this->buscar($egresos);
        $corte['egresos_total_monto'] = floatval($request_egresos['resultado']);

        $result_reservas = $this->buscar($vendido_reservas);
        $corte['reservas'] = floatval($result_reservas['resultado']);
        
        $result_montoinicial = $this->buscar($monto_inicial);
        $corte['montoinicial'] = floatval($result_montoinicial['resultado']);

        // var_dump($monto_inicial);exit;

        $result_vendido = $this->buscar($consulta_vendido);
        $corte['vendido'] = floatval($result_vendido['resultado']) - abs($anulaciones_totales_ventas);

        $total_caja = ($corte['reservas'] + $corte['montoinicial'] + $corte['vendido'] + $corte['ingresos_total_monto'])- abs($corte['egresos_total_monto']);
        $corte['totalcaja'] = $total_caja;

        $utilidad = ($corte['reservas'] + $corte['vendido'] + $corte['ingresos_total_monto'])- abs($corte['egresos_total_monto']);
        $utilidad_caja = $utilidad;
        $corte['utilidadcaja'] = $utilidad_caja;
       
        if($tiempo_fin <> null){
               
           foreach($medios as $med){
               $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 11 AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND cajaid = '".$caja."' AND estado = 1";          
               $result_tmp = $this->buscar($query_tmp);
               if ($row0 = $result_tmp) {
                   $corte["ven_".$med["idmediopago"]] = floatval($row0["resultado"]);
               }
           }

           foreach($medios as $med){
               $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 12 AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND cajaid = '".$caja."' AND estado = 2";          
               $result_tmp = $this->buscar($query_tmp);
               if ($row0 = $result_tmp) {
                   $corte["egre_".$med["idmediopago"]] = floatval($row0["resultado"]);
               }
           }
        }else{
           foreach($medios as $med){
               $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 11 AND  created_at >= '".$tiempo_inicio."'  AND cajaid = '".$caja."' AND estado = 1";          
               $result_tmp = $this->buscar($query_tmp);
               if ($row0 = $result_tmp) {
                   $corte["ven_".$med["idmediopago"]] = floatval($row0["resultado"]);
               }
           }
           foreach($medios as $med){
               $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 12 AND  created_at >= '".$tiempo_inicio."'  AND cajaid = '".$caja."' AND estado = 2";          
               $result_tmp = $this->buscar($query_tmp);
              
               if ($row0 = $result_tmp) {
                   $corte["egre_".$med["idmediopago"]] = floatval($row0["resultado"]);
               }
           }
        }

        $medios = array();
        $medios_pago = "Select mp.idmediopago, mp.nombre from medio_pago mp";
        $resultado_medios = $this->listar($medios_pago);
        if (is_array($resultado_medios)) {
            foreach ($resultado_medios as $medio) {
                $tmp = array();
                $tmp["nombre"] = $medio["nombre"];
                $tmp["id_medio"] = $medio["idmediopago"];
                $medios[] = $tmp;
                
            }
        }

        $sql_config = "SELECT * FROM configuracion WHERE id = 1";
        $request_sql_config = $this->buscar($sql_config);
        $correo = $request_sql_config['correoElectronico'];

         $fecha = date("d-m-Y");
         $hora = date('H:i:s');
 
         $mail = new PHPMailer(true);
         $mail->IsSMTP();
 
         $mail->Authentication = false;
         $mail->From = "report@sistemausqay.com";
         $mail->SMTPAuth = true;
         $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;
         $mail->Host = "smtp.gmail.com";
         $mail->Port = 587;
         $mail->Username = "reportes@usqay-cloud.com";
         $mail->Password = "xclvidizybcaywvw";
         $mail->AddAddress("'".$correo."'");
         $mail->Subject = "Corte de caja";
         $mail->Body .="<h1 style='color:#3498db;'>Corte de Caja</h1>";
         $mail->Body .= "<p><b>Fecha y Hora:</b> ".date("d-m-Y h:i:s A")."</p>";
         $mail->Body .= "<p><b>Cajero :</b>".$_SESSION['userData']['nombres']."</p>";
         $mail->Body .= "<p><b>Caja: </b> Principal</p>";
         $mail->Body .= "<p><b>Corte: </b>".$corte_inicio."</p>";
         $mail->Body .= "<hr/>";

         $mail->Body .= "<p><b>MONTO INICIAL</b></p>";
         // foreach($medios as $med){
             $mail->Body .= "<p><b>Soles S/. </b> ".number_format($corte['montoinicial'],2)."</p>";
         // }
         $mail->Body .= "<hr/>";
         $mail->Body .= "<p><b>RESUMEN DE VENTAS </b></p>";
         $mail->Body .= "<p><b> TOTAL: S/. </b>".number_format($corte['vendido'],2)."</p>";
         $mail->Body .= "<hr/>";

         $mail->Body .= "<p><b>RESUMEN DE RESERVAS </b></p>";
         $mail->Body .= "<p><b> TOTAL: S/. </b>".number_format($corte['reservas'],2)."</p>";
         $mail->Body .= "<hr/>";
         $mail->Body .= "<p><b>RESUMEN INGRESO DE DINERO </b></p>";
         $mail->Body .= "<p><b> TOTAL: S/. </b>".number_format($corte['ingresos_total_monto'],2)."</p>";
         $mail->Body .= "<hr/>";


         $mail->Body .= "<p><b>RESUMEN SALIDAS DE DINERO </b></p>";
         $mail->Body .= "<p><b> TOTAL:  S/. </b>".number_format($corte['egresos_total_monto'],2)."</p>";
         
         $mail->Body .= "<hr/>";
         $mail->Body .= "<p><b>TOTAL EN CAJA</b></p>";
         $mail->Body .= "<p><b> S/. </b>".number_format($corte['totalcaja'],2)."</p>";

         $mail->Body .= "<hr/>";
         $mail->Body .= "<p><b>UTILIDAD EN CAJA</b></p>";
         $mail->Body .= "<p><b> S/. </b>".number_format($corte['utilidadcaja'],2)."</p>";




        $mail->Body .= "<hr/>";
       
         $mail->IsHTML(true);

         if($se_envia === 1){
             $mail->Send();
         }
         
       
    }

    public function insertTurnOpening(int $cajas, float $monto_inicial){
        $this->CajaId = $cajas;
        $this->MontoInicial = $monto_inicial;

        $sql_turno = "SELECT idturno FROM turnos WHERE inicio_turno <= '".date("H:i:s")."' AND fin_turno >= '".date("H:i:s")."'";
        $request_turno = $this->listar($sql_turno);

        // var_dump($request_turno[0]["idturno"]);
        // exit;
        $queryCorte = "select * from corte where fin is null order by id desc";
        $resquerycorte = $this->buscar($queryCorte);
        if($row01 = $resquerycorte){
           $sqlup = "update corte set fin = ? where id = ".$row01['id']."";
           $arrData = array(date('Y-m-d H:i:s'));
           $rq_up = $this->actualizar($sqlup,$arrData);
        }


        $fecha_actual = date("Y-m-d");

        $sql_config  = "UPDATE configuracion SET fecha_cierre = ? where id= 1";
        $arrData1 = array($fecha_actual);
        $request_config = $this->actualizar($sql_config,$arrData1);

        $corte = date("Y-m-d H:i:s");

        $sql_corte = "INSERT INTO corte(fecha_cierre,inicio,fin,monto_inicial,estado_fila) VALUES(?,?,?,?,?)";
        $arrData = array($fecha_actual,$corte,NULL,$this->MontoInicial,1);
        $request_corte = $this->insertar($sql_corte,$arrData);

        $query_caja = "INSERT INTO accion_caja (pk_accion,tipo_accion,caja)VALUES(?,?,?)";
        $arrData = array($request_corte,'CUT',$cajas);
        $request_caja = $this->insertar($query_caja,$arrData);
        
        $insert = "INSERT INTO movimiento_caja(monedaid,tipomovimientocaja_id,cajaid,turnoid,mediopagoid,usuarioid,monto,descripcion) VALUES(?,?,?,?,?,?,?,?)";
        $arrData = array(1,1,$this->CajaId,1,1,$_SESSION['userData']['idusuario'],$this->MontoInicial,'Ingreso de monto inicial');
        $request_insert = $this->insertar($insert,$arrData);
       
        return $request_insert AND $request_config AND $request_corte;
        
    }

    public function selectCortesDay(){
        $date = date('Y-m-d');
        $sql  = "SELECT * FROM corte WHERE fecha_cierre = '" .$date."' ";
        $request_sql = $this->listar($sql);
        return $request_sql;
    }

    public function cortePutito(int $caja){

        // $query = "Select c.* from corte c, accion_caja ac where c.fin is null AND ac.pk_accion = c.id AND ac.tipo_accion = 'CUT' AND ac.caja = '".$caja."' order by c.id DESC LIMIT 1";

        $query = "Select * from corte order by id desc limit 1";

        $request_query = $this->buscar($query);
        $idCorte = $request_query['id'];

        // var_dump($idCorte);exit;

        if(!empty($idCorte)){
            $sqlUpdateCorte = "UPDATE corte SET fin = ? WHERE id = $idCorte";
            $arrData = array(date("Y-m-d H:i:s"));
            $request_update_corte = $this->actualizar($sqlUpdateCorte,$arrData);
        }

        $corte = date("Y-m-d H:i:s");
        $sql_config = "SELECT * FROM configuracion WHERE id = 1";
        $request_sql_config = $this->buscar($sql_config);
        $fecha_cierre = $request_sql_config['fecha_cierre'];

        $sql_corte = "INSERT INTO corte(fecha_cierre,inicio,fin,monto_inicial,estado_fila) VALUES(?,?,?,?,?)";
        $arrData = array($fecha_cierre,$corte,NULL,'0','1');
        $request_corte = $this->insertar($sql_corte,$arrData);

        $id = $request_corte;

        $query_caja = "INSERT INTO accion_caja (pk_accion,tipo_accion,caja)VALUES(?,?,?)";
        $arrData = array($id,'CUT',$caja);
        $request_caja = $this->insertar($query_caja,$arrData);

        $array = array();
        $array[] = array(
            "corte" => $corte
        );

        return $array;


    }


    public function totalDiaCorte($fecha,$corte_inicio,$caja){
         $corte = array();
         $query = "Select * from corte c INNER JOIN accion_caja ac ON c.id=ac.pk_accion where c.inicio = '".$corte_inicio."' AND ac.caja = $caja";
         $res = $this->listar($query);

         $tiempo_inicio = null;
         $tiempo_fin = null;
 
         $id_corte = null;

         $consulta_corte = "";
         foreach($res as $r){
            if($row0 = $r){
               $id_corte = $row0['id'];
               if($row0['fin'] == ""){
                $tiempo_inicio = $row0['inicio'];
               }else{
                $tiempo_inicio = $row0['inicio'];
                $tiempo_fin = $row0['fin'];
               }
            }
         }

         $medios = array();
         $medios_pago = "SELECT * FROM medio_pago";
         $resultado_medios_pagos = $this->listar($medios_pago);
         foreach($resultado_medios_pagos as $mp){
            $tmp = array();
            $tmp["nombre"] = $mp["nombre"];
            $tmp["idmediopago"] = $mp["idmediopago"];
            $medios[] = $tmp;
         }

         $consulta_vendido = "";
         $vendido_reservas = "";
         $monto_inicial = "";
         $ingresos = "";
         $egresos = "";
         $ventas_anuladas = "";

         if($tiempo_fin <> null){
            $consulta_vendido = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.estado = 1 AND mc.tipomovimientocaja_id = 3  AND mc.created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."'";

            $ventas_anuladas = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.estado = 2 AND mc.tipomovimientocaja_id = 10  AND mc.created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."'";

            $vendido_reservas = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 2  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 1";

            $monto_inicial = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 1  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 1";

            $ingresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 11  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 1";

            $egresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 12  AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND estado = 2";

         }else{
            $consulta_vendido = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.tipomovimientocaja_id = 3 AND mc.cajaid = '".$caja."' AND mc.created_at >= '".$tiempo_inicio."'";

            $ventas_anuladas = "SELECT SUM(mc.monto) as resultado FROM movimiento_caja mc WHERE  mc.tipomovimientocaja_id = 10 AND mc.cajaid = '".$caja."' AND mc.created_at >= '".$tiempo_inicio."'";


            $vendido_reservas = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 2 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 1";
            $monto_inicial = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 1 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 1";

            $ingresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 11 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 1";

            $egresos = "SELECT SUM(monto) as resultado FROM movimiento_caja WHERE tipomovimientocaja_id = 12 AND cajaid = '".$caja."' AND created_at >= '".$tiempo_inicio."' AND estado = 2";
         }

         $request_ventas_anuladas = $this->buscar($ventas_anuladas);
        //  var_dump($request_ventas_anuladas);exit;
         $anulaciones_totales_ventas = floatval($request_ventas_anuladas['resultado']);
        //  var_dump($anulaciones_totales_ventas);

     
         $request_ingresos = $this->buscar($ingresos);
         $corte['ingresos_total_monto'] = floatval($request_ingresos['resultado']);

         $request_egresos = $this->buscar($egresos);
         $corte['egresos_total_monto'] = floatval($request_egresos['resultado']);

         $result_reservas = $this->buscar($vendido_reservas);
         $corte['reservas'] = floatval($result_reservas['resultado']);
         
         $result_montoinicial = $this->buscar($monto_inicial);
         $corte['montoinicial'] = floatval($result_montoinicial['resultado']);

         $result_vendido = $this->buscar($consulta_vendido);
         $corte['vendido'] = floatval($result_vendido['resultado']) - abs($anulaciones_totales_ventas);

         $total_caja = ($corte['reservas'] + $corte['montoinicial'] + $corte['vendido'] + $corte['ingresos_total_monto'])- abs($corte['egresos_total_monto']);
         $corte['totalcaja'] = $total_caja;

         $utilidad = ($corte['reservas'] + $corte['vendido'] + $corte['ingresos_total_monto'])- abs($corte['egresos_total_monto']);
         $utilidad_caja = $utilidad;
         $corte['utilidadcaja'] = $utilidad_caja;
        
         if($tiempo_fin <> null){
                
            foreach($medios as $med){
                $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 11 AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND cajaid = '".$caja."' AND estado = 1";          
                $result_tmp = $this->buscar($query_tmp);
                if ($row0 = $result_tmp) {
                    $corte["ven_".$med["idmediopago"]] = floatval($row0["resultado"]);
                }
            }

            foreach($medios as $med){
                $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 12 AND created_at BETWEEN '".$tiempo_inicio."' AND '".$tiempo_fin."' AND cajaid = '".$caja."' AND estado = 2";          
                $result_tmp = $this->buscar($query_tmp);
                if ($row0 = $result_tmp) {
                    $corte["egre_".$med["idmediopago"]] = floatval($row0["resultado"]);
                }
            }
         }else{
            foreach($medios as $med){
                $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 11 AND  created_at >= '".$tiempo_inicio."'  AND cajaid = '".$caja."' AND estado = 1";          
                $result_tmp = $this->buscar($query_tmp);
                if ($row0 = $result_tmp) {
                    $corte["ven_".$med["idmediopago"]] = floatval($row0["resultado"]);
                }
            }
            foreach($medios as $med){
                $query_tmp = "select sum(monto) as resultado from movimiento_caja where mediopagoid = '".$med["idmediopago"]."' AND tipomovimientocaja_id = 12 AND  created_at >= '".$tiempo_inicio."'  AND cajaid = '".$caja."' AND estado = 2";          
                $result_tmp = $this->buscar($query_tmp);
               
                if ($row0 = $result_tmp) {
                    $corte["egre_".$med["idmediopago"]] = floatval($row0["resultado"]);
                }
            }
         }

      
        
         return $corte;
        
    }
 }

?>