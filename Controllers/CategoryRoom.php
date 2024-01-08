<?php 

class CategoryRoom extends Controllers{
    
    public function __construct(){
    session_start();
    if(empty($_SESSION['login'])){
        header('Location: '.base_url().'/login');
    }
    parent::__construct();
    }

    public function categoryRoom(){
        $data['page-frontend']="Categoria Habitacion";
        $data['page_tag']="Categoria de Habitacion - Usqay  Hoteles";
        $data['page_id']=15;
        $data['page_title'] = "Categoria Habitacion - Usqay Hoteles";
        $data['page_functions_js'] = "functions_categoryroom.js";
        $this->views->getView($this,"categoryRoom",$data);
    }

    public function getCategoryRooms(){
        $arrData=$this->model->selectCategoryRooms();
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
            
            $btnEdit = '<a onclick="EditCategoryRoom('.$arrData[$i]['id_categoria_habitacion'].')"><i class="fa-solid fa-pencil"></i> </a>';

            $btnDelet = '<a style="color:red" onclick="DeleteCategoryRoom('.$arrData[$i]['id_categoria_habitacion'].')"><i class="fa-solid fa-trash"></i> </a>';  

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        
        
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

        }

    public function getCategoryRoom(int $IdCategoriaHabitacion){

        $IdCategoriaHabitacion = intval(strClean($IdCategoriaHabitacion));

        $arrData = $this->model->selectCategoryRoom($IdCategoriaHabitacion);

        if(empty($arrData)){
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        }else{
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function setCategoryRoom(){

        $IdCategoria = intval($_POST['id_categoria_habitacion']);
        $Nombre = strClean($_POST['nombre_categoria_habitacion']);

        if($IdCategoria == 0){
            $request = $this->model->insertCategoryRoom($Nombre);
            $option = 1;
        }else{
            $request = $this->model->updateCategoryRoom($IdCategoria, $Nombre);
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

    public function deleteCategoryRooms(){
        $IdCategoria = intval($_POST['id_categoria_habitacion']);
        $requestDelete = $this->model->deleteCategoryRoom($IdCategoria);
        if($requestDelete == 'ok'){
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoria');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoria');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSelectCategoryRooms(){
        $htmlOptions="";
        $arrData=$this->model->selectCategoryRooms();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_categoria_habitacion'].'">'.$arrData[$i]['nombre_categoria_habitacion'].'</option>';
            }
        }
    
        echo $htmlOptions;
        die();
    }

}
?>