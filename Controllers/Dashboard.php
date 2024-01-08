<?php 
 
 class Dashboard extends Controllers {

    public function __construct() {
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
        getPermisos(1);

    }

    public function dashboard(){
        $data['page_frontend'] = "Dashboard";
        $data['page_title'] = "Dashboard - Usqay Hoteles";
        $data['page_tag'] = "Dashboard - Usqay";
        $data['page_functions_js'] = "functions_dashboard.js";
        
        $data['roles'] = $this->model->cantidadRoles();
        $data['usuarios'] = $this->model->cantidadUsuarios();
        $data['ultimosusuarios'] = $this->model->ultimosUsuarios();
        $data['monto_caja'] = $this->model->mountDayCash();
        $data['ultimasreservas'] = $this->model->ultimasReservas();
        $data['reservas'] = $this->model->cantidadReservas();
        $data['ventas'] = $this->model->cantidadVentas();
        $data['disponible'] = $this->model->roomsDisponibles();
        $data['ocupadas'] = $this->model->roomsOcupadas();
        $data['mantenimiento'] = $this->model->roomsMantenimiento();
        
        $anio = date('Y');
        $mes = date('m');
        $dia = date('d');

        $data['ventasMDia'] = $this->model->selectVentasMes($anio,$mes);

        $data['reservasMDia'] = $this->model->selectReservasMes($anio,$mes);


        $fecha = date('Y-m-d');
		
        $this->views->getView($this,"dashboard",$data);
    }


    
		public function salesMount()
		{
			if($_POST)
			{
				$grafica = "ventasMes";
				$nFecha = str_replace(" ","",$_POST['fecha']);
				$arrFecha = explode('-',$nFecha);
				$mes = $arrFecha[0];
				$anio = $arrFecha[1];
				$pagos = $this->model->selectVentasMes($anio,$mes);
                var_dump($pagos);
                // exit;
				$script = getFile("Template/Modals/grafica",$pagos);
				echo $script;
				die();
			}
		}

        
		public function reservasMount()
		{
			if($_POST)
			{
				$grafica = "pagosReservas";
				$nFecha = str_replace(" ","",$_POST['fecha']);
				$arrFecha = explode('-',$nFecha);
				$mes = $arrFecha[0];
				$anio = $arrFecha[1];
				$pagos = $this->model->selectReservasMes($anio,$mes);
                var_dump($pagos);
                // exit;
				$script = getFile("Template/Modals/grafica",$pagos);
				echo $script;
				die();
			}
		}

		// public function ventasMes(){
		// 	if($_POST){
		// 		$grafica = "ventasMes";
		// 		$nFecha = str_replace(" ","",$_POST['fecha']);
		// 		$arrFecha = explode('-',$nFecha);
		// 		$mes = $arrFecha[0];
		// 		$anio = $arrFecha[1];
		// 		$pagos = $this->model->selectVentasMes($anio,$mes);
		// 		$script = getFile("Template/Modals/grafica",$pagos);
		// 		echo $script;
		// 		die();
		// 	}
		// }
		public function ventasAnio(){
			if($_POST){
				$grafica = "ventasAnio";
				$anio = intval($_POST['anio']);
				$pagos = $this->model->selectVentasAnio($anio);
				$script = getFile("Template/Modals/grafica",$pagos);
				echo $script;
				die();
			}
		}


 }


?>