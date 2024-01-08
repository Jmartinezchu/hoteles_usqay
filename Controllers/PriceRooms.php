<?php 

class PriceRooms extends Controllers{
    
    public function __construct(){
    session_start();
    if(empty($_SESSION['login'])){
        header('Location: '.base_url().'/login');
    }
    parent::__construct();
    }

    public function priceRooms(){
        $data['page-frontend']="Precio Habitacion";
        $data['page_tag']="Precio de Habitacion - Usqay  Hoteles";
        $data['page_id']=16;
        $data['page_title'] = "Precio Habitacion - Usqay Hoteles";
        $data['page_functions_js'] = "functions_price_rooms.js";
        $this->views->getView($this,"priceRooms",$data);
    }
    public function priceDayHourRooms(){
        $data['page-frontend']="Precio Habitacion";
        $data['page_tag']="Precio de Habitacion - Usqay  Hoteles";
        $data['page_id']=16;
        $data['page_title'] = "Precio Habitacion - Usqay Hoteles";
        $data['page_functions_js'] = "functions_price_rooms_day_hour.js";
        $this->views->getView($this,"priceDayHourRooms",$data);
    }

    public function getVariosPrecios(){
        $arrData=$this->model->selectVariosPrecios();
        for($i=0; $i<count($arrData); $i++){
            $btnEdit='';
            $btnDelet='';
            if($arrData[$i]['estado']==1)
            {
                $arrData[$i]['estado']='<span>Activo</span>';
            }
            else
            {
                $arrData[$i]['estado']='<span>Inactivo</spand>';
            }
            
            $btnEdit = '<a onclick="EditPrecio('.$arrData[$i]['idPrecioHabitacion'].')"><i class="fa-solid fa-pencil"></i> </a>';

            $btnDelet = '<a style="color:red" onclick="DeletePrecio('.$arrData[$i]['idPrecioHabitacion'].')"><i class="fa-solid fa-trash"></i> </a>';  

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        
        
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

        }

        public function getVariosPreciosDayHour(){
            $arrData=$this->model->selectVariosPreciosDayHour();
            for($i=0; $i<count($arrData); $i++){
                $btnEdit='';
                $btnDelet='';
                if($arrData[$i]['estado']==1)
                {
                    $arrData[$i]['estado']='<span>Activo</span>';
                }
                else
                {
                    $arrData[$i]['estado']='<span>Inactivo</spand>';
                }
                
                $btnEdit = '<a onclick="EditPrecio('.$arrData[$i]['idPrecioHabitacion'].')"><i class="fa-solid fa-pencil"></i> </a>';
    
                $btnDelet = '<a style="color:red" onclick="DeletePrecio('.$arrData[$i]['idPrecioHabitacion'].')"><i class="fa-solid fa-trash"></i> </a>';  
    
                $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
            
            
            }
    
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
    
        }

    public function getUnPrecio(int $IdPrecio){

        $IdPrecio = intval(strClean($IdPrecio));

        $arrData = $this->model->selectUnPrecio($IdPrecio);

        if(empty($arrData)){
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        }else{
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function setPrecio(){

        $IdPrecio = intval($_POST['idPrecio']);
        $IdHabitacion = intval($_POST['idRoom']);
        $IdTarifa = intval($_POST['idTarifas']);
        $precio = floatval($_POST['price']);
        $dias = intval($_POST['days']);
        $horas = intval($_POST['hours']);
        $minutos = intval($_POST['minutes']);

        if($IdPrecio == 0){
            $request = $this->model->insertPrecio($IdHabitacion, $IdTarifa, $precio, $dias, $horas, $minutos);
            $option = 1;
        }else{
            $request = $this->model->updatePrecio($IdPrecio, $IdHabitacion, $IdTarifa, $precio, $dias, $horas, $minutos);
            $option = 2;
        }
        if($request > 0)
            {
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg'=> 'Datos guardados correctamente');
            }else {
                $arrResponse = array('status' => true, 'msg'=> 'Datos actualizados correctamente');
            }
           
        }else if($request == 'exist'){
            $arrResponse = array('status' => false, 'msg' =>'¡Atención! ya existe');
        }else{
            $arrResponse = array("status" => false, "msg" =>'No es posible guardar datos.'); 
        }
        
        echo json_encode($arrResponse, 
        JSON_UNESCAPED_UNICODE);
        die();
    
    }

    public function deletePrecio(){
        $IdPrecio = intval($_POST['idprecio']);
        $requestDelete = $this->model->deletePrecio($IdPrecio);
        if($requestDelete == 'ok'){
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Precio');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el precio');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getPrecio(){
        $htmlOptions="";
        $arrData=$this->model->selectVariosPrecios();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idPrecioHabitacion'].'">'.$arrData[$i]['precio'].'</option>';
            }
        }
    
        echo $htmlOptions;
        die();
    }


}
?>