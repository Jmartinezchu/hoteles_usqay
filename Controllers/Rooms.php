<?php 
  
  class Rooms extends Controllers {

    public function __construct(){
        session_start();
        if(empty($_SESSION['login'])){
            header("Location ".base_url().'/login');
        }
        parent::__construct();
    }

    public function rooms(){
        $data['page_tag'] = "Habitacion - Usqay Hoteles";
        $data['page_title'] = "Habitacion - Usqay Hoteles";
        $data['page_frontend'] = "Habitaciones";
        $data['page_functions_js'] = "functions_rooms.js";
        $this->views->getView($this,"rooms",$data);
    }

    public function create(){
        $data['page_tag'] = "Habitacion - Usqay Hoteles";
        $data['page_title'] = "Habitacion - Usqay Hoteles";
        $data['page_frontend'] = "Crear Habitacion";
        $data['page_functions_js'] = "functions_rooms.js";
        $this->views->getView($this,"create",$data);
    }
    public function actualizarEstadoHabitacion(){
        $idhabitacion          = intval($_POST['idhabitacion']);
        $nombre      = strClean($_POST['nombre']);
        $estado   =  $_POST['estado'];
        
        $request_habitacion = $this->model->updateEstadoHabitacion($idhabitacion, $nombre, $estado);
        $option = 1;

        if($option == 1){
            $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
        }else{
            $arrResponse = array("status" => false, "msg" => 'Error al actualizar estado');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setHabitaciones(){
       
        $idhabitacion          = intval($_POST['idhabitacion']);
        $nombre      = strClean($_POST['nombre']);
        $categoria           = intval($_POST['categoria']);
        $estado   =  $_POST['estado'];
        $capacidad        = intval($_POST['capacidad']);
        $descripcion         = strClean($_POST['descripcion']);
        $piso = intval($_POST['piso']);
        
        if($idhabitacion == 0)
        {
            $request_habitacion = $this->model->insertHabitacion($nombre,$categoria,$estado,$capacidad,$descripcion,$piso);
            $option = 1;
        }else{
            $request_habitacion = $this->model->updateHabitacion($idhabitacion,$nombre,$categoria,$estado,$capacidad,$descripcion,$piso);
            $option = 2;
        }

        if($request_habitacion > 0)
        {
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
            }else {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            }
       
        }else{
            $arrResponse = array("status" => false, "msg" => 'Esta habitacion esta ocupada, no se puede editar');
        }
    
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();

    }

    public function getRoomsId(int $idhabitacion){

        $idHabitacion = intval($idhabitacion);
        if($idHabitacion > 0){
            $arrData = $this->model->selectRoomsId($idHabitacion);

            if(empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            }else{
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

  

    public function getRooms(){
        $arrData = $this->model->selecthabitacion();

        for($i=0; $i < count($arrData); $i++) {
            $btnDelet   = '';
            $btnEdit    = '';

            
            $btnEdit .= '<a style="border:none; background:transparent;" onclick="editRooms('.$arrData[$i]['idhabitacion'].')" title="Editar habitacion"><i class="fa-solid fa-pencil"></i></a>';

            $btnDelet = '<a style="border:none; background:transparent; color: red;" onclick="deleteRooms('.$arrData[$i]['idhabitacion'].')" title="Eliminar Habitacion"><i class="fa-solid fa-trash"></i></a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getHabitaciones(){
        $htmlOptions="";
        $arrData=$this->model->selectVariasHabitacion();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idhabitacion'].'">'.$arrData[$i]['nombre_habitacion'].'</option>';
            }
        }
    
        echo $htmlOptions;
        die();
    }


    public function deleteRooms(){
        $idhabitacion = intval($_POST['idhabitacion']);
        $requestDelete = $this->model->deleteRooms($idhabitacion);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado correctamente la habitacion ');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al elimina habitacion, esta reservada');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function allrooms(){
        $arrData = $this->model->TodoRooms();
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }
  }
 
?>