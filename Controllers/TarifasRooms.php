<?php 

class TarifasRooms extends Controllers{
    
    public function __construct(){
    session_start();
    if(empty($_SESSION['login'])){
        header('Location: '.base_url().'/login');
    }
    parent::__construct();
    }

    public function tarifasRooms(){
        $data['page-frontend']="Tarifas Habitacion";
        $data['page_tag']="Tarifas de Habitacion - Usqay  Hoteles";
        $data['page_id']=16;
        $data['page_title'] = "Tarifas Habitacion - Usqay Hoteles";
        $data['page_functions_js'] = "functions_tarifas_rooms.js";
        $this->views->getView($this,"tarifasRooms",$data);
    }

    public function getVariasTarifas(){
        $arrData=$this->model->selectVariasTarifas();
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
            
            $btnEdit = '<a onclick="EditTarifa('.$arrData[$i]['idTarifa'].')"><i class="fa-solid fa-pencil"></i> </a>';

            $btnDelet = '<a style="color:red" onclick="DeleteTarifa('.$arrData[$i]['idTarifa'].')"><i class="fa-solid fa-trash"></i> </a>';  

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        
        
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

        }

        public function getAllTarifas(){
            $arrData=$this->model->selectAllTarifas();
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
                
                $btnEdit = '<a onclick="EditTarifa('.$arrData[$i]['idTarifa'].')"><i class="fa-solid fa-pencil"></i> </a>';
    
                $btnDelet = '<a style="color:red" onclick="DeleteTarifa('.$arrData[$i]['idTarifa'].')"><i class="fa-solid fa-trash"></i> </a>';  
    
                $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
            
            
            }
    
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
    
            }

    public function getUnaTarifa(int $IdTarifa){

        $IdTarifa = intval(strClean($IdTarifa));

        $arrData = $this->model->selectUnaTarifa($IdTarifa);

        if(empty($arrData)){
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        }else{
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function setTarifa(){

        $IdTarifa = intval($_POST['idtarifa']);
        $Nombre = strClean($_POST['nombretarifa']);

        if($IdTarifa == 0){
            $request = $this->model->insertTarifa($Nombre);
            $option = 1;
        }else{
            $request = $this->model->updateTarifa($IdTarifa, $Nombre);
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

    public function deleteTarifa(){
        $IdTarifa = intval($_POST['idtarifa']);
        $requestDelete = $this->model->deleteTarifa($IdTarifa);
        if($requestDelete == 'ok'){
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Tarifa');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Tarifa');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getTarifas(){
        $htmlOptions="";
        $arrData=$this->model->selectVariasTarifas();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idTarifa'].'">'.$arrData[$i]['nombreTarifa'].'</option>';
            }
        }
    
        echo $htmlOptions;
        die();
    }
    public function getTarifasDayHour(){
        $htmlOptions="";
        $arrData=$this->model->selectVariasTarifasDayHour();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idTarifa'].'">'.$arrData[$i]['nombreTarifa'].'</option>';
            }
        }
    
        echo $htmlOptions;
        die();
    }

}
?>