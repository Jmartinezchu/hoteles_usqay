<?php

class MedioPago extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }

    public function mediopago()
    {
        
        $data['page-frontend']="MedioPago";
        $data['page_tag']="Medio Pago - Usqay  Hoteles";
        $data['page_id']=3;
        $data['page_title'] = "Medio Pago - Usqay Hoteles"; 
        $data['page_functions_js'] = "functions_mediopago.js";
        $this->views->getView($this,"mediopago",$data);
    }

    public function getMedio(){

        $arrData=$this->model->selectMedio();
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
            
            $btnEdit = '<a onclick="editarMedio('.$arrData[$i]['idmediopago'].')"><i class="fa-solid fa-pencil"></i> </a>';

            $btnDelet = '<a style="color:red" onclick="eliminarMedio('.$arrData[$i]['idmediopago'].')"><i class="fa-solid fa-trash "></i> </a>';  

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        
        
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

        }

   // EXTRAER UNA Medio
       
   public function getMedio2(int $idmediopago)
   {
     $idMedioPago =  intval(strClean($idmediopago));

        
       $arrData = $this->model->selectMedio2($idMedioPago);

      
       if(empty($arrData)){ //vacio
         $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
       }else{
         $arrResponse = array('status' => true, 'data' => $arrData);
       }
       echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
     
     die();
   }   


   public function setMedio(){
       
        
    $idMedioPago    = intval($_POST['idmediopago']);
    $Nombre      = strClean($_POST['nombre']);
    
    if($idMedioPago == 0)
    {
        $request = $this->model->insertarMedio($Nombre);
        $option = 1;
    }else{
        $request = $this->model->actualizarMedio($idMedioPago,$Nombre);
        $option = 2;
    }

    if($request > 0)
    {
        if($option == 1)
        {
            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
        }else {
            $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
        }
   
    }else if($request == 'exist'){
        $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe');
    }else{
        $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
    }

    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    die();

}

    public function deleteMedio()
    {
        $idMedioPago = intval($_POST['idmediopago']);
        $requestDelete = $this->model->deletMedio($idMedioPago);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Medio de pago ');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar Medio Pago');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Extraer Medio Pago 

    public function getSelectMedio(){
        $htmlOptions="";
        $arrData=$this->model->selectMedio();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idmediopago'].'">'.$arrData[$i]['nombre'].'</option>';
            }
        }
    
        echo $htmlOptions;
        die();
    }

}
?>