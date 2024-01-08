<?php

class CateServicio extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }
    
    public function cateservicio()
    {
        
        $data['page-frontend']="Categoria de servicios";
        $data['page_tag']="Categoria de Servicios - Usqay  Hoteles";
        $data['page_id']=3;
        $data['page_title'] = "Categoria de Servicios - Usqay Hoteles";
        $data['page_functions_js'] = "functions_cateservicio.js";
        $this->views->getView($this,"cateservicio",$data);
    }
    public function getCateServicio(){

        $arrData=$this->model->selectCateServicio();
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
            
            $btnEdit = '<a onclick="EditCategoria('.$arrData[$i]['idcategoria'].')"><i class="fa-solid fa-pencil"></i> </a>';

            $btnDelet = '<a color="red" onclick="eliminarCateServicio('.$arrData[$i]['idcategoria'].')"><i class="fa-solid fa-trash"></i> </a>';  

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        
        
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

        }

       

        // EXTRAER UNA CATEGORIA
       
     public function getCategoria(int $idcategoria)
     {
       $idCateServicio =  intval(strClean($idcategoria));

       
         $arrData = $this->model->selectCategoria($idCateServicio);

        
         if(empty($arrData)){ //vacio
           $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
         }else{
           $arrResponse = array('status' => true, 'data' => $arrData);
         }
         echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
       
       die();
     }    

        public function setCateServicio(){
       
        
            $IdCateServicio    = intval($_POST['idcategoria']);
            $Descripcion      = strClean($_POST['nombre']);
           
            if($IdCateServicio == 0)
            {
                $request = $this->model->insertCateServicio($Descripcion);
                $option = 1;
            }else{
                $request = $this->model->actualizarcategoria($IdCateServicio,$Descripcion);
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
        
        public function deleteCateServicio()
        {
            $idcategoria = intval($_POST['idcategoria']);
            $requestDelete = $this->model->deletCateServicio($idcategoria);
            if($requestDelete == 'ok')
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Categoria');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Servicio');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

 //EXTRAER CATEGORIA

 public function getSelectCateServicio(){
    $htmlOptions="";
    $arrData=$this->model->selectCateServicio();
    if(count($arrData) > 0){
        for($i=0; $i < count($arrData); $i++){
            $htmlOptions .= '<option value="'.$arrData[$i]['idcategoria'].'">'.$arrData[$i]['descripcion'].'</option>';
        }
    }

    echo $htmlOptions;
    die();
}


    }

?>