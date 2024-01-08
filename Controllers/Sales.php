<?php 
	require_once("Models/TProducto.php");

	class Sales extends Controllers {
		use TProducto;
		public function __construct(){
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			parent::__construct();
		}

		public function sales(){
			$data['page_tag'] = "Venta - Usqay Hoteles";
        	$data['page_title'] = "Venta - Usqay Hoteles";
        	$data['page_functions_js'] = "functions_ventas_list.js";
		
        	$this->views->getView($this,"sales",$data);
		}
		

		public function crear(){
        	$data['page_tag'] = "Venta - Usqay Hoteles";
        	$data['page_title'] = "Venta - Usqay Hoteles";
        	$data['page_functions_js'] = "functions_ventas_create.js";
			$data['comprobantes'] = $this->model->selectTipoComprobante();
			$data['products'] =  $this->model->productsList();
			$data['services'] =  $this->model->servicesList();
        	$this->views->getView($this,"crear",$data);
		}

		public function pago(){
        	$data['page_tag'] = "Venta - Usqay Hoteles";
        	$data['page_title'] = "Venta - Usqay Hoteles";
        	$data['page_functions_js'] = "functions_ventas_create.js";
        	$this->views->getView($this,"pago",$data);
		}

		public function electronicvoucher(){
			$data['page_tag'] = "Venta - Usqay Hoteles";
        	$data['page_title'] = "Venta - Usqay Hoteles";
        	$data['page_functions_js'] = "functions_ventas_create.js";
        	$this->views->getView($this,"electronicvoucher",$data);
		}


		public function comprobantes(){
        	$data['page_tag'] = "Venta - Usqay Hoteles";
        	$data['page_title'] = "Venta - Usqay Hoteles";
        	$data['page_functions_js'] = "functions_ventas_create.js";
        	$this->views->getView($this,"comprobantes",$data);
		}

		public function charge(){
        	$data['page_tag'] = "Venta - Usqay Hoteles";
        	$data['page_title'] = "Venta - Usqay Hoteles";
        	$data['page_functions_js'] = "functions_ventas_create.js";
        	$this->views->getView($this,"charge",$data);
		}

		public function consumo(){
			$data['page_frontend'] = "Venta";
        	$data['page_tag'] = "Venta - Usqay Hoteles";
        	$data['page_title'] = "Venta - Usqay Hoteles";
        	$data['page_functions_js'] = "functions_ventas_create.js";
        	$this->views->getView($this,"consumo",$data);
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

		public function getClientes(){
			$htmlOptions = "";
			$arrData = $this->model->selectClientes();
			if(count($arrData) > 0){
				for($i=0; $i < count($arrData); $i++){
					$htmlOptions .= '<option value="'.$arrData[$i]['idusuario'].'">'.$arrData[$i]['nombres'].' - '.$arrData[$i]['apellidos'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}

		public function getReservations(){
			$arrData = $this->model->roomsReservation();
			for($i=0; $i < count($arrData); $i++){
				$btnSelect = '';
				$btnSelect .= '<a style="background:transparent; width:1000px; height:100%; cursor:pointer" onclick="agregarConsumo('.$arrData[$i]['id_reservacion'].',\''.$arrData[$i]['nombre_habitacion'].'\','.$arrData[$i]['nombres'].')"><p style="color:transparent;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)">AGREGAR CONSUMO</p></a>';
				$arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getReservationsRooms(){
			$htmlOptions = "";
			$arrData = $this->model->roomsReservation();
			for($i=0; $i < count($arrData); $i++){
				$htmlOptions .= '<option value="'.$arrData[$i]['id_reservacion'].'">Habitacion '.$arrData[$i]['nombre_habitacion']. ' - '.$arrData[$i]['nombres'].'</option>';
			}
			echo $htmlOptions;
			die();
		}

		public function setSales(int $idcomprobante){

			$idventa = intval($_POST["idventa"]);
			$identificacion = $_POST['identificacion'];
			$nombre = $_POST['nombre_cliente'];
			$correo = $_POST['correo'];
			$direccion = $_POST['direccion'];
			$total_impuesto = $_POST['impuestos_venta'];
			$subtotal_venta = $_POST['subtotal_venta'];
			$total_venta = $_POST["total_venta"];
			$usuario = $_POST["User"];
			$idUsuarioLogeado = intval($_SESSION['userData']['idusuario']);
			$option = '';

			if(isset($_POST['idarticulo']) && isset($_POST['cantidad']) && isset($_POST['precio_venta'])){
				$idproducto = $_POST["idarticulo"];
				$cantidad = $_POST["cantidad"];
				$precio_venta = $_POST["precio_venta"];
				if(isset($_POST['idmediopago']) && isset($_POST['totalPago'])){
					$medio_pago = $_POST["idmediopago"];
					$pagos_medio = $_POST['totalPago'];
	
					if($idcomprobante == 1){
						if(strlen($identificacion) != 11){
							$arrResponse = array("status" => false, "msg" => 'Debe ingresar un RUC');
						}else{
							$request_sales = $this->model->insertSale($nombre,$identificacion,$correo,$direccion,$idproducto,$cantidad,$precio_venta,$idcomprobante,$medio_pago,$total_impuesto,$subtotal_venta,$total_venta,$pagos_medio,$usuario, $idUsuarioLogeado);

							if($request_sales["exito"] == 0){
								$arrResponse = array("status" => false, "msg" => $request_sales["mensaje"]);
							}else{
								$arrDataId = $this->model->idDescSale();
								$arrResponse = array('status' => true, 'msg' => 'Se realizo la venta correctamente', 'data' => $arrDataId);
							}
				
						}
					}else if($idcomprobante == 2){
						if(strlen($identificacion) == 8 || strlen($identificacion) == 11){
							if($total_venta >= 700){
								if($identificacion != '11111111'){
									$request_sales = $this->model->insertSale($nombre,$identificacion,$correo,$direccion,$idproducto,$cantidad,$precio_venta,$idcomprobante,$medio_pago,$total_impuesto,$subtotal_venta,$total_venta,$pagos_medio,$usuario, $idUsuarioLogeado);

									if($request_sales["exito"] == 0){
										$arrResponse = array("status" => false, "msg" => $request_sales["mensaje"]);
									}else{
										$arrDataId = $this->model->idDescSale();
										$arrResponse = array('status' => true, 'msg' => 'Se realizo la venta correctamente', 'data' => $arrDataId);
									}

								}else{
									$arrResponse = array("status" => false, "msg" => 'Para Boletas a partir de S/. 700 require Ingresar Un Cliente');
								}
							}else{
								$request_sales = $this->model->insertSale($nombre,$identificacion,$correo,$direccion,$idproducto,$cantidad,$precio_venta,$idcomprobante,$medio_pago,$total_impuesto,$subtotal_venta,$total_venta,$pagos_medio,$usuario, $idUsuarioLogeado);
								
								if($request_sales["exito"] == 0){
								$arrResponse = array("status" => false, "msg" => $request_sales["mensaje"]);
								}else{
									$arrDataId = $this->model->idDescSale();
									$arrResponse = array('status' => true, 'msg' => 'Se realizo la venta correctamente', 'data' => $arrDataId);
								}
							}
						}else{
							$arrResponse = array("status" => false, "msg" => 'Debe tener un numero de documento valido');
						}
					}else if($idcomprobante == 3){
						$request_sales = $this->model->insertSale($nombre,$identificacion,$correo,$direccion,$idproducto,$cantidad,$precio_venta,$idcomprobante,$medio_pago,$total_impuesto,$subtotal_venta,$total_venta,$pagos_medio,$usuario, $idUsuarioLogeado);

						$arrDataId = $this->model->idDescSale();
						$arrResponse = array('status' => true, 'msg' => 'Se realizo la venta correctamente', 'data' => $arrDataId);
					}
	
				}else{
					$arrResponse = array("status" => false, "msg" => 'Debe ingresar un monto');
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'Debe ingresar un articulo');
			}	
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
       		die();
		}


		public function getProductosStock(){
			$arrData = $this->model->selectProductosVenta();

			for($i=0; $i < count($arrData); $i++) {
				$btnSelect   = '';
				
				$btnSelect .= '<a style="background: transparent" class="btnSelectProductos" onclick="agregarProducto('.$arrData[$i]['productoid'].',\''.$arrData[$i]['nombre'].'\','.$arrData[$i]['precio_venta'].')" title="Seleccionar producto" style="color: transparent;cursor:pointer;"><i style="color:red" class="fa fa-plus fa-xl"></i></a>';
				

				$arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';
      		}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		// public function getVentas(){
		// 	$arrData = $this->model->selectVentas();

		// 	// var_dump($arrData);

		// 	for($i=0; $i < count($arrData); $i++) {
		// 		$btnDelet   = '';
		// 		$btnImprimir = '';
		// 		$btnEdit     = '';

		// 		if($arrData[$i]['tipo_comprobante'] == 1){
		// 			$btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/facturasales?id='.$arrData[$i]['idventa'].'" target="_blank" style="color:black">
		// 			<i style="color: #fd7e14;" class="dripicons-print"></i>
		// 		   	</a>';
		// 		}if($arrData[$i]['tipo_comprobante'] == 2){
		// 			$btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/boletasales?id='.$arrData[$i]['idventa'].'" target="_blank" style="color:black">
		// 			<i style="color: #fd7e14;" class="dripicons-print"></i>
		// 		   	</a>';
		// 		}else if($arrData[$i]['tipo_comprobante'] == 3){
		// 			$btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/ticketsales?id='.$arrData[$i]['idventa'].'" target="_blank" style="color:black">
		// 			<i style="color: #fd7e14;" class="dripicons-print"></i>
		// 			</a>';
		// 		}
				
		// 		$btnEdit .= '<button style="border:none; background:transparent;" onclick="fntEditVenta('.$arrData[$i]['idventa'].')" title="Editar Venta"><i  class="dripicons-pencil"></i></button>';
		// 		$btnDelet = '<button style="border:none; background:transparent;" onclick="AnularVenta('.$arrData[$i]['idventa'].')" title="Eliminar Venta"><i  class="mdi mdi-delete" style="color: #DC3545;"></i></button>';
		// 		$arrData[$i]['options'] = '<div class="text-center">'.$btnImprimir.'   '.$btnDelet.'</div>';
      	// 	}
		// 	echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		// 	die();
		// }

		public function getVentas(){
			$arrData = $this->model->selectVentas();

			for($i=0; $i < count($arrData); $i++) {
				$btnDelet   = '';
				$btnImprimir = '';
				$btnEdit     = '';

				// $btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/prints?id='.$arrData[$i]['idventa'].'" target="_blank" style="color:black">
				// <i class="fa-solid fa-print"></i>
				//    </a>';
				if($arrData[$i]['tipo_comprobante'] == 1){
								$btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/facturasales?id='.$arrData[$i]['idventa'].'" target="_blank" style="color:black">
								<i style="color: #fd7e14;" class="dripicons-print"></i>
							   	</a>';
							}if($arrData[$i]['tipo_comprobante'] == 2){
								$btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/boletasales?id='.$arrData[$i]['idventa'].'" target="_blank" style="color:black">
								<i style="color: #fd7e14;" class="dripicons-print"></i>
							   	</a>';
							}else if($arrData[$i]['tipo_comprobante'] == 3){
								$btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/ticketsales?id='.$arrData[$i]['idventa'].'" target="_blank" style="color:black">
								<i style="color: #fd7e14;" class="dripicons-print"></i>
								</a>';
							}
				$btnEdit .= '<button style="border:none; background:transparent;" onclick="fntEditVenta('.$arrData[$i]['idventa'].')" title="Editar Venta"><i class="fa-solid fa-pencil"></i></button>';
				$btnDelet = '<button style="border:none; background:transparent;" onclick="AnularVenta('.$arrData[$i]['idventa'].')" title="Eliminar Venta"><i class="fa-solid fa-trash"></i></button>';
				$arrData[$i]['options'] = '<div class="text-center">'.$btnImprimir.'   '.$btnDelet.'</div>';
      		}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delSale()
		{
			$idventa = intval($_POST['idventa']);
			$requestDelete = $this->model->deleteVenta($idventa);
			if($requestDelete == 'ok')
			{
				$arrResponse = array('status' => true, 'msg' => 'Se ha anulado correctamente la venta');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Error al anular venta');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getSalesId(int $idventa){
            $idventa = intval(strClean($idventa));
			if($idventa > 0){
				$arrData = $this->model->selectVentaId($idventa);
				if(empty($arrData)){
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}

		
		public function getProductoId(int $productoid)
		{
			$idProducto = intval(strClean($productoid));
			if($idProducto > 0){
				$arrData = $this->model->selectProductoVentaID($idProducto);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados. ');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);  
			}
	
		}




	}

?>