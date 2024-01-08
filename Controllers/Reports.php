<?php
 use PHPMailer\PHPMailer\PHPMailer;
 require_once("Libraries/Core/Mysql.php");
 
 
 require("PHPMailer/src/PHPMailer.php");
 require("PHPMailer/src/Exception.php");
 require("PHPMailer/src/SMTP.php");
 
 class Reports extends Controllers {
     public function __construct(){
         session_start();
         if(empty($_SESSION['login'])){
             header("Location: ".base_url().'/login');
         }
         parent::__construct();
     }

     public function canceledsales(){
        $data['page_tag'] = "Ventas anuladas - Usqay Hoteles";
        $data['page_title'] = "Ventas anuladas - Usqay Hoteles";
        $data['page_frontend'] = "Ventas anuladas";
        $data['page_functions_js'] = "functions_reportcanceledsales.js";
        $this->views->getView($this,"canceledsales",$data);
    }

    public function cortesias(){
        $data['page_tag'] = "Reporte de cortesias - Usqay Hoteles";
        $data['page_title'] = "Reporte de cortesias - Usqay Hoteles";
        $data['page_frontend'] = "Reporte de cortesias";
        $data['page_functions_js'] = "functions_reportcortesias.js";
        $this->views->getView($this,"cortesias",$data);
    }

     public function boletasales(){
        $data['page_tag'] = "Reporte de boletas - Usqay Hoteles";
        $data['page_title'] = "Reporte de boletas - Usqay Hoteles";
        $data['page_frontend'] = "Reporte de boletas";
        $data['page_functions_js'] = "functions_reporttickets.js";
        $this->views->getView($this,"boletasales",$data);
    }

    public function boletares(){
        $data['page_tag'] = "Reporte de boletas - Usqay Hoteles";
        $data['page_title'] = "Reporte de boletas - Usqay Hoteles";
        $data['page_frontend'] = "Reporte de boletas";
        $data['page_functions_js'] = "functions_reporttickets.js";
        $this->views->getView($this,"boletares",$data);
    }

     public function facturasales(){
         $data['page_tag'] = "Reporte de facturas - Usqay Hoteles";
         $data['page_title'] = "Reporte de facturas - Usqay Hoteles";
         $data['page_frontend'] = "Reporte de facturas";
         $data['page_functions_js'] = "functions_reportbills.js";
         $this->views->getView($this,"facturasales",$data);
     }

     public function facturares(){
        $data['page_tag'] = "Reporte de facturas - Usqay Hoteles";
        $data['page_title'] = "Reporte de facturas - Usqay Hoteles";
        $data['page_frontend'] = "Reporte de facturas";
        $data['page_functions_js'] = "functions_reportbills.js";
        $this->views->getView($this,"facturares",$data);
    }

    public function consumos(){
        $data['page_tag'] = "Reporte de consumos - Usqay Hoteles";
        $data['page_title'] = "Reporte de consumos - Usqay Hoteles";
        $data['page_frontend'] = "Reporte de consumos";
        $data['page_functions_js'] = "functions_reportconsumos.js";
        $this->views->getView($this,"consumos",$data);
    }

    public function detallesconsumos(){
        $data['page_tag'] = "Detalle de consumos - Usqay Hoteles";
        $data['page_title'] = "Detalle de consumos - Usqay Hoteles";
        $data['page_frontend'] = "Detalle de consumos";
        $data['page_functions_js'] = "functions_reportconsumos.js";
        $this->views->getView($this,"detalleconsumos",$data);
    }
    
    public function getReservaciones(){
        $arrData = $this->model->selectReservaciones();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

     public function dayli(){
         $data['page_tag'] = "Cuadre diario - Usqay Hoteles";
         $data['page_title'] = "Cuadre diario - Usqay Hoteles";
         $data['page_frontend'] = "Cuadre diario";
         $data['page_functions_js'] = "functions_reportdayli.js";

          
         $data['medio_efectivo'] = $this->model->medioPagoEfectivo();
         $data['monto_inicial'] = $this->model->montoInicialDay();
         $data['medio_yape'] = $this->model->medioPagoYape();
         $data['medio_visa'] = $this->model->medioPagoVisa();
         $data['medio_plin'] = $this->model->medioPagoPlin();
         $data['total_egresos'] = $this->model->totalEgresos();
         $data['total_ingresos'] = $this->model->tipoIngreso();
         
         $data['mount_day_cash'] = $this->model->mountDayCash();
         $this->views->getView($this,"dayli",$data);
     }


     public function calendar(){
        $data['page_tag'] = "Calendario de reservaciones - Usqay Hoteles";
        $data['page_title'] = "Calendario de reservaciones - Usqay Hoteles";
        $data['page_frontend'] = "Calendario de reservaciones";
        $data['page_functions_js'] = "functions_reportreservaciones.js";

        $this->views->getView($this,"calendar",$data);
     }


     public function email(){
        $con = new Mysql();
        $fechaInicio = date('Y-m-d');


        if(isset($_GET['fecha'])){
            $fechaInicio = $_GET['fecha'];
            
        }

        $conf = "SELECT * FROM configuracion WHERE id = 1";
        $request_confg = $con->buscar($conf);
        $fecha_cierre = $request_confg["fecha_cierre"];
        $hoy = $request_confg["fecha_cierre"];
        $correo = $request_confg["correoElectronico"];
    
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
        
        $total_ventas = "SELECT SUM(total_venta) as total FROM venta WHERE venta_estado_id = 2 AND created_at = '".$request_confg["fecha_cierre"]."'";
        $request_ventas = $con->buscar($total_ventas);
        $total_ventas_day = $request_ventas['total'];
        
        $openMoney = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 1 and estado = 1 and fecha = '".$fechaInicio."'" ;
        $request_open = $con->buscar($openMoney);
        $montoOpen = $request_open["total"];
    
    
    
    
        $total_pago_reservacion = "SELECT SUM(monto) as reservacion FROM movimiento_caja WHERE tipomovimientocaja_id = 2 and estado = 1 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_reservacion = $con->buscar($total_pago_reservacion);
        $reservacion_pagos = $request_reservacion['reservacion'];
        
        
        
        $total_efectivo = "SELECT SUM(monto) as efectivo FROM movimiento_caja WHERE tipomovimientocaja_id != 1 and mediopagoid = 1 and estado = 1 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_efectivo = $con->buscar($total_efectivo);
        $total_efectivo_day = $request_efectivo['efectivo'];
        
        $efectivo_egresos = "SELECT SUM(monto) as egresos_efectivo FROM movimiento_caja WHERE mediopagoid = 1 and estado = 2 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_egresos_efectivo = $con->buscar($efectivo_egresos);
        $total_egresos_efectivo = $request_egresos_efectivo['egresos_efectivo'];
        
        $egresos_visa = "SELECT SUM(monto) as egresos_visa FROM movimiento_caja WHERE mediopagoid = 2 and estado = 2 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_egresos_visa = $con->buscar($egresos_visa);
        $total_egresos_visa = $request_egresos_visa['egresos_visa'];
        
        $egresos_yape = "SELECT SUM(monto) as egresos_yape FROM movimiento_caja WHERE mediopagoid = 5 and estado = 2 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_egresos_yape= $con->buscar($egresos_yape);
        $total_egresos_yape = $request_egresos_yape['egresos_yape'];
        
        $egresos_plin = "SELECT SUM(monto) as egresos_plin FROM movimiento_caja WHERE mediopagoid = 6 and estado = 2 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_egresos_plin = $con->buscar($egresos_plin);
        $total_egresos_plin= $request_egresos_plin['egresos_plin'];
        
        $total_visa = "SELECT SUM(monto) as visa FROM movimiento_caja WHERE mediopagoid = 2 and estado = 1 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_visa = $con->buscar($total_visa);
        $visa = $request_visa['visa'];
        
        $total_yape = "SELECT SUM(monto) as yape FROM movimiento_caja WHERE mediopagoid = 5 and estado = 1 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_yape = $con->buscar($total_yape);
        $yape = $request_yape['yape'];
        
        $total_plin = "SELECT SUM(monto) as plin FROM movimiento_caja WHERE mediopagoid = 6 and estado = 1 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_plin = $con->buscar($total_plin);
        $plin = $request_plin['plin'];
        
        $total_mastercard = "SELECT SUM(monto) as mastercard FROM movimiento_caja WHERE mediopagoid = 3 and estado = 1 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_mastercard = $con->buscar($total_mastercard);
        $mastercard = $request_mastercard['mastercard'];
        
        $total_otro_tipo_ingreso = "SELECT SUM(monto) as ingresos FROM movimiento_caja WHERE tipomovimientocaja_id = 11 and estado = 1 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_ingresos = $con->buscar($total_otro_tipo_ingreso);
        $total_ingresos_day = $request_ingresos['ingresos'];
        
        
        $total_egresos = "SELECT SUM(monto) as egresos FROM movimiento_caja WHERE tipomovimientocaja_id = 12 and estado = 2 and fecha = '".$request_confg["fecha_cierre"]."'";
        $request_egresos = $con->buscar($total_egresos);
        $total_egresos = $request_egresos['egresos'];
        
        //   $total_cash_reservaciones = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 2";
        //   $request_ventas = $con->buscar($total_cash_reservaciones);
        //   $total_ventas_day = $request_ventas['total'];
    
        $total_caja_day = $total_ventas_day + $visa +  $plin + $montoOpen + $yape  + $total_efectivo_day;
        $total_ingresos = $visa + $plin + $yape + $total_ingresos_day;
        $utilidadCaja = $total_caja_day - abs($total_egresos) - abs($montoOpen);

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
        $mail->Subject = "Reporte de cierre de caja";
        $message = "<body>Reporte del 05-07-2022 
         <h4><strong>".$request_confg['nombre_negocio']."</strong></h4>
         <p>".$request_confg['direccion']."
         <br>
         </p>
         <hr>
         <p>Cajero: ".$_SESSION['userData']['nombres']."<br>
            Caja: Principal <br>
            Fecha $fecha_cierre
         </p> 
         <hr>
         <p>CIERRE DE CAJA</p>
         <hr>
         <p><b>TOTALES</b></p>
         <p>
            EFECTIVO: ".formatMoney(abs($total_efectivo_day))." <br>
            TRANSFERENCIA: ".formatMoney(abs($visa))."
            TARJETA DE DEBITO: ".formatMoney(abs($yape))."
            TARJETA DE CREDITO: ".formatMoney(abs($plin))."
         </p>
         <hr>
         <p>INGRESO VENTAS</p>
         <p>RESUMEN DE VENTAS: ".formatMoney(abs($total_ventas_day))."</p>
         <hr>
         <p>INGRESO RESERVACIONES</p>
         <p>RESUMEN: ".formatMoney(abs($reservacion_pagos))." </p>
         <hr>
         <p>INGRESOS ADICIONALES</p>
         <p>
         <p>RESUMEN DE INGRESOS: ".formatMoney(abs($total_ingresos_day))."</p>
         </p>
         <hr>
         <p>EGRESOS</p>
         <p>
         <p>RESUMEN DE EGRESOS: ".formatMoney(abs($total_egresos))."</p>
         </p>
         <hr>
         <p>MONTO INICIAL</p>
         <p>SOL PERUANO: S/ ".formatMoney($montoOpen)."</p>
         <hr>
         <p>RESUMEN DE CAJA</p>
         <p>UTILIDAD EN CAJA: ".formatMoney($utilidadCaja)." <br>
         TOTAL EN CAJA: ".formatMoney($total_caja_day)."
         </p>
        
        
        </body>";
        $mail->Body = $message;
        $mail->AltBody = $message;

        if($mail->Send()){
            echo "Mensaje enviado";
        }else{
        echo "Error";
        }

     }

     public function sales(){
        $data['page_tag'] = "Reporte de ventas - Usqay Hoteles";
        $data['page_title'] = "Reporte de ventas- Usqay Hoteles";
        $data['page_frontend'] = "Reporte de ventas";
        $data['page_functions_js'] = "functions_reportsale.js";
        
        $anio = date('Y');
        $mes  = date('m');

        $data['pagosMedioPago'] = $this->model->selectMedioPago($anio,$mes);

        $data['productosMasVendidos'] = $this->model->selectTopProductos($anio,$mes);

        $data['ventasMDia'] = $this->model->selectVentasMes($anio,$mes);
        $this->views->getView($this,"sales",$data);
     }

     public function rooms(){
        $data['page_tag'] = "Reporte de habitaciones - Usqay Hoteles";
        $data['page_title'] = "Reporte de habitaciones- Usqay Hoteles";
        $data['page_frontend'] = "Reporte de habitaciones";
        $data['page_functions_js'] = "functions_reportrooms.js";

        $data['disponible'] = $this->model->roomsDisponibles();
        $data['ocupadas'] = $this->model->roomsOcupadas();
        $data['mantenimiento'] = $this->model->roomsMantenimiento();
        
        $anio = date('Y');
        $mes = date('m');
        $dia = date('d');


        $data['reservasMDia'] = $this->model->selectReservasMes($anio,$mes);

        $this->views->getView($this,"rooms",$data);

     }
     
     public function getRooms(){
        $arrData = $this->model->selecthabitacion();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

     public function getCortes(){
      
        $db = new Mysql();
        $array = array();
        $query = "SELECT * FROM corte c WHERE c.fecha_cierre = '2022-09-18'  order by c.id DESC";
        $res = $db->buscar($query);
              echo $res;
        while ($row0 = $db->buscar($res)) {
            $array[] = $row0["inicio"];
        }
        echo json_encode($array);
    }

     
		public function tipoPagoMes()
		{
			if($_POST)
			{
				$grafica = "tipoPagoMes";
				$nFecha = str_replace(" ","",$_POST['fecha']);
				$arrFecha = explode('-',$nFecha);
				$mes = $arrFecha[0];
				$anio = $arrFecha[1];
				$pagos = $this->model->selectMedioPago($anio,$mes);
				$script = getFile("Template/Modals/grafica",$pagos);
				echo $script;
				die();
			}
		}

        public function topProductos()
		{
			if($_POST)
			{
				$grafica = "topProductos";
				$nFecha = str_replace(" ","",$_POST['fecha']);
				$arrFecha = explode('-',$nFecha);
				$mes = $arrFecha[0];
				$anio = $arrFecha[1];
				$productos = $this->model->selectTopProductos($anio,$mes);
				$script = getFile("Template/Modals/grafica",$productos);
				echo $script;
				die();
			}
		}

 }


?>