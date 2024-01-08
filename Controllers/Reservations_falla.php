<?php

 class Reservations extends Controllers{


     public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
         }
         parent::__construct();
     }

     public function reservations(){
        $data['page-frontend']="Reservaciones";
        $data['page_tag']="Reservaciones - Usqay  Hoteles";
        $data['page_title'] = "Reservaciones - Usqay Hoteles";
        $data['page_functions_js'] = "functions_crear_reservaciones.js";
        $this->views->getView($this,"reservations",$data);
     }

     public function show(){
        $data['page-frontend']="Reservacion";
        $data['page_tag']="Reservacion - Usqay  Hoteles";
        $data['page_title'] = "Reservacion - Usqay Hoteles";
        $data['page_functions_js'] = "functions_crear_reservaciones.js";
        $this->views->getView($this,"show",$data);
     }


     public function create(){
        $data['page-frontend']="Crear Reservaciones";
        $data['page_tag']="Crear Reservaciones - Usqay  Hoteles";
        $data['page_title'] = "Crear Reservaciones - Usqay Hoteles";
        $data['page_functions_js'] = "functions_crear_reservaciones.js";
        $data['rooms'] = $this->model->roomsReservation();
        $this->views->getView($this,"create",$data);
     }


     public function getRoomsReservationArturo(){
        $arrData = $this->model->roomsReservation();
        for($i=0; $i < count($arrData); $i++){
            $btnSelect = '';
            if($arrData[$i]['estado_habitacion'] == 'Disponible'){
                $btnSelect .= '<a style="background:transparent; width:1000px; height:100%; cursor:pointer" onclick="agregarHabitacion('.$arrData[$i]['idhabitacion'].',\''.$arrData[$i]['nombre_habitacion'].'\','.$arrData[$i]['capacidad'].','.$arrData[$i]['precio_dia'].')"><p style="color:transparent;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)">AGREGAR HABITACION</p></a>';
            }else if($arrData[$i]['estado_habitacion'] == 'Ocupada'){
                $idreservacion = $this->model->verReserva($arrData[$i]['idhabitacion']);
                $btnSelect .= '<a style="background:transparent;color:white;cursor:pointer" onclick="verReserva('.$idreservacion.')">VER</a>';
            }
            $arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		die();
     }

     public function getRoomsReservHoras(){
        $arrData = $this->model->selectHabitacionHoras();
        for($i=0; $i < count($arrData); $i++){
            $btnSelect = '';
            $btnSelect .= '<a style="background:transparent; width:1000px; height:100%; cursor:pointer" onclick="agregarHabitacionHoras('.$arrData[$i]['idhabitacion'].',\''.$arrData[$i]['nombre_habitacion'].'\','.$arrData[$i]['capacidad'].','.$arrData[$i]['precio_hora'].')"><p style="color:transparent;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)">AGREGAR HABITACION</p></a>';
            $arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		die();
    }

     public function delReservation()
     {
        $id_reservacion = intval($_POST['id_reservacion']);
        $requestDelete = $this->model->deleteReservation($id_reservacion);
       
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha anulado correctamente la reservacion');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al anular la reservacion, la habitacion esta ocupada');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
     }

     public function getReservations(){
        $arrData = $this->model->selectReservations();

        for($i=0; $i < count($arrData); $i++) {
            $btnSelect   = '';
            $btnEdit = '';
            $btnDelet = '';
            $btnPrint = '';


            if($arrData[$i]['voucher_electronico_id'] == 1){
                $btnPrint .= ' <a title="Imprimir" href="'.base_url().'/prints/facturares?id='.$arrData[$i]['id_reservacion'].'" target="_blank" style="color:black">
                <i class="fa-solid fa-print"></i>
                   </a>';
            }if($arrData[$i]['voucher_electronico_id'] == 2){
                $btnPrint .= ' <a title="Imprimir" href="'.base_url().'/prints/boletares?id='.$arrData[$i]['id_reservacion'].'" target="_blank" style="color:black">
                <i class="fa-solid fa-print"></i>
                   </a>';
            }else if($arrData[$i]['voucher_electronico_id'] == 3){
                $btnPrint .= ' <a title="Imprimir" href="'.base_url().'/prints/ticketres?id='.$arrData[$i]['id_reservacion'].'" target="_blank" style="color:black">
                <i class="fa-solid fa-print"></i>
                   </a>';
            }

            
				
            $btnSelect .= '<a class="btnSelectHabitacion" onclick="viewReservacion('.$arrData[$i]['id_reservacion'].')" title="Detalle" style="color: black;cursor:pointer;"><i style="color: #2c8ef8;" class="dripicons-plus"></i></a>';
            $btnEdit .= '<a style="border:none; background:transparent;" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg" onclick="fntEditReservacion('.$arrData[$i]['id_reservacion'].')" title="Editar Reservacion"><i style="color:#0F4B81" class="dripicons-pencil"></i></a>';
            $btnDelet .= '<a style="border:none; background:transparent;color:red;" onclick="AnularReservacion('.$arrData[$i]['id_reservacion'].')" title="Eliminar Reservacion"><i class="fa-solid fa-trash"></i></a>';
           
            $arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.' '.$btnPrint.' '.$btnEdit.' '.$btnDelet.'</div>';
        }
          
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
     }

     public function getSelectCategoryRoomsTotal(){
        $arrData = $this->model->roomsReservation();
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
     }

     public function getReservationId(int $idreservation){
          $idreservation = intval(strclean($idreservation));
          if($idreservation > 0){
            $arrData = $this->model->selectReservationId($idreservation);
            if(empty($arrData)){
                $arrResponse = array('status'=>false,'msg'=>'Datos no encontrados');
            }else{
                $arrResponse = array('status'=>true,'data'=>$arrData);
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
          }
     }

     public function setReservations(){
        $idreservation = $_POST['idreservacion'];
        $start_date    = $_POST['ingreso'];
        $end_date      = $_POST['salida'];
        $origin_reservation = intval($_POST['origen_reserva']);
        $customer       = $_POST['huesped'];
        $status       = $_POST['estados_reservaciones'];
        $idroom = $_POST['idhabitacion'];
        $price  = $_POST['total_reserva'];
        $created = date("Y-m-d H:i:s");
        $fecha_reserva = date("Y-m-d H:i:s");
        // $priceRoom = $_POST['total_habitacion'];
        $option = '';

                if($status == 2){
                    $today = date("Y-m-d H:i:s");
                    if(!isset($start_date) && !isset($end_date)){
                        $request_reservation = $this->model->updateReservationHoy($idreservation,$_POST['ingreso'],$_POST['salida'],$status,$origin_reservation,$customer, $today);
                        $option = 2;
                    }else{
                        $request_reservation = $this->model->updateReservationHoy($idreservation,$start_date,$end_date,$status,$origin_reservation,$customer, $today);
                        $option = 2;
                    }
    
                }else{
                    if(!isset($start_date) && !isset($end_date)){
                        $request_reservation = $this->model->updateReservation($idreservation,$_POST['ingreso'],$_POST['salida'],$status,$origin_reservation,$customer);
                        $option = 2;
                    }else{
                        $request_reservation = $this->model->updateReservation($idreservation,$start_date,$end_date,$status,$origin_reservation,$customer);
                        $option = 2;
                    }
                }
        
        if($request_reservation > 0){
            if($option == 1){
                $arrResponse = array('status' => true, 'msg' => 'Se realizo la reserva correctamente');
            }else{
                $arrResponse = array('status' => true, 'msg' => 'Se actualizo la reserva correctamente');
            }
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible generar la reserva');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();

     }
     public function setReservationsTarifas(){
        $idreservation = $_POST['idreservacion'];
        $tiempoDias = intval($_POST['diasTotal']);
        $tiempoHoras = intval($_POST['horasTotal']);
        $tiempoMinutos = intval($_POST['minutosTotal']);
        $start_date    = date("Y-m-d H:i:s");
        $origin_reservation = intval($_POST['origen_reserva']);
        $identificacion = $_POST['identificacion'];
        $customer       = $_POST['huesped'];
        $correo         = $_POST['correo'];
        $direccion         = $_POST['direccion'];
        $status       = $_POST['estados_reservaciones'];
        $idroom = $_POST['idhabitacion'];
        $price  = $_POST['total_reserva'];
        $priceRoom = $_POST['total_habitacion'];
        $tipoServicio = intval($_POST['idTarifas']);
        $option = '';
        if($idreservation == 0 || $idreservation == ''){
            $date = date("Y-m-d H:i:s");
            $end_date_result_dias = strtotime ( '+'.$tiempoDias.'day' , strtotime ($date) ) ; 
            $end_date_dias = date ( 'Y-m-d H:i:s' , $end_date_result_dias); 

            $end_date_result_horas = strtotime ( '+'.$tiempoHoras.'hour' , strtotime ($end_date_dias) ) ; 
            $end_date_horas = date ( 'Y-m-d H:i:s' , $end_date_result_horas);

            $end_date_result_minutos = strtotime ( '+'.$tiempoMinutos.'minute' , strtotime ($end_date_horas) ) ; 
            $end_date = date ( 'Y-m-d H:i:s' , $end_date_result_minutos); 

            $request_reservation = $this->model->insertReservation($start_date,$end_date,$status,$origin_reservation,$identificacion,$customer,$correo,$direccion,$idroom,$price, $priceRoom, $tipoServicio);
            $option = 1;            
        }
        if($request_reservation > 0){
            if($option == 1){
                $arrResponse = array('status' => true, 'msg' => 'Se realizo la reserva correctamente');
            }else{
                $arrResponse = array('status' => true, 'msg' => 'Se actualizo la reserva correctamente');
            }
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible generar la reserva');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
     }

     public function setAumentoDeReservacion(){
        // var_dump($_POST);
        $idreservacion = intval($_POST['idreservacion']);
        $tiempoDias = intval($_POST['diasTotal']);
        $tiempoHoras = intval($_POST['horasTotal']);
        $tiempoMinutos = intval($_POST['minutosTotal']);
        $tiempoAnterior = $_POST['fechaSalidaAnterior'];
        $price = floatval($_POST['total_aumento']);
        $tipoServicio = intval($_POST['idTarifas']);

        $option = '';
            $end_date_result_dias = strtotime ( '+'.$tiempoDias.'day' , strtotime ($tiempoAnterior) ) ; 
            $end_date_dias = date ( 'Y-m-d H:i:s' , $end_date_result_dias); 

            $end_date_result_horas = strtotime ( '+'.$tiempoHoras.'hour' , strtotime ($end_date_dias) ) ; 
            $end_date_horas = date ( 'Y-m-d H:i:s' , $end_date_result_horas);

            $end_date_result_minutos = strtotime ( '+'.$tiempoMinutos.'minute' , strtotime ($end_date_horas) ) ; 
            $end_date = date ( 'Y-m-d H:i:s' , $end_date_result_minutos); 

            $request_reservation = $this->model->insertAumentarEstadia($idreservacion, $price, $end_date, $tiempoDias, $tiempoHoras, $tiempoMinutos, $tipoServicio);
            $option = 1;   

        if($request_reservation > 0){
            if($option == 1){
                $arrResponse = array('status' => true, 'msg' => 'Se realizo la reserva correctamente');
            }else{
                $arrResponse = array('status' => true, 'msg' => 'Se actualizo la reserva correctamente');
            }
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible generar la reserva');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
     }

     public function cambiarEstado( $id_reservacion = null )
     {

        //  var_dump($_REQUEST['id']);
         $idreserva = substr($id_reservacion,-4,2);
        //  var_dump($idreserva);exit;
        $status = substr($id_reservacion,-1);
        $request_status_update = $this->model->updateStatus($idreserva, $status);
        if($request_status_update > 0) {
            $arrResponse = array('status' => true, 'msg' => 'Se cambia el estado correctamente');
        } else {
            $arrResponse = array("status" => false, "msg" => 'Oh ocurrio un error');
        }

        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
     }

     public function setPayReservations($idcomprobante)
     {
        // var_dump($_POST);
        $idReservationPayment = intval($_POST["idReservacion"]);
        $descripcion = $_POST['descripcion'];      
        $idUser = intval($_POST['idUser']);
        $total_pagos = floatval($_POST['total_pago']);
        $identificacion = $_POST['documento'];
        $option = '';

        if(isset($_POST['idmediopago']) && isset($_POST['totalPago'])){

            $medio_pago = $_POST["idmediopago"];
            $pagos_medio = $_POST['totalPago'];

            if($idcomprobante == 1){
                if(strlen($identificacion) != 11){
                    $arrResponse = array("status" => false, "msg" => 'Debe ingresar un RUC');
                }else{
                    $request_reservation_payment = $this->model->insertPaymentReservation($idReservationPayment,$descripcion,$medio_pago,$idcomprobante,$idUser,$pagos_medio,$total_pagos);
                    if($request_reservation_payment["exito"] == 0){
                        $arrResponse = array("status" => false, "msg" => $request_reservation_payment["mensaje"]);
                    }else{
                        $arrResponse = array('status' => true, 'msg' => 'Se realizo el pago correctamente');
                    }
                }
                
            }else if($idcomprobante == 2){
                if(strlen($identificacion) == 8 || strlen($identificacion) == 11){
                    if($total_pagos >= 700){
                        if($identificacion != '11111111'){
                            $request_reservation_payment = $this->model->insertPaymentReservation($idReservationPayment,$descripcion,$medio_pago,$idcomprobante,$idUser,$pagos_medio,$total_pagos);
                            if($request_reservation_payment["exito"] == 0){
                                $arrResponse = array("status" => false, "msg" => $request_reservation_payment["mensaje"]);
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Se realizo el pago correctamente');
                            }
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'Para Boletas a partir de S/. 700 require Ingresar Un Cliente');
                        }
                    }else{
                        $request_reservation_payment = $this->model->insertPaymentReservation($idReservationPayment,$descripcion,$medio_pago,$idcomprobante,$idUser,$pagos_medio,$total_pagos);

                        if($request_reservation_payment["exito"] == 0){
                            $arrResponse = array("status" => false, "msg" => $request_reservation_payment["mensaje"]);
                        }else{
                            $arrResponse = array('status' => true, 'msg' => 'Se realizo el pago correctamente');
                        }
                    }
                }else{
                    $arrResponse = array("status" => false, "msg" => 'Debe tener un numero de documento valido');
                }
            }else if($idcomprobante == 3){
                $request_reservation_payment = $this->model->insertPaymentReservation($idReservationPayment,$descripcion,$medio_pago,$idcomprobante,$idUser,$pagos_medio,$total_pagos);
                $arrResponse = array('status' => true, 'msg' => 'Se realizo el pago correctamente');
            }
        }else {
            $arrResponse = array("status" => false, "msg" => 'Debe ingresar un monto');
        }

        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();

     }

     public function getTipoComprobante(){
        $arrData = $this->model->selectTipoComprobante();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                // var_dump($arrData[$i]['id_tipo_comprobante']);
            }
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }


     public function getSelectCategoryRooms(int $idcategoria){
         $idcategoriaroom = intval($idcategoria);
         $arrData = $this->model->selectCategoryRoomId($idcategoriaroom);
         if(empty($arrData)){ 
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
          }else{
            $arrResponse = array('status' => true, 'data' => $arrData);
          }
          echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        
        die();

     }

     public function getRoomsReser(){
        $arrData = $this->model->selecthabitacion();

        for($i=0; $i < count($arrData); $i++) {
            $btnSelect   = '';
				
            $btnSelect .= '<a class="text-primary btnSelectHabitacion" onclick="agregarHabitacion('.$arrData[$i]['idhabitacion'].',\''.$arrData[$i]['nombre_habitacion'].'\''.',\''.$arrData[$i]['nombre_categoria_habitacion'].'\')" title="Seleccionar habitacion" style="color: black;cursor:pointer;"><i class="dripicons-plus"></i></a>';
            

            $arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    

     public function getOriginReservation(){
      $htmlOptions = "";
      $arrData = $this->model->selectOriginReservation();
      if(count($arrData) > 0){
          for($i=0; $i < count($arrData); $i++){
              $htmlOptions .= '<option value="'.$arrData[$i]['idorigen_reservacion'].'">'.$arrData[$i]['nombre'].'</option>';
          }
      }
      echo $htmlOptions;
      die();
     }

     public function getStatusReservation(){
        $htmlOptions = "";
        $arrData = $this->model->selectStatusReservation();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_reservacionestado'].'">'.$arrData[$i]['nombre'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
     }

     public function getCategoryRooms(){
      $htmlOptions = "";
      $arrData = $this->model->selectCategoryRoom();
      if(count($arrData) > 0){
          for($i=0; $i < count($arrData); $i++){
              $htmlOptions .= '<option value="'.$arrData[$i]['id_categoria_habitacion'].'">'.$arrData[$i]['nombre_categoria_habitacion'].'</option>';
          }
      }
      echo $htmlOptions;
      die();
     }

     
     public function getRooms(){
        $htmlOptions = "";
        $arrData = $this->model->selectRooms();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idhabitacion'].'">'.$arrData[$i]['nombre_habitacion'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
       }
  

     public function getRoomsPrices(int $idroom)
     {
         $IdRom = intval($idroom);
 
         if($IdRom > 0) //id valido
         {
             $arrData = $this->model->selectRoomsPrices($IdRom);
 
             if(empty($arrData)){
                 $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
             }else{
                 $arrResponse = array('status' => true, 'data' => $arrData);
             }
             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
         }
 
         die();
     }
     
    public function addClienteReservacion(int $idUsuario){
        $identificacion = strclean($_REQUEST['identificacion']);
        $nombre = strclean($_REQUEST['nombre']);
        $correo = strclean($_REQUEST['correo']);
        $direccion = strclean($_REQUEST['direccion']);
        $request_actualizar_cliente = $this->model->updateClienteReservacion($idUsuario, $identificacion, $nombre, $correo, $direccion);
            if($request_actualizar_cliente > 0){
                $arrResponse = array('status' => true, 'msg' => 'Se realizo la actualizacion del cliente');
            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible generar la actualizacion');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
    }
    public function setConsumo(){
        $usuario = $_POST["User"];
        $total_venta = $_POST["total_venta"];
        $total_impuesto = $_POST['impuestos_venta'];
        $subtotal_venta = $_POST['subtotal_venta'];
        $idproducto = $_POST["idarticulo"];
        $cantidad = $_POST["cantidad"];
        $precio_venta = $_POST["precio_venta"];
        $comprobante = 5;
        $option = '';
        

        if($cantidad !=null){
            if(isset($_POST['habitacionConsumo'])){
            $request_sales = $this->model->insertConsumo($usuario, $comprobante , $_POST['habitacionConsumo'],$subtotal_venta,$total_impuesto,$total_venta,$idproducto,$cantidad,$precio_venta);

            $arrDataId = $this->model->isDesConsumo();

            $arrResponse = array('status' => true, 'msg' => 'Se realizo el consumo correctamente', 'data' => $arrDataId);

            }else{
                $arrResponse = array('status' => false, 'msg' => 'No hay id de reserva');
            }
        }else{
            $arrResponse = array('status' => false, 'msg' => 'No hay cantidad');
        }
        
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
           die();
    }
    public function retonarConsumo(int $detalleConsumo){
        
        $idConsumo = intval($_POST['idConsumo']);
        $nombreUser = $_SESSION['userData']['nombres'];

        $requestDelete = $this->model->postRetonarConsumo($detalleConsumo, $idConsumo, $nombreUser);
       
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha anulado correctamente el producto');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
    }
    public function desecharConsumo(){
        $idReservacion = intval($_POST['idreserva_desechable']);
        $idDetalleConsumo = intval($_POST['iddetalle_desechable']);
        $idConsumo = intval($_POST['idconsumo_desechable']);
        $cantidadDesechada = intval($_POST['cantidadDesechada']);
        $descripcionDesechable = strClean($_POST['descripcion_desechable']);
        
        $requestDesechable = $this->model->postDesecharConsumo($idConsumo, $idDetalleConsumo, $cantidadDesechada, $descripcionDesechable);

        if($requestDesechable == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha desechado correctamente el consumo');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al desechar el consumo');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
    }
    public function almacenarDescuento(float $monto){
        if($monto == null){
            $monto = 0;
        }
        $idDeReserva = intval($_POST['idReserva']);
        $descuento = $monto;

        $request_descuento = $this->model->updateAlmacenarDescuento($idDeReserva, $descuento);
            if($request_descuento > 0){
                $arrResponse = array('status' => true, 'msg' => 'Se realizo el descuento');
            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible generar el descuento');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
    }
    public function actualizarPrecioReserva(float $descuento){
        $idReservation =  intval($_POST['id']);
        $request_descuento = $this->model->actualizarPrecioReserva($idReservation, $descuento);
        if($request_descuento > 0){
            $arrResponse = array('status' => true, 'msg' => 'Se elimino el descuento');
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible eliminar el descuento');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delAumentoEstadia(int $detalleConsumo){
        $idConsumo = intval($_POST['idConsumo']);
        $requestDelete = $this->model->deleteAumentoEstadia($detalleConsumo, $idConsumo);
       
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado correctamente el aumento de estadia');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el servicio');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
    }

    public function delServicio(int $idDetalleConsumo){
        $con = new Mysql();
        $idConsumo = intval($_POST['idConsumo']);

        $sql = "SELECT reservaid, cantidadActual FROM detalle_consumo WHERE id_detalle_consumo = $idDetalleConsumo AND consumoid = $idConsumo";
        $request = $con->buscar($sql);

        $idReservacion = $request['reservaid'];
        $cantidadDesechada = $request['cantidadActual'];
        $descripcionDesechable = 'SERVICIO ANULADO';

        $requestDelete = $this->model->postDesecharConsumo($idConsumo, $idDetalleConsumo, $cantidadDesechada, $descripcionDesechable);
       
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado correctamente el servicio');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el servicio');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
    }

 }


?>