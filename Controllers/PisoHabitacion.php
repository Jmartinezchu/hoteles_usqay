<?php 

class PisoHabitacion extends Controllers{
    
    public function __construct(){
    session_start();
    if(empty($_SESSION['login'])){
        header('Location: '.base_url().'/login');
    }
    parent::__construct();
    }

    public function pisoHabitacion(){
        $data['page-frontend']="Piso Habitacion";
        $data['page_tag']="Piso de Habitacion - Usqay  Hoteles";
        $data['page_id']=16;
        $data['page_title'] = "Piso Habitacion - Usqay Hoteles";
        $data['page_functions_js'] = "functions_pisohabitacion.js";
        $this->views->getView($this,"pisoHabitacion",$data);
    }

    public function getVariosPisos(){
        $arrData=$this->model->selectVariosPisos();
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
            
            $btnEdit = '<a onclick="EditPiso('.$arrData[$i]['idpiso'].')"><i class="fa-solid fa-pencil"></i> </a>';

            $btnDelet = '<a style="color:red" onclick="DeletePiso('.$arrData[$i]['idpiso'].')"><i class="fa-solid fa-trash"></i> </a>';  

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        
        
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

        }

    public function getUnPiso(int $IdPiso){

        $IdPiso = intval(strClean($IdPiso));

        $arrData = $this->model->selectUnPiso($IdPiso);

        if(empty($arrData)){
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        }else{
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function setPiso(){

        $IdPiso = intval($_POST['idpiso']);
        $Nombre = strClean($_POST['nombrepiso']);

        if($IdPiso == 0){
            $request = $this->model->insertPiso($Nombre);
            $option = 1;
        }else{
            $request = $this->model->updatePiso($IdPiso, $Nombre);
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

    public function deletePiso(){
        $IdPiso = intval($_POST['idpiso']);
        $requestDelete = $this->model->deletePiso($IdPiso);
        if($requestDelete == 'ok'){
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el piso');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el piso');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getPisos(){
        $htmlOptions="";
        $arrData=$this->model->selectVariosPisos();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idpiso'].'">'.$arrData[$i]['nombrepiso'].'</option>';
            }
        }
    
        echo $htmlOptions;
        die();
    }


}
?>