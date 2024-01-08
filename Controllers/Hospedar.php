<?php 

class Hospedar extends Controllers{
    
    public function __construct(){
    session_start();
    if(empty($_SESSION['login'])){
        header('Location: '.base_url().'/login');
    }
    parent::__construct();
    }

    public function hospedar(){
        $data['page-frontend']="Hospedar";
        $data['page_tag']="Hospedar - Usqay  Hoteles";
        $data['page_id']=17;
        $data['page_title'] = "Hospedar - Usqay Hoteles";
        $data['page_functions_js'] = "functions_hospedar.js";
        $this->views->getView($this,"hospedar",$data);
    }

    public function hospedaje(){
        $data['page-frontend']="Hospedaje";
        $data['page_tag']="Hospedaje - Usqay  Hoteles";
        $data['page_id']=17;
        $data['page_title'] = "Hospedaje - Usqay Hoteles";
        $data['page_functions_js'] = "functions_hospedar.js";
        $this->views->getView($this,"hospedaje",$data);
    }

    public function show(){
        $data['page-frontend']="Reservacion";
        $data['page_tag']="Reservacion - Usqay  Hoteles";
        $data['page_title'] = "Reservacion - Usqay Hoteles";
        $data['page_functions_js'] = "functions_hospedar_show.js";
        $this->views->getView($this,"show",$data);
     }

    public function create(){
        $data['page-frontend']="Hospedar";
        $data['page_tag']="Hospedar - Usqay  Hoteles";
        $data['page_id']=17;
        $data['page_title'] = "Hospedar - Usqay Hoteles";
        $data['page_functions_js'] = "functions_hospedar_create.js";
        $this->views->getView($this,"create",$data);
    }
    public function getPisos(){
        
        $arrData=$this->model->selectVariosPisos();
        for($i=0; $i < count($arrData); $i++) {
            $btnSelect = "";

			$btnSelect .= '<a style="background:transparent;color:transparent" onclick="buscarHabitacionesPiso('.$arrData[$i]['idpiso'].',\''.$arrData[$i]['nombrepiso'].'\')"><p style="color:transparent;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);cursor:pointer">AGREGAR</p></a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';

      		}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			die();   
    }

    public function getHabitaciones(){
        $arrData = $this->model->listarHabitacion();

        for($i=0; $i < count($arrData); $i++){
            
            $btnSelect = "";
    
        	$btnSelect .= '<a style="background:transparent;color:transparent"onclick="aumentarEstadia('.$arrData[$i]['idhabitacion'].',\''.$arrData[$i]['nombre_habitacion'].'\','.$arrData[$i]['capacidad'].','.$arrData[$i]['precio_dia'].','.$arrData[$i]['precio_hora'].')"><p style="color:transparent;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);cursor:pointer">Aumentar</p></a>';
        
            $arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getIdHabitacion(int $idhabitacion){
        $idHabitacion = intval($idhabitacion);
        if($idHabitacion>0){
            $arrData = $this->model->buscarHabitacion($idHabitacion);
            if(empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            }else{
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getHabitacionPiso(int $idpiso){
        $id = $idpiso;
        $arrData = $this->model->buscarHabitaciones($id);

        for($i=0; $i < count($arrData); $i++) {
            $btnSelect   = '';

            if($arrData[$i]['estado_habitacion'] == 'Disponible'){
                $btnSelect .= '<a style="background:transparent;color:black;cursor:pointer" onclick="hospedarHabitacion('.$arrData[$i]['idhabitacion'].',\''.$arrData[$i]['nombre_habitacion'].'\','.$arrData[$i]['capacidad'].','.$arrData[$i]['precio_dia'].')">INGRESAR</a>';
            }else if($arrData[$i]['estado_habitacion'] == 'Ocupada'){
                $idreservacion = $this->model->verReserva($arrData[$i]['idhabitacion']);
                // var_dump($idreservacion);
                $btnSelect .= '<a style="background:transparent;color:black;cursor:pointer" onclick="verReserva('.$idreservacion.')">VER</a>';
            }else if($arrData[$i]['estado_habitacion'] == 'Mantenimiento'){
                $btnSelect .= '<a style="background:transparent;color:black;cursor:pointer" onclick="cambiarEstadoHabitacion('.$arrData[$i]['idhabitacion'].',\''.$arrData[$i]['nombre_habitacion'].'\','.$arrData[$i]['capacidad'].','.$arrData[$i]['precio_dia'].')">DISPOSICION</a>';
            }
            // $btnSelect .= '<a style="background:transparent;color:black;cursor:pointer" onclick="hospedarHabitacion('.$arrData[$i]['idhabitacion'].','.$arrData[$i]['nombre_habitacion'].','.$arrData[$i]['capacidad'].','.$arrData[$i]['precio_dia'].')">INGRESAR</a>';
		

            $arrData[$i]['options'] = '<div class="text-center">'.$btnSelect.'</div>';
      	}
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die(); 
    }


    public function habitacionDias(int $idhabitacion){
        $id = $idhabitacion;
        $arrData = $this->model->buscarHabitacionDia($id);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function habitacionExpress(int $idhabitacion){
        $id = $idhabitacion;
        $arrData = $this->model->buscarHabitacionExpress($id);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function preciosTarifa(int $tarifa){
        $idhabitacion = $_POST['id'];
        $arrData = $this->model->buscarPreciosTarifa($idhabitacion, $tarifa);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getbuscarHabitacionReserva(int $idhabitacion){
        $id = $idhabitacion;
        $arrData = $this->model->buscarHabitacionReserva($id);
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

   
}
?>